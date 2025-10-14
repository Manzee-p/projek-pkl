<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * List semua laporan user (hanya milik user login)
     */
    public function index(Request $request)
    {
        $reports = Report::where('user_id', $request->user()->user_id)
                         ->latest()
                         ->get();

        return response()->json([
            'status' => 200,
            'message' => 'Data laporan berhasil diambil',
            'data' => $reports
        ], 200);
    }

    /**
     * Buat laporan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'prioritas' => 'required|in:rendah,sedang,tinggi,urgent',
            'deskripsi' => 'required|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('reports', 'public');
        }

        $report = Report::create([
            'user_id' => $request->user()->user_id,
            'judul' => $validated['judul'],
            'kategori' => $validated['kategori'],
            'prioritas' => $validated['prioritas'],
            'deskripsi' => $validated['deskripsi'],
            'lampiran' => $lampiranPath,
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'Laporan berhasil dikirim',
            'report_id' => $report->id,
        ], 201);
    }

    /**
     * Lihat detail laporan
     */
    public function show(Request $request, $id)
    {
        $report = Report::where('id', $id)
                        ->where('user_id', $request->user()->user_id)
                        ->firstOrFail();

        return response()->json([
            'status' => 200,
            'message' => 'Detail laporan berhasil diambil',
            'data' => $report
        ], 200);
    }

    /**
     * Update laporan (hanya user yang punya laporan)
     */
    public function update(Request $request, $id)
    {
        $report = Report::where('id', $id)
                        ->where('user_id', $request->user()->user_id)
                        ->firstOrFail();

        $validated = $request->validate([
            'judul' => 'sometimes|string|max:255',
            'kategori' => 'sometimes|string',
            'prioritas' => 'sometimes|in:rendah,sedang,tinggi,urgent',
            'deskripsi' => 'sometimes|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('lampiran')) {
            // Hapus file lama
            if ($report->lampiran) {
                Storage::disk('public')->delete($report->lampiran);
            }
            $validated['lampiran'] = $request->file('lampiran')->store('reports', 'public');
        }

        $report->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'Laporan berhasil diupdate',
            'data' => $report
        ], 200);
    }

    /**
     * Hapus laporan (hanya user yang punya laporan)
     */
    public function destroy(Request $request, $id)
    {
        $report = Report::where('id', $id)
                        ->where('user_id', $request->user()->user_id)
                        ->firstOrFail();

        // Hapus lampiran kalau ada
        if ($report->lampiran) {
            Storage::disk('public')->delete($report->lampiran);
        }

        $report->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Laporan berhasil dihapus'
        ], 200);
    }
}