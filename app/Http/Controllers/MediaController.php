<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    // GET /api/media?judul=inter&jenis=film&genre=sci&with_pengguna=1
    public function index(Request $request)
    {
        $media = Media::query()
            ->when($request->query('judul'), fn ($q, $v) => $q->where('judul', 'like', "%{$v}%"))
            ->when($request->query('jenis'), fn ($q, $v) => $q->where('jenis', $v))
            ->when($request->query('genre'), fn ($q, $v) => $q->where('genre', 'like', "%{$v}%"))
            ->when($request->boolean('with_pengguna'), fn ($q) => $q->with('pengguna'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return MediaResource::collection($media);
    }

    // GET /api/media/{media}  -> detail + pengguna yang memasukkan ke koleksi
    public function show(Media $media)
    {
        $media->load('pengguna');

        return new MediaResource($media);
    }

    // POST /api/media
    public function store(StoreMediaRequest $request): JsonResponse
    {
        $media = Media::create($request->validated());

        return (new MediaResource($media))
            ->additional(['message' => 'Media berhasil ditambahkan.'])
            ->response()
            ->setStatusCode(201);
    }

    // PUT|PATCH /api/media/{media}
    public function update(UpdateMediaRequest $request, Media $media)
    {
        $media->update($request->validated());

        return (new MediaResource($media))
            ->additional(['message' => 'Media berhasil diperbarui.']);
    }

    // DELETE /api/media/{media}
    public function destroy(Media $media): JsonResponse
    {
        $media->delete();   // baris pivot ikut terhapus (cascadeOnDelete)

        return response()->json(['message' => 'Media berhasil dihapus.']);
    }
}
