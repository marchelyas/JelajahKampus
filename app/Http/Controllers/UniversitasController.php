<?php

namespace App\Http\Controllers;

use App\Models\Universitas;
use Illuminate\Http\Request;

class UniversitasController extends Controller
{
    // Menampilkan semua universitas
    public function index()
    {
        $universitas = Universitas::all();
        return response()->json($universitas);
    }

    // Menampilkan satu universitas berdasarkan ID
    public function show($id_universitas)
    {
        // Menggunakan findOrFail untuk menangani error otomatis jika data tidak ditemukan
        $universitas = Universitas::findOrFail($id_universitas);

        return response()->json($universitas);
    }

    // Menambah universitas baru
    public function store(Request $request)
    {
        // Validasi input dari request
        $validatedData = $request->validate([
            'nama_universitas' => 'required|string|max:100',
            'akreditasi' => 'required|in:A,B,C',
            'lokasi' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        try {
            // Menyimpan universitas baru
            $universitas = Universitas::create($validatedData);

            // Mengembalikan response universitas yang baru ditambahkan
            return response()->json($universitas, 201);
        } catch (\Exception $e) {
            // Jika terjadi error saat menyimpan
            return response()->json(['error' => 'Gagal menambah universitas', 'message' => $e->getMessage()], 500);
        }
    }

    // Mengupdate data universitas
    public function update(Request $request, $id_universitas)
    {
        try {
            // Mencari universitas berdasarkan id_universitas
            $universitas = Universitas::findOrFail($id_universitas);

            // Validasi input
            $validatedData = $request->validate([
                'nama_universitas' => 'required|string|max:100',
                'akreditasi' => 'required|in:A,B,C',
                'lokasi' => 'required|string|max:255',
                'website' => 'nullable|url|max:255',
            ]);

            // Mengupdate universitas
            $universitas->update($validatedData);

            // Mengembalikan response universitas yang telah diupdate
            return response()->json($universitas);
        } catch (\Exception $e) {
            // Jika terjadi error saat memperbarui
            return response()->json(['error' => 'Gagal memperbarui universitas', 'message' => $e->getMessage()], 500);
        }
    }

    // Menghapus universitas
    public function destroy($id_universitas)
    {
        try {
            // Mencari universitas berdasarkan id_universitas
            $universitas = Universitas::findOrFail($id_universitas);

            // Menghapus universitas
            $universitas->delete();

            // Mengembalikan response bahwa universitas telah dihapus
            return response()->json(['message' => 'Universitas deleted successfully']);
        } catch (\Exception $e) {
            // Jika terjadi error saat menghapus
            return response()->json(['error' => 'Gagal menghapus universitas', 'message' => $e->getMessage()], 500);
        }
    }
}
