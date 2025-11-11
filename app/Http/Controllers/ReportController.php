<?php
namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Prioritas;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Tampilkan daftar laporan sesuai role
     */
    public function index(Request $request)
    {
        $user  = $request->user();
        $query = Report::query();

        if ($user->role === 'admin') {
            // Admin melihat semua laporan
            $reports = $query->latest()->paginate(10);
            $view    = 'admin.report.index';
        } elseif ($user->role === 'tim_teknisi') {
            // Tim teknisi melihat laporan yang ditugaskan ke mereka
            $reports = $query->where('assigned_to', $user->user_id)->latest()->paginate(10);
            $view    = 'admin.teknisi.index';
        } elseif ($user->role === 'tim_konten') {
            // Tim konten melihat laporan yang ditugaskan ke mereka
            $reports = $query->where('assigned_to', $user->user_id)->latest()->paginate(10);
            $view    = 'admin.konten.index';
        } else {
            // User biasa hanya melihat laporan miliknya
            $reports = $query->where('user_id', $user->user_id)->latest()->paginate(10);
            $view    = 'report.index';
        }

        return view($view, compact('reports'));
    }

    /**
     * Form membuat laporan baru
     */
    public function create()
    {
        $user      = auth()->user();
        $kategoris = Kategori::all();
        $prioritas = Prioritas::all();
        $teknisis  = collect();
        $kontens   = collect();

        if ($user->role === 'admin') {
            $teknisis = User::where('role', 'tim_teknisi')->get();
            $kontens  = User::where('role', 'tim_konten')->get();
        }

        if ($user->role === 'admin') {
            $view = 'admin.report.create';
        } else {
            $view = 'report.create';
        }

        return view($view, compact('kategoris', 'prioritas', 'teknisis', 'kontens'));
    }

    /**
     * Simpan laporan baru
     */
    // ... di dalam ReportController

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

    if ($request->hasFile('lampiran')) {
        $validated['lampiran'] = $request->file('lampiran')->store('reports', 'public');
    }

    $validated['user_id'] = $request->user()->user_id;
    $validated['status'] = 'pending'; // default

    Report::create($validated);

        $user = auth()->user();
        if ($user->role === 'admin') {
            $route = 'admin.report.index';
        } elseif ($user->role === 'tim_teknisi') {
            $route = 'admin.teknisi.index';
        } elseif ($user->role === 'tim_konten') {
            $route = 'admin.konten.index';
        } else {
            $route = 'report.index';
        }

        return redirect()->route($route)->with('success', 'Laporan berhasil dikirim!');
    }

    /**
     * Detail laporan
     */
    public function show($id)
    {
        $user  = auth()->user();
        $query = Report::query();

        if ($user->role === 'admin') {
            $report = $query->findOrFail($id);
            $view   = 'admin.report.show';
        } elseif ($user->role === 'tim_teknisi') {
            $report = $query->where('assigned_to', $user->user_id)->findOrFail($id);
            $view   = 'admin.teknisi.show';
        } elseif ($user->role === 'tim_konten') {
            $report = $query->where('assigned_to', $user->user_id)->findOrFail($id);
            $view   = 'admin.konten.show';
        } else {
            $report = $query->where('user_id', $user->user_id)->findOrFail($id);
            $view   = 'report.show';
        }

        return view($view, compact('report'));
    }

    /**
     * Form edit laporan
     */
    public function edit($id)
    {
        $user  = auth()->user();
        $query = Report::query();

        if ($user->role === 'admin') {
            $report = $query->findOrFail($id);
            $view   = 'admin.report.edit';
        } elseif ($user->role === 'tim_teknisi') {
            $report = $query->where('assigned_to', $user->user_id)->findOrFail($id);
            $view   = 'admin.teknisi.edit';
        } elseif ($user->role === 'tim_konten') {
            $report = $query->where('assigned_to', $user->user_id)->findOrFail($id);
            $view   = 'admin.konten.edit';
        } else {
            $report = $query->where('user_id', $user->user_id)->findOrFail($id);
            $view   = 'report.edit';
        }

        $kategoris  = Kategori::all();
        $priorities = Prioritas::all();
        $teknisis   = collect();
        $kontens    = collect();

        if ($user->role === 'admin') {
            $teknisis = User::where('role', 'tim_teknisi')->get();
            $kontens  = User::where('role', 'tim_konten')->get();
        }

        return view($view, compact('report', 'kategoris', 'priorities', 'teknisis', 'kontens'));
    }

    /**
     * Update laporan
     */
    public function update(Request $request, $id)
{
    $user  = auth()->user();
    $report = Report::query();

    if ($user->role === 'admin') {
        $report = $report->findOrFail($id);
    } elseif (in_array($user->role, ['tim_teknisi', 'tim_konten'])) {
        $report = $report->where('assigned_to', $user->user_id)->findOrFail($id);
    } else {
        $report = $report->where('user_id', $user->user_id)->findOrFail($id);
    }

    if ($user->role === 'admin') {
        $this->updateAsAdmin($request, $report);
    } elseif (in_array($user->role, ['tim_teknisi', 'tim_konten'])) {
        $this->updateAsTeam($request, $report);
    } else {
        $this->updateAsUser($request, $report);
    }

    return redirect()->route($this->getRedirectRoute())
        ->with('success', 'Laporan berhasil diperbarui!');
}

