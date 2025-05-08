<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::with('prodi.jurusan.fakultas')
            ->orderBy('created_at', 'asc')
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $mahasiswa
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'nim' => 'required|numeric|digits:8|unique:mahasiswa',
            'nama' => 'required|min:3|max:100',
            'prodi_id' => 'required|exists:prodi,prodi_id',
            'alamat' => 'required',
            'angkatan' => 'required|numeric|min:2018|max:' . date('Y')
        ]);

        try {
            $mahasiswa = Mahasiswa::create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa berhasil ditambahkan',
                'data' => $mahasiswa
            ], 201);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                //'message' => 'Gagal menambahkan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $mahasiswa = Mahasiswa::with(['prodi.jurusan.fakultas'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $mahasiswa
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nim' => 'required|numeric|digits:8|unique:mahasiswa,nim,' . $id,
            'nama' => 'required|min:3|max:100',
            'prodi_id' => 'required|exists:prodi,prodi_id',
            'alamat' => 'required',
            'angkatan' => 'required|numeric|min:2018|max:' . date('Y')
        ]);

        try {
            $mahasiswa = Mahasiswa::findOrFail($id);
            $mahasiswa->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => $mahasiswa
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Mahasiswa::findOrFail($id)->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
