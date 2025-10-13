<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log; // Pastikan ini ada di atas
use Termwind\Components\Dd;

class UserController extends Controller
{
    //
    //
    /**
     * Menampilkan halaman daftar semua ruangan.
     */
    public function index(Request $request)
    {
        // Memulai query dasar
        $query = User::query();

        // Cek jika ada input pencarian dari form
        if ($request->filled('search')) {
            $search = $request->input('search');

            // Tambahkan kondisi pencarian ke query
            // Mencari di kolom 'name' ATAU 'username'
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%")
                ->orWhere('role', 'like', "%{$search}%")
                ->orWhere('jabatan', 'like', "%{$search}%");
        }

        // Ambil data hasil query, urutkan dari yang terbaru, dan batasi 10 per halaman
        $users = $query->latest()->paginate(5);

        // Mengirim data ke view
        return view('pages.user', ['users' => $users]);
    }

    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'SKPD', 'pegawai'])],
            'jabatan' => ['nullable', 'string', 'max:255'],
        ]);

        // 3. Buat record baru di database
        User::create($validatedData);

        // 4. Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'User baru berhasil ditambahkan!');
    }
    public function update(Request $request, User $user)
    {
        // Validasi data yang masuk
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'SKPD', 'pegawai'])],
            'jabatan' => ['nullable', 'string', 'max:255'],

        ]);
        if (!$request->filled('password')) {
            unset($validatedData['password']);
        }


        // Lakukan update pada data ruangan
        $user->update($validatedData);

        // Kembali dengan pesan sukses
        return back()->with('success', 'Data User berhasil diperbarui!');
    }
    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'Ruangan berhasil dihapus!');
    }
}
