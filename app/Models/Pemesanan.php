<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemesanan extends Model
{
    use HasFactory;
    protected $table = 'pemesanan';

    protected $primaryKey = 'id_pemesanan';
    protected $fillable = [
        'user_id',
        'id_ruangan',
        'nama_kegiatan',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];

    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}