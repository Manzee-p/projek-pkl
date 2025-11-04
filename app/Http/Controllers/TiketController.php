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
        $statuses  = \App\Models\TiketStatus::all();
        $kategoris = \App\Models\Kategori::all();
        $prioritas = \App\Models\Prioritas::all();

        // Return view untuk web
        return view('tiket.index', compact('tikets', 'statuses', 'kategoris', 'prioritas'));
    }

    public function adminIndex()
    {
        $tikets = Tiket::with(['status', 'kategori', 'event', 'prioritas', 'user'])->get();
        return view('admin.tiket.index', compact('tikets'));
    }

    public function create()
    {
        // Ambil data untuk dropdown di form admin
        $events    = \App\Models\Event::all();
        $kategoris = \App\Models\Kategori::all();
        $prioritas = \App\Models\Prioritas::all();
        $statuses  = \App\Models\TiketStatus::all();
        $users     = \App\Models\User::all(); // Admin bisa pilih user pembuat tiket

        return view('admin.tiket.create', compact('events', 'kategoris', 'prioritas', 'statuses', 'users'));
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
        $today      = Carbon::now()->format('Ymd');
        $countToday = Tiket::whereDate('waktu_dibuat', Carbon::today())->count() + 1;
        $kodeTiket  = 'TCK-' . $today . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);

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
        // Redirect ke halaman index dengan success message
        if (auth()->user()->role == 'admin') {
            return redirect()->route('admin.tiket.index')
                ->with('success', 'Tiket berhasil dibuat dengan kode: ' . $kodeTiket);
        }

        return redirect()->route('tiket.index')
            ->with('success', 'Tiket berhasil dibuat dengan kode: ' . $kodeTiket);

    }

    /**
     * Menampilkan detail tiket
     */
    public function show($id)
    {
        $tiket = Tiket::with(['user', 'event', 'kategori', 'prioritas', 'status'])
            ->where('tiket_id', $id)
            ->firstOrFail();

        // Cek role user
        if (auth()->user()->role == 'admin') {
            // Arahkan ke tampilan admin
            return view('admin.tiket.show', compact('tiket'));
        } else {
            // Arahkan ke tampilan user
            return view('tiket.show', compact('tiket'));
        }
    }

    public function edit($tiket_id)
    {
        $tiket = Tiket::with(['user', 'event', 'kategori', 'prioritas', 'status'])
            ->where('tiket_id', $tiket_id)
            ->firstOrFail();

        $users     = \App\Models\User::all();
        $events    = \App\Models\Event::all();
        $kategoris = \App\Models\Kategori::all();
        $prioritas = \App\Models\Prioritas::all();
        $statuses  = \App\Models\TiketStatus::all();

        return view('admin.tiket.edit', compact('tiket', 'users', 'events', 'kategoris', 'prioritas', 'statuses'));
    }

    /**
     * Menampilkan form edit tiket

     * Mengupdate tiket
     */
    public function update(Request $request, $tiket_id)
    {
        try {
            // Ambil tiket
            $query = Tiket::where('tiket_id', $tiket_id);

            // Kalau bukan admin, hanya boleh update tiket miliknya
            if (auth()->user()->role !== 'admin') {
                $query->where('user_id', auth()->id());
            }

            $tiket = $query->firstOrFail();

            // Validasi
            $validated = $request->validate([
                'event_id'      => 'nullable|exists:events,event_id',
                'kategori_id'   => 'nullable|exists:kategoris,kategori_id',
                'status_id'     => 'nullable|exists:tiket_statuses,status_id',
                'prioritas_id'  => 'nullable|exists:priorities,prioritas_id',
                'judul'         => 'nullable|string|max:255',
                'deskripsi'     => 'nullable|string',
                'assigned_to'   => 'nullable|string|max:255',
                'waktu_selesai' => 'nullable|date',
            ]);

            // Format waktu_selesai
            if (! empty($validated['waktu_selesai'])) {
                $validated['waktu_selesai'] = Carbon::parse($validated['waktu_selesai'])->format('Y-m-d H:i:s');
            }

            // Update field
            foreach ($validated as $key => $value) {
                if (! is_null($value)) {
                    $tiket->$key = $value;
                }
            }

            $tiket->save();

            // Redirect berdasarkan role
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.tiket.index')
                    ->with('success', 'Tiket berhasil diperbarui.');
            }

            return redirect()->route('tiket.show', $tiket->tiket_id)
                ->with('success', 'Tiket berhasil diperbarui.');

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
