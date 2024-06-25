<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPermintaanModel extends Model
{
    use HasFactory;
    protected $table = 'table_status_permintaan';

    protected $fillable = [
        'permintaan_id',
        'onproses',
        'pending',
        'selesai',
        'user_id',
    ];

    // Define the relationship with the Permintaan model
    public function permintaan()
    {
        return $this->belongsTo(PermintaanModel::class, 'permintaan_id');
    }

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
