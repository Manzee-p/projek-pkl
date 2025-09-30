<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'nama_event',
        'deskripsi',
        'area',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    public function tikets()
    {
        return $this->hasMany(Tiket::class);
    }
}
