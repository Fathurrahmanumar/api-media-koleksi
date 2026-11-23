<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Pengguna;
use Illuminate\Database\Seeder;

class FlipPlaySeeder extends Seeder
{
    public function run(): void
    {
        $daftar = [
            ['judul' => 'Interstellar', 'jenis' => 'film', 'genre' => 'Sci-Fi', 'tahun_rilis' => 2014, 'durasi_menit' => 169],
            ['judul' => 'Inception', 'jenis' => 'film', 'genre' => 'Sci-Fi', 'tahun_rilis' => 2010, 'durasi_menit' => 148],
            ['judul' => 'Breaking Bad', 'jenis' => 'series', 'genre' => 'Drama', 'tahun_rilis' => 2008, 'durasi_menit' => 47],
            ['judul' => 'Bohemian Rhapsody', 'jenis' => 'musik', 'genre' => 'Rock', 'tahun_rilis' => 1975, 'durasi_menit' => 6],
            ['judul' => 'Rintik Sedu', 'jenis' => 'podcast', 'genre' => 'Cerita', 'tahun_rilis' => 2020, 'durasi_menit' => 30],
        ];

        $media = collect($daftar)->map(fn ($m) => Media::firstOrCreate(['judul' => $m['judul']], $m));

        $budi = Pengguna::firstOrCreate(['email' => 'budi@example.com'], ['nama' => 'Budi']);
        Pengguna::firstOrCreate(['email' => 'sari@example.com'], ['nama' => 'Sari']);

        $budi->media()->syncWithoutDetaching([$media[0]->id, $media[2]->id]);
    }
}
