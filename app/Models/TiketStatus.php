<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiketStatus extends Model
{
    protected $table = 'tiket_status';

    protected $fillable = [
        'nama_status',
    ];

    public function tikets()
    {
        return $this->hasMany(Tiket::class);
    }
}
