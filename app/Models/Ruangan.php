<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruangan extends Model
{
    use HasFactory;
    protected $table = 'ruangan';
    protected $primaryKey = 'id_ruangan';
    protected $fillable = [
        'nama_ruangan',
        'kapasitas',
        'fasilitas',
        'lokasi',
        'status',
    ];
    public function pemesanans(): HasMany
    {
        return $this->hasMany(Pemesanan::class, 'id_ruangan', 'id_ruangan');
    }
}