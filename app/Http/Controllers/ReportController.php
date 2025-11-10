<?php
namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Kategori;
use App\Models\Prioritas;
use App\Models\User;
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
        $user = auth()->user();

        // ✅ Ambil data kategori & prioritas dari tabel
        $kategoris = \App\Models\Kategori::all();
        $prioritas = \App\Models\Prioritas::all();

        // ✅ Ambil user dengan role teknisi & konten (jika admin)
        $teknisis = collect();
        $kontens  = collect();

        if ($user->role === 'admin') {
            $teknisis = \App\Models\User::where('role', 'tim_teknisi')->get();
            $kontens  = \App\Models\User::where('role', 'tim_konten')->get();
        }

        // ✅ Tentukan view yang dipakai
        $view = $user->role === 'admin' ? 'admin.report.create' : 'report.create';

        // ✅ Kirim semua data ke view
        return view($view, compact('kategoris', 'prioritas', 'teknisis', 'kontens'));
    }

    /**
     * Simpan laporan baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'        => 'required|string|max:255',
            'kategori_id'  => 'required|exists:kategoris,kategori_id',
            'prioritas_id' => 'required|exists:priorities,prioritas_id',
            'deskripsi'    => 'required|string',
            'lampiran'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'assigned_to'  => 'nullable|exists:users,user_id',
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

    /**
     * Tampilkan detail laporan
     */
    public function show($id)
    {
        $user  = auth()->user();
        $query = Report::query();

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->user_id);
        }

        $report = $query->findOrFail($id);

        $view = $user->role === 'admin' ? 'admin.report.show' : 'report.show';
        return view($view, compact('report'));
    }

    /**
     * Form edit laporan
     */
    public function edit($id)
    {
        $user  = auth()->user();
        $query = Report::query();

        // Non-admin hanya bisa edit laporan miliknya
        if ($user->role !== 'admin') {
            $query->where('user_id', $user->user_id);
        }

        // Ambil laporan sesuai ID
        $report = $query->findOrFail($id);

        // Ambil semua kategori dan prioritas untuk dropdown
        $kategoris  = Kategori::all();
        $priorities = Prioritas::all();

        // Inisialisasi kosong agar tidak error di Blade
        $teknisis = collect();
        $kontens  = collect();

        // Hanya admin yang punya dropdown penugasan
        if ($user->role === 'admin') {
            $teknisis = User::where('role', 'tim_teknisi')->get();
            $kontens  = User::where('role', 'tim_konten')->get();
        }

        // Tentukan view berdasarkan role
        $view = $user->role === 'admin' ? 'admin.report.edit' : 'report.edit';

        // Kirim semua data ke view
        return view($view, compact('report', 'kategoris', 'priorities', 'teknisis', 'kontens'));
    }

    /**
     * Update laporan
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
            'judul'        => 'required|string|max:255',
            'kategori_id'  => 'required|exists:kategoris,kategori_id',
            'prioritas_id' => 'required|exists:priorities,prioritas_id',
            'deskripsi'    => 'required|string',
            'lampiran'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'assigned_to'  => 'nullable|exists:users,user_id',
        ]);

        // Upload baru
        if ($request->hasFile('lampiran')) {
            if ($report->lampiran && Storage::disk('public')->exists($report->lampiran)) {
                Storage::disk('public')->delete($report->lampiran);
            }
            $validated['lampiran'] = $request->file('lampiran')->store('reports', 'public');
        }

        // Penugasan hanya oleh admin
        if ($user->role === 'admin') {
            $report->assigned_to = $validated['assigned_to'] ?? null;
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

        if ($report->lampiran && Storage::disk('public')->exists($report->lampiran)) {
            Storage::disk('public')->delete($report->lampiran);
        }

        $report->delete();

        $route = $user->role === 'admin' ? 'admin.report.index' : 'report.index';
        return redirect()->route($route)->with('success', 'Laporan berhasil dihapus!');
    }
}
