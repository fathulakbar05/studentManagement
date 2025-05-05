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
        Schema::create('jurusan', function (Blueprint $table) {
            $table->id('jurusan_id');
            $table->string('nama', 50);
            $table->foreignId('fakultas_id')->constrained('fakultas', 'fakultas_id')->onDelete('cascade'); // onDelete itu biar kalo fakultas dihapus, jurusan juga ikut dihapus
            //foreignId('fakultas_id')->references('fakultas_id')->on('fakultas')->onDelete('cascade'); 
            
            $table->unique(['nama', 'fakultas_id']); // biar dak double nama jurusna di fakultasnya yg sama //bkn kolom baru 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusan');
    }
};
