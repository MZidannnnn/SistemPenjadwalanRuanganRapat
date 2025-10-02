<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Auth; // ✅ tambahkan ini

class PemesananController extends Controller
{
    public function index()
    {
        $ruangans = Ruangan::where('kondisi_ruangan', 'aktif')->get();
        $pemesanan = Pemesanan::all();
        return view('pages.pemesanan', compact('ruangans','pemesanan'));
    }

   public function store(Request $request)
{
    // 1. Gabungkan tanggal dan waktu dari input
    $request->merge([
        'waktu_mulai' => $request->tanggal . ' ' . $request->waktu_mulai,
        'waktu_selesai' => $request->tanggal . ' ' . $request->waktu_selesai,
    ]);

    // 2. Validasi data yang sudah digabungkan
    $validated = $request->validate([
        'ruangan_id'    => 'required|exists:ruangan,id',
        'nama_kegiatan' => 'required|string|max:255',
        'waktu_mulai'   => 'required|date|before:waktu_selesai',
        'waktu_selesai' => 'required|date|after:waktu_mulai',
    ]);

    // 3. Cek bentrok jadwal (kode Anda di sini sudah benar)
    $bentrok = Pemesanan::where('ruangan_id', $validated['ruangan_id'])
        ->where(function ($query) use ($validated) {
            // Logika pengecekan tumpang tindih
            $query->where('waktu_mulai', '<', $validated['waktu_selesai'])
                  ->where('waktu_selesai', '>', $validated['waktu_mulai']);
        })
        ->where('status', '!=', 'dibatalkan')
        ->exists();

    if ($bentrok) {
        return back()->withErrors(['ruangan_id' => 'Ruangan sudah dipesan pada rentang waktu tersebut!'])->withInput();
    }

    // 4. Simpan data
    Pemesanan::create([
        'user_id'       => Auth::id(),
        'ruangan_id'    => $validated['ruangan_id'],
        'nama_kegiatan' => $validated['nama_kegiatan'],
        'waktu_mulai'   => $validated['waktu_mulai'],
        'waktu_selesai' => $validated['waktu_selesai'],
        'status'        => 'dijadwalkan',
    ]);

    return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil dibuat!');
}
}
