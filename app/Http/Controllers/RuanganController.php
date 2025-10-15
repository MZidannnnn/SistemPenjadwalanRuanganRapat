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
    // app/Http/Controllers/RuanganController.php

    public function index(Request $request)
    {
        // Memulai query dasar
        $query = Ruangan::with('pemesanans');

        // Cek jika ada input pencarian
        if ($request->filled('search')) {
            // Pecah input pencarian menjadi array kata kunci, contoh: "tersedia aktif" -> ['tersedia', 'aktif']
            $keywords = explode(' ', strtolower($request->input('search')));

            // Siapkan array untuk menampung kata kunci pencarian teks biasa
            $generalSearchTerms = [];

            // Loop melalui setiap kata kunci
            foreach ($keywords as $keyword) {
                if (empty($keyword)) continue;

                // --- Terapkan filter khusus untuk status ---
                if ($keyword === 'tersedia') {
                    $query->whereDoesntHave('pemesanans', function ($q) {
                        $q->where('waktu_mulai', '<=', now())
                            ->where('waktu_selesai', '>=', now())
                            ->where('status', '!=', 'dibatalkan');
                    });
                } elseif (in_array($keyword, ['dipakai', 'berlangsung'])) {
                    $query->whereHas('pemesanans', function ($q) {
                        $q->where('waktu_mulai', '<=', now())
                            ->where('waktu_selesai', '>=', now())
                            ->where('status', '!=', 'dibatalkan');
                    });
                } else {
                    // Jika bukan kata kunci status, kumpulkan untuk pencarian teks biasa
                    $generalSearchTerms[] = $keyword;
                }
            }

            // --- Jalankan pencarian teks biasa jika ada kata kunci yang tersisa ---
            if (!empty($generalSearchTerms)) {
                // Gabungkan kembali kata kunci teks biasa, contoh: ['command', 'center'] -> "command center"
                $searchTerm = implode(' ', $generalSearchTerms);

                $query->where(function ($q) use ($searchTerm) {
                    $q->where('nama_ruangan', 'like', "%{$searchTerm}%")
                        ->orWhere('lokasi', 'like', "%{$searchTerm}%")
                        ->orWhere('fasilitas', 'like', "%{$searchTerm}%")
                        ->orWhere('kapasitas', 'like', "%{$searchTerm}%")
                        ->orWhere('kondisi_ruangan', 'like', "%{$searchTerm}%");
                });
            }
        }

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
