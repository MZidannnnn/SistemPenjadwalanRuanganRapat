<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Menampilkan form edit profile.
     */
    public function index()
    {
        return view('pages.profile'); // Anda tidak perlu mengirim variabel $user
    }

    /**
     * Meng-update profile user yang sedang login.
     */
    public function update(Request $request)
    {
        // 1. Ambil ID user yang login, lalu cari full model-nya di database
        $user = User::findOrFail(Auth::id());

        // 2. Validasi data (kode Anda di sini sudah benar)
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        // Hapus password dari array jika tidak diisi
        if (!$request->filled('password')) {
            unset($validatedData['password']);
        } else {
            // Jika diisi, hash password baru
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        // 3. Update user (sekarang akan berhasil)
        $user->update($validatedData);

        // 4. Redirect kembali
        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');
    }
}