// Helper method untuk admin
    private function updateAsAdmin(Request $request, Report $report)
{
    $validated = $request->validate([
        'judul'        => 'required|string|max:255',
        'kategori_id'  => 'required|exists:kategoris,kategori_id',
        'prioritas_id' => 'required|exists:priorities,prioritas_id',
        'deskripsi'    => 'required|string',
        'lampiran'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'assigned_to'  => 'nullable|exists:users,user_id',
        'status'       => 'required|in:pending,diproses,selesai,ditolak',
    ]);

    $this->handleFileUpload($request, $report, $validated);
    $report->update($validated);
}

// Helper method untuk tim teknisi/konten
    private function updateAsTeam(Request $request, Report $report)
{
    $validated = $request->validate([
        'deskripsi' => 'required|string',
        'lampiran'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'status'    => 'required|in:diproses,selesai', // teknisi hanya 2 pilihan
    ]);

    $report->deskripsi = $validated['deskripsi'];
    $report->status    = $validated['status']; // update status

    if ($request->hasFile('lampiran')) {
        if ($report->lampiran && Storage::disk('public')->exists($report->lampiran)) {
            Storage::disk('public')->delete($report->lampiran);
        }
        $report->lampiran = $request->file('lampiran')->store('reports', 'public');
    }

    $report->save();
}

// Helper method untuk user biasa
    private function updateAsUser(Request $request, Report $report)
{
    $validated = $request->validate([
        'judul'        => 'required|string|max:255',
        'kategori_id'  => 'required|exists:kategoris,kategori_id',
        'prioritas_id' => 'required|exists:priorities,prioritas_id',
        'deskripsi'    => 'required|string',
        'lampiran'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $this->handleFileUpload($request, $report, $validated);
    $report->update($validated);
}

// Helper untuk handle upload file
    private function handleFileUpload(Request $request, Report $report, array &$validated)
    {
        if ($request->hasFile('lampiran')) {
            if ($report->lampiran && Storage::disk('public')->exists($report->lampiran)) {
                Storage::disk('public')->delete($report->lampiran);
            }
            $validated['lampiran'] = $request->file('lampiran')->store('reports', 'public');
        }
    }

    private function getRedirectRoute()
    {
        $user = auth()->user();

        return match ($user->role) {
            'admin'       => 'admin.report.index',
            'tim_teknisi' => 'tim_teknisi.report.index',
            'tim_konten'  => 'tim_konten.report.index',
            default       => 'report.index',
        };
    }

    /**
     * Hapus laporan
     */
    public function destroy($id)
    {
        $user  = auth()->user();
        $query = Report::query();

        if ($user->role === 'admin') {
            $report = $query->findOrFail($id);
        } elseif (in_array($user->role, ['tim_teknisi', 'tim_konten'])) {
            $report = $query->where('assigned_to', $user->user_id)->findOrFail($id);
        } else {
            $report = $query->where('user_id', $user->user_id)->findOrFail($id);
        }

        if ($report->lampiran && Storage::disk('public')->exists($report->lampiran)) {
            Storage::disk('public')->delete($report->lampiran);
        }

        $report->delete();

        if ($user->role === 'admin') {
            $route = 'admin.report.index';
        } elseif ($user->role === 'tim_teknisi') {
            $route = 'admin.teknisi.index';
        } elseif ($user->role === 'tim_konten') {
            $route = 'admin.konten.index';
        } else {
            $route = 'report.index';
        }

        return redirect()->route($route)->with('success', 'Laporan berhasil dihapus!');
    }

    /**
     * Tentukan redirect sesuai role user
     */
}
