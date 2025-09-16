<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RuanganController extends Controller
{
    //
    /**
     * Menampilkan halaman daftar semua ruangan.
     */
    public function index()
    {
        // Mengambil semua data dari tabel 'ruangan'
        $ruangans = Ruangan::all();

        // Mengirim data ke view
        return view('pages.ruangan', ['ruangans' => $ruangans]);
    }

    /**
     * Menyimpan data ruangan baru dari modal.
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk dari form
        $validatedData = $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'fasilitas' => 'required|string',
            'status' => 'required|in:tersedia,dalam perbaikan',
        ]);

        // Membuat record baru di database
        Ruangan::create($validatedData);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();

        return back()->with('success', 'Ruangan berhasil dihapus!');
    }
    public function update(Request $request, Ruangan $ruangan)
    {
        // Validasi data yang masuk
        $validatedData = $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'fasilitas' => 'required|string',
            'status' => 'required|in:tersedia,dalam perbaikan',
        ]);

        // Lakukan update pada data ruangan
        $ruangan->update($validatedData);

        // Kembali dengan pesan sukses
        return back()->with('success', 'Data ruangan berhasil diperbarui!');
    }
}
