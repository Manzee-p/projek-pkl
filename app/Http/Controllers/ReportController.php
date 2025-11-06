<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    
    public function index(Request $request)
    {
        $reports = Report::where('user_id', $request->user()->user_id)
                         ->latest()
                         ->paginate(10);

        // Cek apakah admin atau user biasa
        if ($request->user()->role === 'admin') {
            return view('admin.report.index', compact('reports'));
        }
        
        return view('report.index', compact('reports'));
    }

    public function create()
    {
        // Cek role user
        if (auth()->user()->role === 'admin') {
            return view('admin.report.create');
        }
        
        return view('report.create');
    }

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

        // Redirect berdasarkan role
        $route = auth()->user()->role === 'admin' ? 'admin.report.index' : 'report.index';
        
        return redirect()->route($route)
                ->with('success', 'Laporan berhasil dikirim!');
    }

    public function edit($id)
    {
        $report = Report::where('id', $id)
                        ->where('user_id', auth()->user()->user_id)
                        ->firstOrFail();

        // Cek role user
        if (auth()->user()->role === 'admin') {
            return view('admin.report.edit', compact('report'));
        }
        
        return view('report.edit', compact('report'));
    }

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

        // Redirect berdasarkan role
        $route = auth()->user()->role === 'admin' ? 'admin.report.index' : 'report.index';
        
        return redirect()->route($route)
                ->with('success', 'Laporan berhasil diupdate!');
    }

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

        // Redirect berdasarkan role
        $route = auth()->user()->role === 'admin' ? 'admin.report.index' : 'report.index';
        
        return redirect()->route($route)
                ->with('success', 'Laporan berhasil dihapus!');
    }
}