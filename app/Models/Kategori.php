<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{

    protected $table      = 'kategoris';
    protected $primaryKey = 'kategori_id'; // ganti sesuai kolom di DB
    public $incrementing  = true;

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function tikets()
    {
        return $this->hasMany(Tiket::class);
    }
}
