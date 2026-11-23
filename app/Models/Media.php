<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'judul', 'jenis', 'genre', 'tahun_rilis', 'durasi_menit', 'deskripsi',
    ];

    public function pengguna(): BelongsToMany
    {
        return $this->belongsToMany(Pengguna::class, 'media_pengguna', 'media_id', 'pengguna_id')
                    ->withTimestamps();
    }
}
