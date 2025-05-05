<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Prodi;

class DropdownController extends Controller
{
    /**
     * Mengambil semua data fakultas
     */
    public function getFakultas()
    {
        try {
            $fakultas = Fakultas::orderBy('fakultas_id')->get();
            return response()->json($fakultas);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve data'
            ], 500);
        }
    }

    /**
     * Mengambil jurusan berdasarkan fakultas
     */
    public function getJurusan($fakultas_id)
    {
        try {
            $jurusan = Jurusan::where('fakultas_id', $fakultas_id)
                
                ->get();
                
            return response()->json($jurusan);

        } catch (\Exception $e) {
            Log::error("Error: " . $e->getMessage()); // Log untuk melihat pesan error
            return response()->json([
                'error' => 'Failed to retrieve data',
                'message' => $e->getMessage() // Menampilkan pesan error yang lebih spesifik
            ], 500);
        }
    }

    /**
     * Mengambil prodi berdasarkan jurusan
     */
    public function getProdi($jurusan_id)
    {
        try {
            $prodi = Prodi::where('jurusan_id', $jurusan_id)
                ->orderBy('prodi_id')
                ->get();
                
            return response()->json($prodi);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve data'
            ], 500);
        }
    }

    /**
     * Versi alternatif dengan relasi Eloquent
     */
    public function getJurusanV2(Fakultas $fakultas)
    {
        return response()->json($fakultas->jurusan);
    }

    public function getProdiV2(Jurusan $jurusan)
    {
        return response()->json($jurusan->prodi);
    }
}
