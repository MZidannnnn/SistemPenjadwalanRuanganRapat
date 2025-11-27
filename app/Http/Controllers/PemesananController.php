<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePemesananRequest;
use App\Http\Requests\StorePemesananRequest;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    public function index(Request $request)
    {
        Pemesanan::where('status', 'dijadwalkan')
            ->where('waktu_selesai', '<', now())
            ->update(['status' => 'selesai']);

        // Memulai query dasar dengan relasi yang dibutuhkan
        $query = Pemesanan::with(['ruangan', 'user']);
        $user = Auth::user();

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('waktu_mulai', '=', $request->start_date);
        }

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

        // Ambil data ruangan untuk modal form
        $ruangans = Ruangan::where('kondisi_ruangan', 'aktif')->get();

        // Ambil hasil query pemesanan, urutkan, dan paginasi
        $pemesanan = $query->latest('waktu_mulai')->paginate(5);

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
    public function getScheduledDatesInMonth($year, $month)
    {
        $dates = Pemesanan::whereYear('waktu_mulai', $year)
            ->whereMonth('waktu_mulai', $month)
            ->where('status', '!=', 'dibatalkan') // Opsional: abaikan yang batal
            ->selectRaw('DATE(waktu_mulai) as event_date')
            ->distinct()
            ->pluck('event_date');

        return response()->json($dates);
    }
}
