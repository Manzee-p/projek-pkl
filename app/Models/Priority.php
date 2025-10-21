<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    protected $table = 'priorities';
    protected $primaryKey = 'prioritas_id';
    protected $fillable = ['nama_prioritas'];

    // Relasi ke Tiket (optional, jika ada)
    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'prioritas_id', 'prioritas_id');
    }
}
