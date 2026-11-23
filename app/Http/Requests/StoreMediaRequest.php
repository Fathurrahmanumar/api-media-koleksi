<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul'        => ['required', 'string', 'max:255', 'unique:media,judul'],
            'jenis'        => ['required', 'in:film,series,musik,podcast'],
            'genre'        => ['required', 'string', 'max:100'],
            'tahun_rilis'  => ['nullable', 'integer', 'between:1888,2100'],
            'durasi_menit' => ['nullable', 'integer', 'min:1'],
            'deskripsi'    => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul media wajib diisi.',
            'judul.unique'   => 'Judul media sudah ada, tidak boleh duplikat.',
            'jenis.required' => 'Jenis media wajib diisi.',
            'jenis.in'       => 'Jenis harus salah satu dari: film, series, musik, podcast.',
            'genre.required' => 'Genre wajib diisi.',
        ];
    }
}
