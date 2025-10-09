<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Pemesanan;
use Illuminate\Console\Command;

class UpdatePemesananStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-pemesanan-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Memperbarui status pemesanan yang sudah selesai';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        // Cari semua pemesanan yang statusnya masih 'dijadwalkan'
        // tapi waktu selesainya sudah lewat
        $pemesanans = Pemesanan::where('status', 'dijadwalkan')
            ->where('waktu_selesai', '<', Carbon::now())
            ->get();

        if ($pemesanans->count() > 0) {
            foreach ($pemesanans as $pemesanan) {
                $pemesanan->status = 'selesai';
                $pemesanan->save();
            }
            // Beri tahu di console bahwa ada data yang diupdate
            $this->info($pemesanans->count() . ' pemesanan telah diperbarui menjadi "selesai".');
        } else {
            $this->info('Tidak ada pemesanan yang perlu diperbarui.');
        }

        return 0;
    }
}
