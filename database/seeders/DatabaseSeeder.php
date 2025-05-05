<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Prodi;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            FakultasSeeder::class,
            JurusanSeeder::class,
            ProdiSeeder::class
        ]);
    }
}
