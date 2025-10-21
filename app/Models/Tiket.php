<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $fillable = [
        'user_id',
        'kategori_id',
        'prioritas_id',
        'status_id',
        'event_id',
        'judul',
        'deskripsi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kategoris()
    {
        return $this->belongsTo(Kategori::class, 'kategoris_id');
    }

    public function priorities()
    {
        return $this->belongsTo(Priority::class, 'priorities_id');
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
