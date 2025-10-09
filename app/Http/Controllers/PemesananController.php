<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePemesananRequest;
use App\Http\Requests\StorePemesananRequest;
use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    public function index()
    {
        Pemesanan::where('status', 'dijadwalkan')
            ->where('waktu_selesai', '<', now())
            ->update(['status' => 'selesai']);

        $ruangans = Ruangan::where('kondisi_ruangan', 'aktif')->get();
        $pemesanan = Pemesanan::with(['ruangan', 'user'])->get();
        return view('pages.pemesanan', compact('ruangans', 'pemesanan'));
    }

    public function store(StorePemesananRequest $request)
    {
        // 1. Validasi sudah berjalan secara otomatis di sini
        $validated = $request->validated();

        // 2. Simpan data
        Pemesanan::create([
            'user_id'       => Auth::id(),
            'ruangan_id'    => $validated['ruangan_id'],
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'waktu_mulai'   => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'status'        => 'dijadwalkan',
        ]);

        // 3. Redirect
        return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil dibuat!');
    }
    // public function store(Request $request)
    // {
    //     // 1. Gabungkan tanggal dan waktu dari input
    //     $request->merge([
    //         'waktu_mulai' => $request->tanggal . ' ' . $request->waktu_mulai,
    //         'waktu_selesai' => $request->tanggal . ' ' . $request->waktu_selesai,
    //     ]);

    //     // 2. Validasi data yang sudah digabungkan
    //     $validated = $request->validate([
    //         'ruangan_id'    => 'required|exists:ruangan,id',
    //         'nama_kegiatan' => 'required|string|max:255',
    //         'waktu_mulai'   => 'required|date|before:waktu_selesai',
    //         'waktu_selesai' => 'required|date|after:waktu_mulai',
    //     ]);

    //     // 3. Cek bentrok jadwal (kode Anda di sini sudah benar)
    //     $bentrok = Pemesanan::where('ruangan_id', $validated['ruangan_id'])
    //         ->where(function ($query) use ($validated) {
    //             // Logika pengecekan tumpang tindih
    //             $query->where('waktu_mulai', '<', $validated['waktu_selesai'])
    //                 ->where('waktu_selesai', '>', $validated['waktu_mulai']);
    //         })
    //         ->where('status', '!=', 'dibatalkan')
    //         ->exists();

    //     if ($bentrok) {
    //         return back()->withErrors(['ruangan_id' => 'Ruangan sudah dipesan pada rentang waktu tersebut!'], 'create')->withInput();
    //     }

    //     // 4. Simpan data
    //     Pemesanan::create([
    //         'user_id'       => Auth::id(),
    //         'ruangan_id'    => $validated['ruangan_id'],
    //         'nama_kegiatan' => $validated['nama_kegiatan'],
    //         'waktu_mulai'   => $validated['waktu_mulai'],
    //         'waktu_selesai' => $validated['waktu_selesai'],
    //         'status'        => 'dijadwalkan',
    //     ]);

    //     return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil dibuat!');
    // }
    public function getByDate($date)
    {
        $pemesanan = Pemesanan::with(['ruangan', 'user'])
            ->whereDate('waktu_mulai', $date)
            ->orderBy('waktu_mulai', 'asc')
            ->get();

        return response()->json($pemesanan);
    }
    public function destroy(Pemesanan $pemesanan)
    {
        $pemesanan->delete();

        return back()->with('success', 'Pemesanan berhasil dihapus!');
    }

    public function update(UpdatePemesananRequest $request, Pemesanan $pemesanan)
    {
        // 1. Ambil data yang sudah divalidasi oleh Form Request
        $validated = $request->validated();

        $updateData = [
            'ruangan_id'    => $validated['ruangan_id'],
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'waktu_mulai'   => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],

            'status' => 'dijadwalkan'
        ];
        if (isset($validated['status']) && $validated['status'] === 'dibatalkan') {
            $updateData['status'] = 'dibatalkan';
        } 


        $pemesanan->update($updateData);


        // 4. Redirect kembali ke halaman manajemen pemesanan dengan pesan sukses
        return redirect()->route('pemesanan.index')->with('success', 'Data pemesanan berhasil diperbarui!');
    }
}
