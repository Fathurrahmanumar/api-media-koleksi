<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => [
                'sometimes', 'required', 'string', 'max:255',
                Rule::unique('media', 'judul')->ignore($this->route('media')),
            ],
            'jenis'        => ['sometimes', 'required', 'in:film,series,musik,podcast'],
            'genre'        => ['sometimes', 'required', 'string', 'max:100'],
            'tahun_rilis'  => ['nullable', 'integer', 'between:1888,2100'],
            'durasi_menit' => ['nullable', 'integer', 'min:1'],
            'deskripsi'    => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul media tidak boleh dikosongkan.',
            'judul.unique'   => 'Judul media sudah dipakai media lain.',
            'jenis.in'       => 'Jenis harus salah satu dari: film, series, musik, podcast.',
        ];
    }
}
