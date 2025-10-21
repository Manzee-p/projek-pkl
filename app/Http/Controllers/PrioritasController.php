<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Priority;
use Illuminate\Support\Facades\Validator;

class PrioritasController extends Controller
{
    // Ambil semua data prioritas
    public function index()
    {
        $data = Priority::all();

        return response()->json([
            'status' => 200,
            'message' => 'Data prioritas tiket berhasil diambil',
            'data' => $data,
        ]);
    }

    // Tambah prioritas baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_prioritas' => 'required|string|max:50|unique:priorities,nama_prioritas',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ]);
        }

        $prioritas = Priority::create([
            'nama_prioritas' => $request->nama_prioritas,
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'Prioritas baru berhasil ditambahkan',
            'data' => $prioritas,
        ]);
    }

    // Update prioritas
    public function update(Request $request, $id)
    {
        $prioritas = Priority::find($id);

        if (!$prioritas) {
            return response()->json([
                'status' => 404,
                'message' => 'Prioritas tidak ditemukan',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'nama_prioritas' => 'required|string|max:50|unique:priorities,nama_prioritas,' . $id . ',prioritas_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ]);
        }

        $prioritas->update([
            'nama_prioritas' => $request->nama_prioritas,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Prioritas berhasil diperbarui',
            'data' => $prioritas,
        ]);
    }

    // Hapus prioritas
    public function destroy($id)
    {
        $prioritas = Priority::find($id);

        if (!$prioritas) {
            return response()->json([
                'status' => 404,
                'message' => 'Prioritas tidak ditemukan',
            ]);
        }

        $prioritas->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Prioritas berhasil dihapus',
        ]);
    }
}
