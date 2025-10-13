<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        // --- DATA UNTUK KARTU STATISTIK ---
        // (Logika kartu statistik Anda tetap sama)
        $ruanganDipesanIds = Pemesanan::where('waktu_mulai', '<=', now())
            ->where('waktu_selesai', '>=', now())
            ->where('status', 'dijadwalkan')
            ->pluck('ruangan_id')->unique();

        $jumlahRuanganTersedia = Ruangan::where('kondisi_ruangan', 'aktif')
            ->whereNotIn('id', $ruanganDipesanIds)
            ->count();

        $peminjamanHariIni = Pemesanan::whereDate('waktu_mulai', today())
            ->where('status', '!=', 'dibatalkan')
            ->count();

        $totalPemesanan = Pemesanan::where('status', '!=', 'dibatalkan')->count();


        // --- DATA UNTUK TABEL "JADWAL RUANGAN HARI INI" ---

        // Memulai query dasar untuk jadwal hari ini
        $query = Pemesanan::whereDate('waktu_mulai', today())
            ->with(['ruangan', 'user']);

        // Cek jika ada input pencarian
        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));

            // --- LOGIKA PENCARIAN STATUS VIRTUAL ---
            if (str_contains('dijadwalkan', $search)) {
                $query->where('status', 'dijadwalkan')->where('waktu_mulai', '>', now());
            } elseif (str_contains('berlangsung', $search)) {
                $query->where('status', 'dijadwalkan')
                    ->where('waktu_mulai', '<=', now())
                    ->where('waktu_selesai', '>=', now());
            } elseif (str_contains('selesai', $search)) {
                $query->where('status', 'selesai');
            } elseif (str_contains('dibatalkan', $search)) {
                $query->where('status', 'dibatalkan');
            }
            // --- LOGIKA PENCARIAN TEKS BIASA ---
            else {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_kegiatan', 'like', "%{$search}%")
                        ->orWhereHas('ruangan', function ($subQuery) use ($search) {
                            $subQuery->where('nama_ruangan', 'like', "%{$search}%");
                        })
                        ->orWhereHas('ruangan', function ($subQuery) use ($search) {
                            $subQuery->where('lokasi', 'like', "%{$search}%");
                        })
                        ->orWhereHas('user', function ($subQuery) use ($search) {
                            $subQuery->where('name', 'like', "%{$search}%");
                        });
                });
            }
        }

        // Jalankan query, urutkan, dan paginasi
        $jadwalHariIni = $query->orderBy('waktu_mulai', 'asc')->paginate(5);

        // --- KIRIM SEMUA DATA KE VIEW ---
        return view('pages.dashboard', [
            'jumlahRuanganTersedia' => $jumlahRuanganTersedia,
            'peminjamanHariIni'     => $peminjamanHariIni,
            'totalPemesanan'        => $totalPemesanan,
            'jadwalHariIni'         => $jadwalHariIni,
        ]);
    }
}
