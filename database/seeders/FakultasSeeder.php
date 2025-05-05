<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fakultas')->insert([
            ['nama' => 'Fakultas Kedokteran'],
            ['nama' => 'Fakultas Kesehatan Masyarakat'],
            ['nama' => 'Fakultas Teknik'],
            ['nama' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam'],
            ['nama' => 'Fakultas Pertanian'],
            ['nama' => 'Fakultas Keguruan dan Ilmu Pendidikan'],
            ['nama' => 'Fakultas Ilmu Komputer'],
            ['nama' => 'Fakultas Ekonomi'],
            ['nama' => 'Fakultas Ilmu Sosial dan Ilmu Politik'],
            ['nama' => 'Fakultas Hukum']
        ]);
    }
}
