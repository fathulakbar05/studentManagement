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
        Schema::create('prodi', function (Blueprint $table) {
            $table->id('prodi_id');
            $table->string('nama', 50);
            $table->foreignId('jurusan_id')->constrained('jurusan', 'jurusan_id')->onDelete('cascade'); // onDelete itu biar kalo jurusan dihapus, prodi juga ikut dihapus
            //foreignId('jurusan_id')->references('jurusan_id')->on('jurusan')->onDelete('cascade'); 
            
            $table->string('jenjang', 2)->default('S1'); // S1, D3, dll
            $table->unique(['nama', 'jurusan_id']); // biar dak double nama prodi di jurusannya yg sama //bkn kolom baru 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodi');
    }
};
