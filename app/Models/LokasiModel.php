<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LokasiModel extends Model
{
    use HasFactory;

    protected $table = 'master_lokasi';
    protected $fillable = ['locationname', 'user_id', 'floor_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lantai(): BelongsTo
    {
        return $this->belongsTo(LantaiModel::class, 'floor_id');
    }
}
