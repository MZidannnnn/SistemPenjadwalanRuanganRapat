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
    public function index(Request $request)
    {
        // Memulai query dasar
        $query = Ruangan::with('pemesanans');

        // Cek jika ada input pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            
            // Tambahkan kondisi pencarian ke query
            // Mencari di beberapa kolom sekaligus
            $query->where(function($q) use ($search) {
                $q->where('nama_ruangan', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('fasilitas', 'like', "%{$search}%")
                  ->orWhere('kapasitas', 'like', "%{$search}%")
                  ->orWhere('kondisi_ruangan', 'like', "%{$search}%");
            });
        }

        // Ambil data hasil query dan kirim ke view
        // $ruangans = $query->latest()->get(); // latest() untuk mengurutkan dari yang terbaru
        $ruangans = $query->latest()->paginate(5);
        
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
            'kondisi_ruangan' => 'required|string',
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
            'kondisi_ruangan' => 'required|string',
        ]);

        // Lakukan update pada data ruangan
        $ruangan->update($validatedData);

        // Kembali dengan pesan sukses
        return back()->with('success', 'Data ruangan berhasil diperbarui!');
    }
}
