<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusan = DB::table('jurusan')->where('nama', 'Teknik Informatika')->first();
        DB::table('prodi')->insert([
            [
                'nama' => 'Teknik Informatika',
                'jurusan_id' => $jurusan->jurusan_id,
                'jenjang' => 'S1'
            ]
        ]);

        $jurusan = DB::table('jurusan')->where('nama', 'Sistem Informasi')->first();
        DB::table('prodi')->insert([
            [
                'nama' => 'Sistem Informasi',
                'jurusan_id' => $jurusan->jurusan_id,
                'jenjang' => 'S1'
            ]
        ]);

        $jurusan = DB::table('jurusan')->where('nama', 'Sistem Komputer')->first();
        DB::table('prodi')->insert([
            [
                'nama' => 'Sistem Komputer',
                'jurusan_id' => $jurusan->jurusan_id,
                'jenjang' => 'S1'
            ]
        ]);

        $jurusan = DB::table('jurusan')->where('nama', 'Manajemen Informatika')->first();
        DB::table('prodi')->insert([
            [
                'nama' => 'Manajemen Informatika',
                'jurusan_id' => $jurusan->jurusan_id,
                'jenjang' => 'D3'
            ]
        ]);

        $jurusan = DB::table('jurusan')->where('nama', 'Budidaya Pertanian')->first();
        DB::table('prodi')->insert([
            [
                'nama' => 'Agronomi',
                'jurusan_id' => $jurusan->jurusan_id,
                'jenjang' => 'S1'
            ],
            [
                'nama' => 'Agroteknologi',
                'jurusan_id' => $jurusan->jurusan_id,
                'jenjang' => 'S1'
            ]
        ]);

        $jurusan = DB::table('jurusan')->where('nama', 'Tanah')->first();
        DB::table('prodi')->insert([
            [
                'nama' => 'Ilmu Tanah',
                'jurusan_id' => $jurusan->jurusan_id,
                'jenjang' => 'S1'
            ]
        ]);
    }
}
