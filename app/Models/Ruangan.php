<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;


class Ruangan extends Model
{
    use HasFactory;
    protected $table = 'ruangan';
    protected $fillable = [
        'nama_ruangan',
        'kapasitas',
        'fasilitas',
        'lokasi',
        'kondisi_ruangan',

    ];

    public function getStatusAttribute()
    {
        $isBookedNow = $this->pemesanans()
            ->where('waktu_mulai', '<=', Carbon::now())
            ->where('waktu_selesai', '>=', Carbon::now())
            ->exists();

        return $isBookedNow ? 'Sedang Dipakai' : 'Tersedia';
    }

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class);
    }

}
