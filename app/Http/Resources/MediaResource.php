<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'judul'        => $this->judul,
            'jenis'        => $this->jenis,
            'genre'        => $this->genre,
            'tahun_rilis'  => $this->tahun_rilis,
            'durasi_menit' => $this->durasi_menit,
            'deskripsi'    => $this->deskripsi,

            // relasi: hanya muncul jika di-load
            'pengguna' => PenggunaResource::collection($this->whenLoaded('pengguna')),

            // hanya muncul saat diambil lewat koleksi pengguna (data pivot)
            'ditambahkan_pada' => $this->whenPivotLoaded(
                'media_pengguna',
                fn () => $this->pivot->created_at
            ),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
