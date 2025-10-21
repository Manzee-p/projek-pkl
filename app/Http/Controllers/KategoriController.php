<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();

        return response()->json([
            'status'  => 200,
            'message' => 'Data kategori berhasil diambil',
            'data'    => $kategori,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
        ]);

        $kategori = Kategori::create($validated);

        return response()->json([
            'status'  => 201,
            'message' => 'Kategori berhasil dibuat',
            'data'    => $kategori,
        ]);
    }

    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);

        return response()->json([
            'status'  => 200,
            'message' => 'Detail kategori berhasil diambil',
            'data'    => $kategori,
        ]);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
        ]);

        $kategori->update($validated);

        return response()->json([
            'status'  => 200,
            'message' => 'Kategori berhasil diperbarui',
            'data'    => $kategori,
        ]);
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return response()->json([
            'status'  => 200,
            'message' => 'Kategori berhasil dihapus',
        ]);
    }
}
