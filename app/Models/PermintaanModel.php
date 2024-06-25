<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermintaanModel extends Model
{
    use HasFactory;
    protected $table = 'table_permintaan';

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'pelapor',
        'kendala',
        'kategori_id',
        'tingkat',
        'lokasi_id',
        'keterangan',
        'solusi',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id');
    }

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(LokasiModel::class, 'lokasi_id');
    }
}
