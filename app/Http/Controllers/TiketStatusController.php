<?php

namespace App\Http\Controllers;

use App\Models\TiketStatus;
use Illuminate\Http\Request;

class TiketStatusController extends Controller
{
    public function index()
    {
        $statuses = TiketStatus::all();

        return response()->json([
            'status'  => 200,
            'message' => 'Data status tiket berhasil diambil',
            'data'    => $statuses,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_status' => 'required|string|max:255',
        ]);

        $status = TiketStatus::create($validated);

        return response()->json([
            'status'  => 201,
            'message' => 'Status tiket berhasil dibuat',
            'data'    => $status,
        ]);
    }

    public function show($id)
    {
        $status = TiketStatus::findOrFail($id);

        return response()->json([
            'status'  => 200,
            'message' => 'Detail status tiket berhasil diambil',
            'data'    => $status,
        ]);
    }

    public function update(Request $request, $id)
    {
        $status = TiketStatus::findOrFail($id);

        $validated = $request->validate([
            'nama_status' => 'required|string|max:255',
        ]);

        $status->update($validated);

        return response()->json([
            'status'  => 200,
            'message' => 'Status tiket berhasil diperbarui',
            'data'    => $status,
        ]);
    }

    public function destroy($id)
    {
        $status = TiketStatus::findOrFail($id);
        $status->delete();

        return response()->json([
            'status'  => 200,
            'message' => 'Status tiket berhasil dihapus',
        ]);
    }
}
