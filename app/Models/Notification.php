<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $primaryKey = 'notif_id';
    
    protected $fillable = [
        'user_id',
        'tiket_id',
        'pesan',
        'waktu_kirim',
        'status_baca',
    ];

    protected $casts = [
        'status_baca' => 'boolean',
        'waktu_kirim' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id', 'tiket_id');
    }

    // Scope untuk notifikasi yang belum dibaca
    public function scopeUnread($query)
    {
        return $query->where('status_baca', false);
    }

    // Tandai sebagai sudah dibaca
    public function markAsRead()
    {
        $this->update(['status_baca' => true]);
    }
}