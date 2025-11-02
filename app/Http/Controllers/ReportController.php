<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    // ================== DAFTAR LAPORAN (TABEL) ==================
    public function index(Request $request)
    {
        $reports = Report::where('user_id', $request->user()->user_id)
                         ->latest()
                         ->paginate(10);

        return view('admin.report.index', compact('reports'));
    }

    // ================== FORM BUAT BARU ==================
    public function create()
    {
        return view('admin.report.create');
    }

    // ================== SIMPAN LAPORAN ==================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string',
            'prioritas' => 'required|in:rendah,sedang,tinggi,urgent',
            'deskripsi' => 'required|string',
            'lampiran'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')
                                    ->store('reports', 'public');
        }

        Report::create([
            'user_id'   => $request->user()->user_id,
            'judul'     => $validated['judul'],
            'kategori'  => $validated['kategori'],
            'prioritas' => $validated['prioritas'],
            'deskripsi' => $validated['deskripsi'],
            'lampiran'  => $lampiranPath,
        ]);

        return redirect('/admin/report')
                ->with('success', 'Laporan berhasil dikirim!');
    }

    // ================== FORM EDIT ==================
    public function edit($id)
    {
        $report = Report::where('id', $id)
                        ->where('user_id', auth()->user()->user_id)
                        ->firstOrFail();

        return view('admin.report.edit', compact('report'));
    }

    // ================== UPDATE LAPORAN ==================
    public function update(Request $request, $id)
    {
        $report = Report::where('id', $id)
                        ->where('user_id', $request->user()->user_id)
                        ->firstOrFail();

        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string',
            'prioritas' => 'required|in:rendah,sedang,tinggi,urgent',
            'deskripsi' => 'required|string',
            'lampiran'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Hapus lampiran lama kalau upload baru
        if ($request->hasFile('lampiran')) {
            if ($report->lampiran && Storage::disk('public')->exists($report->lampiran)) {
                Storage::disk('public')->delete($report->lampiran);
            }
            $validated['lampiran'] = $request->file('lampiran')
                                             ->store('reports', 'public');
        } else {
            $validated['lampiran'] = $report->lampiran;
        }

        $report->update($validated);

        return redirect('/admin/report')
                ->with('success', 'Laporan berhasil diupdate!');
    }

    // ================== HAPUS LAPORAN ==================
    public function destroy($id)
    {
        $report = Report::where('id', $id)
                        ->where('user_id', auth()->user()->user_id)
                        ->firstOrFail();

        // Hapus file
        if ($report->lampiran) {
            Storage::disk('public')->delete($report->lampiran);
        }

        $report->delete();

        return redirect('/admin/report')
                ->with('success', 'Laporan berhasil dihapus!');
    }
}