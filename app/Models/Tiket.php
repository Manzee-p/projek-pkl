<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $table      = 'tikets';
    protected $primaryKey = 'tiket_id';
    public $incrementing  = true;

    protected $fillable = [
        'user_id',
        'kategori_id',
        'prioritas_id',
        'status_id',
        'event_id',
        'judul',
        'deskripsi',
        'kode_tiket', // tambahkan ini
        'waktu_dibuat',
        'assigned_to',
        'waktu_selesai',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kategoris()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function priorities()
    {
        return $this->belongsTo(Priority::class, 'prioritas_id');
    }

    public function status()
    {
        return $this->belongsTo(TiketStatus::class, 'status_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
