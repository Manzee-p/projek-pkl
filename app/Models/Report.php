<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\Prioritas;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'judul',
        'kategori_id',
        'prioritas_id',
        'deskripsi',
        'lampiran',
        'assigned_to',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to', 'user_id');
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    }

    public function prioritas()
    {
        return $this->belongsTo(Prioritas::class, 'prioritas_id', 'prioritas_id');
    }

}
