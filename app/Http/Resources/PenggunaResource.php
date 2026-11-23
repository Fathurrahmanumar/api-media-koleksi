<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PenggunaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'nama'  => $this->nama,
            'email' => $this->email,
            'jumlah_media' => $this->whenCounted('media'),
            'media' => MediaResource::collection($this->whenLoaded('media')),
        ];
    }
}
