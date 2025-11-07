<?php
namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Tampilkan daftar report (berdasarkan role user)
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Admin bisa lihat semua, user hanya miliknya sendiri
        $reports = $user->role === 'admin'
            ? Report::latest()->paginate(10)
            : Report::where('user_id', $user->user_id)->latest()->paginate(10);

        $view = $user->role === 'admin' ? 'admin.report.index' : 'report.index';
        return view($view, compact('reports'));
    }

    /**
     * Tampilkan form buat laporan baru
     */
    public function create()
    {
        $view = auth()->user()->role === 'admin' ? 'admin.report.create' : 'report.create';
        return view($view);
    }

    /**
     * Simpan laporan baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string|max:100',
            'prioritas' => 'required|in:rendah,sedang,tinggi,urgent',
            'deskripsi' => 'required|string',
            'lampiran'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Simpan file lampiran jika ada
        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('reports', 'public');
        }

        $validated['user_id'] = $request->user()->user_id;

        Report::create($validated);

        $route = auth()->user()->role === 'admin' ? 'admin.report.index' : 'report.index';
        return redirect()->route($route)->with('success', 'Laporan berhasil dikirim!');
    }

    public function show($id)
    {
        $user  = auth()->user();
        $query = Report::query();

        // Jika bukan admin, user hanya bisa melihat laporan miliknya
        if ($user->role !== 'admin') {
            $query->where('user_id', $user->user_id);
        }

        $report = $query->findOrFail($id);

        // Tentukan view sesuai role
        $view = $user->role === 'admin' ? 'admin.report.show' : 'report.show';
        return view($view, compact('report'));
    }

    /**
     * Tampilkan form edit laporan
     */
    public function edit($id)
    {
        $user  = auth()->user();
        $query = Report::query();

        // User biasa hanya bisa edit laporannya sendiri
        if ($user->role !== 'admin') {
            $query->where('user_id', $user->user_id);
        }

        $report = $query->findOrFail($id);

        $view = $user->role === 'admin' ? 'admin.report.edit' : 'report.edit';
        return view($view, compact('report'));
    }

    /**
     * Update laporan yang ada
     */
    public function update(Request $request, $id)
    {
        $user  = $request->user();
        $query = Report::query();

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->user_id);
        }

        $report = $query->findOrFail($id);

        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string|max:100',
            'prioritas' => 'required|in:rendah,sedang,tinggi,urgent',
            'deskripsi' => 'required|string',
            'lampiran'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Jika upload file baru, hapus yang lama
        if ($request->hasFile('lampiran')) {
            if ($report->lampiran && Storage::disk('public')->exists($report->lampiran)) {
                Storage::disk('public')->delete($report->lampiran);
            }
            $validated['lampiran'] = $request->file('lampiran')->store('reports', 'public');
        }

        $report->update($validated);

        $route = $user->role === 'admin' ? 'admin.report.index' : 'report.index';
        return redirect()->route($route)->with('success', 'Laporan berhasil diperbarui!');
    }

    /**
     * Hapus laporan
     */
    public function destroy($id)
    {
        $user  = auth()->user();
        $query = Report::query();

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->user_id);
        }

        $report = $query->findOrFail($id);

        // Hapus lampiran jika ada
        if ($report->lampiran && Storage::disk('public')->exists($report->lampiran)) {
            Storage::disk('public')->delete($report->lampiran);
        }

        $report->delete();

        $route = $user->role === 'admin' ? 'admin.report.index' : 'report.index';
        return redirect()->route($route)->with('success', 'Laporan berhasil dihapus!');
    }
}
