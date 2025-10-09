<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemesanan extends Model
{
    use HasFactory;
    protected $table = 'pemesanan';
    protected $appends = ['status_raw'];
    protected $fillable = [
        'user_id',
        'ruangan_id',
        'nama_kegiatan',
        'waktu_mulai',
        'waktu_selesai',
        'status',

    ];
    /**
     * Relasi ke model User.
     * Laravel otomatis tahu foreign key-nya 'user_id'.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Ruangan.
     * Laravel otomatis tahu foreign key-nya 'ruangan_id'.
     */
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function getStatusAttribute($value)
    {
        // Prioritas pertama: jika statusnya 'dibatalkan', jangan diubah.
        if ($value === 'dibatalkan') {
            return 'Dibatalkan';
        }

        // Dapatkan waktu saat ini sesuai timezone aplikasi Anda
        $now = Carbon::now();

        // Parse waktu dari database menjadi objek Carbon
        $waktuMulai = Carbon::parse($this->waktu_mulai);
        $waktuSelesai = Carbon::parse($this->waktu_selesai);

        // Cek kondisi berdasarkan perbandingan waktu
        if ($now->isAfter($waktuSelesai)) {
            return 'Selesai';
        }

        if ($now->between($waktuMulai, $waktuSelesai)) {
            return 'Berlangsung';
        }

        // Jika tidak masuk kondisi di atas, berarti statusnya masih 'Dijadwalkan'
        return 'Dijadwalkan';
    }
    public function getStatusRawAttribute()
    {
        return $this->attributes['status'];
    }
}
