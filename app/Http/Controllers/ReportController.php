<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Create laporan baru
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

        // Simpan file jika ada
        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('reports', 'public');
        }

        $report = Report::create([
            'user_id' => $request->user()->id,
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
     * List semua laporan user (hanya laporan user login)
     */
    public function index(Request $request)
    {
        $reports = Report::where('user_id', $request->user()->user_id)->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Data laporan berhasil diambil',
            'data' => $reports
        ], 200);
    }
}