<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenggunaRequest;
use App\Http\Requests\TambahMediaKoleksiRequest;
use App\Http\Resources\MediaResource;
use App\Http\Resources\PenggunaResource;
use App\Models\Media;
use App\Models\Pengguna;
use Illuminate\Http\JsonResponse;

class PenggunaController extends Controller
{
    // GET /api/pengguna
    public function index()
    {
        return PenggunaResource::collection(Pengguna::withCount('media')->get());
    }

    // POST /api/pengguna
    public function store(StorePenggunaRequest $request): JsonResponse
    {
        $pengguna = Pengguna::create($request->validated());

        return (new PenggunaResource($pengguna))
            ->additional(['message' => 'Pengguna berhasil dibuat.'])
            ->response()
            ->setStatusCode(201);
    }

    // GET /api/pengguna/{pengguna}
    public function show(Pengguna $pengguna)
    {
        $pengguna->loadCount('media');

        return new PenggunaResource($pengguna);
    }

    // GET /api/pengguna/{pengguna}/koleksi  -> koleksi media milik pengguna
    public function koleksi(Pengguna $pengguna)
    {
        return MediaResource::collection($pengguna->media()->latest('media_pengguna.created_at')->paginate(10));
    }

    // POST /api/pengguna/{pengguna}/koleksi  -> CUSTOM ACTION: tambah media ke koleksi
    public function tambahMedia(TambahMediaKoleksiRequest $request, Pengguna $pengguna): JsonResponse
    {
        $mediaId = $request->validated()['media_id'];

        if ($pengguna->media()->where('media.id', $mediaId)->exists()) {
            return response()->json([
                'message' => 'Media sudah ada di koleksi pengguna ini.',
            ], 409);
        }

        $pengguna->media()->attach($mediaId);

        return response()->json([
            'message' => 'Media berhasil ditambahkan ke koleksi.',
            'data'    => new PenggunaResource($pengguna->loadCount('media')),
        ], 201);
    }

    // DELETE /api/pengguna/{pengguna}/koleksi/{media}  -> CUSTOM ACTION: hapus dari koleksi
    public function hapusMedia(Pengguna $pengguna, Media $media): JsonResponse
    {
        if (! $pengguna->media()->where('media.id', $media->id)->exists()) {
            return response()->json([
                'message' => 'Media tidak ada di koleksi pengguna ini.',
            ], 404);
        }

        $pengguna->media()->detach($media->id);

        return response()->json(['message' => 'Media berhasil dihapus dari koleksi.']);
    }
}
