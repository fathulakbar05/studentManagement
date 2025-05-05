<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id('mahasiswa_id');
            $table->char('nim', 8)->unique();
            $table->string('nama', 50);
            $table->foreignId('prodi_id')->constrained('prodi', 'prodi_id');
            //foreignId('prodi_id')->references('prodi_id')->on('prodi');
            $table->text('alamat');
            $table->year('angkatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
