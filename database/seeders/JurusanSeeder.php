<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fakultas = DB::table('fakultas')->where('nama', 'Fakultas Ilmu Komputer')->first();
    
        DB::table('jurusan')->insert([
            [
                'nama' => 'Teknik Informatika',
                'fakultas_id' => $fakultas->fakultas_id
            ],
            [
                'nama' => 'Sistem Informasi',
                'fakultas_id' => $fakultas->fakultas_id
            ],
            [
                'nama' => 'Sistem Komputer',
                'fakultas_id' => $fakultas->fakultas_id
            ],
            [
                'nama' => 'Manajemen Informatika',
                'fakultas_id' => $fakultas->fakultas_id
            ]
        ]);

        $fakultas = DB::table('fakultas')->where('nama', 'Fakultas Pertanian')->first();
        
        DB::table('jurusan')->insert([
            [
                'nama' => 'Budidaya Pertanian',
                'fakultas_id' => $fakultas->fakultas_id
            ],
            [
                'nama' => 'Tanah',
                'fakultas_id' => $fakultas->fakultas_id
            ]
        ]);
    }
}
