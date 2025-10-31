<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $primaryKey = 'tiket_id';
    protected $fillable = [
        'kode_tiket',
        'judul',
        'deskripsi',
        'user_id',
        'event_id',
        'kategori_id',
        'status_id',
        'prioritas_id',
        'assigned_to',
        'waktu_dibuat',
        'waktu_selesai'
    ];

    public $timestamps = false;

    // === RELASI ===
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    }

    public function status()
    {
        return $this->belongsTo(TiketStatus::class, 'status_id', 'status_id');
    }

    public function prioritas()
    {
        return $this->belongsTo(Prioritas::class, 'prioritas_id', 'prioritas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }
}
