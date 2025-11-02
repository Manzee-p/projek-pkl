<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    /**
     * Menampilkan semua tiket dengan filter opsional
     * Untuk web view (bukan API)
     */
    public function index(Request $request)
    {
        // Query tiket milik user yang login
        $query = Tiket::with(['user', 'kategori', 'prioritas', 'status', 'event'])
            ->where('user_id', auth()->id()); // Hanya tiket user yang login

        // Filter opsional
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('prioritas_id')) {
            $query->where('prioritas_id', $request->prioritas_id);
        }

        // Sorting: Prioritas → Waktu terbaru
        $query->orderByRaw("
            CASE
                WHEN prioritas_id = 1 THEN 1
                WHEN prioritas_id = 2 THEN 2
                WHEN prioritas_id = 3 THEN 3
                ELSE 4
            END
        ")->orderByDesc('waktu_dibuat');

        $tikets = $query->get();

        // Data untuk dropdown filter
        $statuses = \App\Models\TiketStatus::all();
        $kategoris = \App\Models\Kategori::all();
        $prioritas = \App\Models\Prioritas::all();

        // Return view untuk web
        return view('tiket.index', compact('tikets', 'statuses', 'kategoris', 'prioritas'));
    }

    /**
     * Menyimpan tiket baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'      => 'required|exists:users,user_id',
            'event_id'     => 'required|exists:events,event_id',
            'kategori_id'  => 'required|exists:kategoris,kategori_id',
            'status_id'    => 'required|exists:tiket_statuses,status_id',
            'prioritas_id' => 'required|exists:priorities,prioritas_id',
            'judul'        => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
        ]);

        // Generate kode tiket otomatis
        $today = Carbon::now()->format('Ymd');
        $countToday = Tiket::whereDate('waktu_dibuat', Carbon::today())->count() + 1;
        $kodeTiket = 'TCK-' . $today . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);

        // Pastikan kode tiket unique
        while (Tiket::where('kode_tiket', $kodeTiket)->exists()) {
            $countToday++;
            $kodeTiket = 'TCK-' . $today . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);
        }

        $tiket = Tiket::create([
            'user_id'      => $request->user_id,
            'event_id'     => $request->event_id,
            'kategori_id'  => $request->kategori_id,
            'status_id'    => $request->status_id,
            'prioritas_id' => $request->prioritas_id,
            'judul'        => $request->judul,
            'deskripsi'    => $request->deskripsi,
            'kode_tiket'   => $kodeTiket,
            'waktu_dibuat' => now(),
        ]);

        $tiket->load(['user', 'kategori', 'prioritas', 'status', 'event']);

        // Redirect ke halaman index dengan success message
        return redirect()->route('tiket.index')->with('success', 'Tiket berhasil dibuat dengan kode: ' . $kodeTiket);
    }

    /**
     * Menampilkan detail tiket
     */
    public function show($tiket_id)
    {
        try {
            $tiket = Tiket::with(['user', 'kategori', 'prioritas', 'status', 'event'])
                ->where('tiket_id', $tiket_id)
                ->where('user_id', auth()->id()) // Hanya bisa lihat tiket sendiri
                ->firstOrFail();

            // Return view untuk web
            return view('tiket.show', compact('tiket'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('tiket.index')->with('error', 'Tiket tidak ditemukan atau Anda tidak memiliki akses');
        } catch (\Exception $e) {
            return redirect()->route('tiket.index')->with('error', 'Gagal mengambil detail tiket: ' . $e->getMessage());
        }
    }

    /**
     * Mengupdate tiket
     */
    public function update(Request $request, $tiket_id)
    {
        try {
            $tiket = Tiket::where('tiket_id', $tiket_id)
                ->where('user_id', auth()->id()) // Hanya bisa update tiket sendiri
                ->firstOrFail();

            $validated = $request->validate([
                'status_id'     => 'nullable|exists:tiket_statuses,status_id',
                'prioritas_id'  => 'nullable|exists:priorities,prioritas_id',
                'assigned_to'   => 'nullable|string|max:255',
                'waktu_selesai' => 'nullable|date',
            ]);

            if (!empty($validated['waktu_selesai'])) {
                try {
                    $validated['waktu_selesai'] = Carbon::parse($validated['waktu_selesai'])->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Format waktu_selesai tidak valid.');
                }
            }

            foreach ($validated as $key => $value) {
                if (!is_null($value)) {
                    $tiket->$key = $value;
                }
            }

            $tiket->save();
            $tiket->load(['user', 'kategori', 'prioritas', 'status', 'event']);

            return redirect()->route('tiket.show', $tiket->tiket_id)->with('success', 'Tiket berhasil diperbarui.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('tiket.index')->with('error', 'Tiket tidak ditemukan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus tiket
     */
    public function destroy($tiket_id)
    {
        try {
            $tiket = Tiket::where('tiket_id', $tiket_id)
                ->where('user_id', auth()->id()) // Hanya bisa hapus tiket sendiri
                ->firstOrFail();
            
            $tiket->delete();

            return redirect()->route('tiket.index')->with('success', 'Tiket berhasil dihapus');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('tiket.index')->with('error', 'Tiket tidak ditemukan');
        } catch (\Exception $e) {
            return redirect()->route('tiket.index')->with('error', 'Gagal menghapus tiket: ' . $e->getMessage());
        }
    }
}