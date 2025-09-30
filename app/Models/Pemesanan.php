<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemesanan extends Model
{
    use HasFactory;
    protected $table = 'pemesanan';
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

}