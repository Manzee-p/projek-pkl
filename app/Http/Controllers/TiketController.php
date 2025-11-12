<?php
namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Tiket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ->where('user_id', Auth::id()); // Hanya tiket user yang login

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
        $tikets = Tiket::with(['status', 'kategori', 'event', 'prioritas', 'user', 'assignedTo'])->get();
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

        // Ambil tim teknisi dan konten
        $timTeknisi = User::where('role', 'tim_teknisi')->get();
        $timKonten  = User::where('role', 'tim_konten')->get();

        return view('admin.tiket.create', compact('events', 'kategoris', 'prioritas', 'statuses', 'users', 'timTeknisi', 'timKonten'));
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
            'assigned_to'  => 'nullable|exists:users,user_id',
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
            'assigned_to'  => $request->assigned_to,
            'waktu_dibuat' => now(),
        ]);

        $tiket->load(['user', 'kategori', 'prioritas', 'status', 'event', 'assignedTo']);

        // 🔔 KIRIM NOTIFIKASI KE ADMIN
        // Hanya kirim notifikasi jika yang membuat adalah user biasa (bukan admin)
        if (Auth::user()->role !== 'admin') {
            $admins = User::where('role', 'admin')->get();

            foreach ($admins as $admin) {
                Notification::create([
                    'user_id'  => $admin->user_id,
                    'tiket_id' => $tiket->tiket_id,
                    'pesan'    => "Tiket baru #{$tiket->kode_tiket} telah dibuat oleh {$tiket->user->name}: {$tiket->judul}",
                    'waktu_kirim' => now(),
                    'status_baca' => false,
                ]);
            }
        }

        // 🔔 KIRIM NOTIFIKASI KE TIM YANG DITUGASKAN
        if ($request->assigned_to) {
            Notification::create([
                'user_id'  => $request->assigned_to,
                'tiket_id' => $tiket->tiket_id,
                'pesan'    => "Anda telah ditugaskan untuk menangani tiket #{$tiket->kode_tiket}: {$tiket->judul}",
                'waktu_kirim' => now(),
                'status_baca' => false,
            ]);
        }

        // Redirect ke halaman index dengan success message
        if (Auth::user()->role == 'admin') {
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
        $tiket = Tiket::with(['user', 'event', 'kategori', 'prioritas', 'status', 'assignedTo'])
            ->where('tiket_id', $id)
            ->firstOrFail();

        // Cek role user
        if (Auth::user()->role == 'admin') {
            // Arahkan ke tampilan admin
            return view('admin.tiket.show', compact('tiket'));
        } else {
            // Arahkan ke tampilan user
            return view('tiket.show', compact('tiket'));
        }
    }

    public function edit($tiket_id)
    {
        $tiket = Tiket::with(['user', 'event', 'kategori', 'prioritas', 'status', 'assignedTo'])
            ->where('tiket_id', $tiket_id)
            ->firstOrFail();

        $users     = \App\Models\User::all();
        $events    = \App\Models\Event::all();
        $kategoris = \App\Models\Kategori::all();
        $prioritas = \App\Models\Prioritas::all();
        $statuses  = \App\Models\TiketStatus::all();

        // Ambil tim teknisi dan konten untuk assignment
        $timTeknisi = User::where('role', 'tim_teknisi')->get();
        $timKonten  = User::where('role', 'tim_konten')->get();

        // 🔹 Cek role user
        if (Auth::user()->role === 'admin') {
            return view('admin.tiket.edit', compact('tiket', 'users', 'events', 'kategoris', 'prioritas', 'statuses', 'timTeknisi', 'timKonten'));
        }

        // 🔹 Kalau user biasa
        return view('tiket.edit', compact('tiket', 'events', 'kategoris', 'prioritas', 'statuses'));
    }

    /**
     * Mengupdate tiket
     */
    public function update(Request $request, $tiket_id)
    {
        try {
            // Ambil tiket
            $query = Tiket::where('tiket_id', $tiket_id);

            // Kalau bukan admin, hanya boleh update tiket miliknya
            if (Auth::user()->role !== 'admin') {
                $query->where('user_id', Auth::id());
            }

            $tiket = $query->firstOrFail();

            // Simpan status lama dan assigned lama untuk notifikasi
            $statusLama     = $tiket->status->nama_status ?? null;
            $statusIdLama   = $tiket->status_id;
            $assignedToLama = $tiket->assigned_to;

            // Validasi
            $validated = $request->validate([
                'event_id'      => 'nullable|exists:events,event_id',
                'kategori_id'   => 'nullable|exists:kategoris,kategori_id',
                'status_id'     => 'nullable|exists:tiket_statuses,status_id',
                'prioritas_id'  => 'nullable|exists:priorities,prioritas_id',
                'judul'         => 'nullable|string|max:255',
                'deskripsi'     => 'nullable|string',
                'assigned_to'   => 'nullable|exists:users,user_id',
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

            // Reload relasi untuk mendapatkan data terbaru
            $tiket->load(['status', 'user', 'kategori', 'prioritas', 'event', 'assignedTo']);

            // 🔔 KIRIM NOTIFIKASI JIKA STATUS BERUBAH
            // Hanya kirim notifikasi jika yang update adalah admin dan status berubah
            if (Auth::user()->role === 'admin' &&
                isset($validated['status_id']) &&
                $statusIdLama != $validated['status_id']) {

                Notification::create([
                    'user_id'  => $tiket->user_id,
                    'tiket_id' => $tiket->tiket_id,
                    'pesan'    => "Status tiket #{$tiket->kode_tiket} telah diubah dari '{$statusLama}' menjadi '{$tiket->status->nama_status}'",
                    'waktu_kirim' => now(),
                    'status_baca' => false,
                ]);
            }

            // 🔔 KIRIM NOTIFIKASI JIKA ASSIGNED TO BERUBAH
            if (Auth::user()->role === 'admin' &&
                isset($validated['assigned_to']) &&
                $assignedToLama != $validated['assigned_to']) {

                // Notifikasi ke tim yang ditugaskan baru
                if ($validated['assigned_to']) {
                    Notification::create([
                        'user_id'  => $validated['assigned_to'],
                        'tiket_id' => $tiket->tiket_id,
                        'pesan'    => "Anda telah ditugaskan untuk menangani tiket #{$tiket->kode_tiket}: {$tiket->judul}",
                        'waktu_kirim' => now(),
                        'status_baca' => false,
                    ]);
                }

                // Notifikasi ke pembuat tiket
                Notification::create([
                    'user_id'  => $tiket->user_id,
                    'tiket_id' => $tiket->tiket_id,
                    'pesan'    => "Tiket #{$tiket->kode_tiket} telah ditugaskan ke " . ($tiket->assignedTo ? $tiket->assignedTo->name : 'tim support'),
                    'waktu_kirim' => now(),
                    'status_baca' => false,
                ]);
            }

            // Redirect berdasarkan role
            if (Auth::user()->role === 'admin') {
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
                ->where('user_id', Auth::id()) // Hanya bisa hapus tiket sendiri
                ->firstOrFail();

            $tiket->delete();

            return redirect()->route('tiket.index')->with('success', 'Tiket berhasil dihapus');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('tiket.index')->with('error', 'Tiket tidak ditemukan');
        } catch (\Exception $e) {
            return redirect()->route('tiket.index')->with('error', 'Gagal menghapus tiket: ' . $e->getMessage());
        }
    }

    /**
     * Method khusus admin untuk update status cepat
     * Bisa dipanggil via AJAX atau form biasa
     */
    public function updateStatus(Request $request, $tiket_id)
    {
        try {
            $tiket      = Tiket::with(['status', 'user'])->findOrFail($tiket_id);
            $statusLama = $tiket->status->nama_status ?? null;

            $validated = $request->validate([
                'status_id' => 'required|exists:tiket_statuses,status_id',
            ]);

            $tiket->update($validated);
            $tiket->load(['status']); // Reload relasi

            // 🔔 KIRIM NOTIFIKASI KE USER
            Notification::create([
                'user_id'  => $tiket->user_id,
                'tiket_id' => $tiket->tiket_id,
                'pesan'    => "Status tiket #{$tiket->kode_tiket} telah diubah dari '{$statusLama}' menjadi '{$tiket->status->nama_status}'",
                'waktu_kirim' => now(),
                'status_baca' => false,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status tiket berhasil diupdate',
                    'tiket'   => $tiket,
                ]);
            }

            return redirect()->back()->with('success', 'Status tiket berhasil diupdate');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal update status: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal update status: ' . $e->getMessage());
        }
    }

    /**
     * Method untuk admin membalas tiket
     */
    public function reply(Request $request, $tiket_id)
    {
        try {
            $tiket = Tiket::with(['user'])->findOrFail($tiket_id);

            $validated = $request->validate([
                'balasan' => 'required|string',
            ]);

            // Simpan balasan ke database (sesuaikan dengan struktur tabel Anda)
            // Misalnya jika ada tabel komentar/balasan terpisah:
            // $tiket->balasans()->create([
            //     'user_id' => Auth::id(),
            //     'balasan' => $validated['balasan'],
            // ]);

            // Atau update field balasan di tiket
            // $tiket->update(['balasan_admin' => $validated['balasan']]);

            // 🔔 KIRIM NOTIFIKASI KE USER
            Notification::create([
                'user_id'  => $tiket->user_id,
                'tiket_id' => $tiket->tiket_id,
                'pesan'    => "Admin telah membalas tiket #{$tiket->kode_tiket}: " . substr($validated['balasan'], 0, 50) . "...",
                'waktu_kirim' => now(),
                'status_baca' => false,
            ]);

            return redirect()->back()->with('success', 'Balasan berhasil dikirim');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim balasan: ' . $e->getMessage());
        }
    }

    /**
     * 🆕 Menampilkan tiket yang ditugaskan ke tim teknisi/konten
     * Hanya menampilkan tiket yang assigned_to = user login
     */
    public function timIndex(Request $request)
    {
        // Pastikan hanya tim teknisi atau tim konten yang bisa akses
        if (! in_array(Auth::user()->role, ['tim_teknisi', 'tim_konten'])) {
            abort(403, 'Unauthorized access');
        }

        // Query tiket yang ditugaskan ke user login
        $query = Tiket::with(['user', 'kategori', 'prioritas', 'status', 'event'])
            ->where('assigned_to', Auth::id());

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

        // Statistik untuk dashboard tim
        $stats = [
            'total'   => Tiket::where('assigned_to', Auth::id())->count(),
            'baru'    => Tiket::where('assigned_to', Auth::id())
                ->whereHas('status', fn($q) => $q->where('nama_status', 'Baru'))
                ->count(),
            'proses'  => Tiket::where('assigned_to', Auth::id())
                ->whereHas('status', fn($q) => $q->where('nama_status', 'Sedang Diproses'))
                ->count(),
            'selesai' => Tiket::where('assigned_to', Auth::id())
                ->whereHas('status', fn($q) => $q->where('nama_status', 'Selesai'))
                ->count(),
        ];

        return view('tim.tiket.index', compact('tikets', 'statuses', 'kategoris', 'prioritas', 'stats'));
    }

    /**
     * 🆕 Menampilkan detail tiket untuk tim
     */
    public function timShow($id)
    {
        // Pastikan hanya tim teknisi atau tim konten yang bisa akses
        if (! in_array(Auth::user()->role, ['tim_teknisi', 'tim_konten'])) {
            abort(403, 'Unauthorized access');
        }

        $tiket = Tiket::with(['user', 'event', 'kategori', 'prioritas', 'status', 'assignedTo'])
            ->where('tiket_id', $id)
            ->where('assigned_to', Auth::id()) // Hanya tiket yang ditugaskan ke user login
            ->firstOrFail();

        $statuses = \App\Models\TiketStatus::all();

        return view('tim.tiket.show', compact('tiket', 'statuses'));
    }

    /**
     * 🆕 Halaman edit tiket untuk tim teknisi/konten
     */
    public function timEdit($tiket_id)
    {
        // Pastikan hanya tim teknisi atau tim konten yang bisa akses
        if (! in_array(Auth::user()->role, ['tim_teknisi', 'tim_konten'])) {
            abort(403, 'Unauthorized access');
        }

        $tiket = Tiket::with(['user', 'event', 'kategori', 'prioritas', 'status', 'assignedTo'])
            ->where('tiket_id', $tiket_id)
            ->where('assigned_to', Auth::id()) // Hanya tiket yang ditugaskan ke user login
            ->firstOrFail();

        $statuses = \App\Models\TiketStatus::all();

        return view('tim.tiket.edit', compact('tiket', 'statuses'));
    }

    /**
     * 🆕 Update tiket oleh tim teknisi/konten
     */
    public function timUpdate(Request $request, $tiket_id)
    {
        try {
            // Pastikan hanya tim teknisi atau tim konten yang bisa akses
            if (! in_array(Auth::user()->role, ['tim_teknisi', 'tim_konten'])) {
                abort(403, 'Unauthorized access');
            }

            $tiket = Tiket::with(['status', 'user'])
                ->where('tiket_id', $tiket_id)
                ->where('assigned_to', Auth::id()) // Hanya tiket yang ditugaskan ke user login
                ->firstOrFail();

            $statusLama = $tiket->status->nama_status ?? null;

            // Validasi - Tim hanya bisa update status dan catatan
            $validated = $request->validate([
                'status_id' => 'required|exists:tiket_statuses,status_id',
                'catatan'   => 'nullable|string|max:1000',
            ]);

            // Update status
            $tiket->update(['status_id' => $validated['status_id']]);

            // Jika status selesai, set waktu selesai
            if ($tiket->status->nama_status == 'Selesai' && ! $tiket->waktu_selesai) {
                $tiket->update(['waktu_selesai' => now()]);
            }

            $tiket->load(['status']);

            // 🔔 KIRIM NOTIFIKASI KE USER
            $pesan = "Status tiket #{$tiket->kode_tiket} telah diubah dari '{$statusLama}' menjadi '{$tiket->status->nama_status}' oleh " . Auth::user()->name;

            if (! empty($validated['catatan'])) {
                $pesan .= ". Catatan: {$validated['catatan']}";
            }

            Notification::create([
                'user_id'     => $tiket->user_id,
                'tiket_id'    => $tiket->tiket_id,
                'pesan'       => $pesan,
                'waktu_kirim' => now(),
                'status_baca' => false,
            ]);

            // 🔔 KIRIM NOTIFIKASI KE ADMIN
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id'  => $admin->user_id,
                    'tiket_id' => $tiket->tiket_id,
                    'pesan'    => Auth::user()->name . " telah mengubah status tiket #{$tiket->kode_tiket} menjadi '{$tiket->status->nama_status}'",
                    'waktu_kirim' => now(),
                    'status_baca' => false,
                ]);
            }

            return redirect()->route('tim.tiket.show', $tiket->tiket_id)
                ->with('success', 'Tiket berhasil diperbarui');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal update tiket: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * 🆕 Update status tiket oleh tim teknisi/konten (untuk AJAX/quick update)
     */
    public function timUpdateStatus(Request $request, $tiket_id)
    {
        try {
            // Pastikan hanya tim teknisi atau tim konten yang bisa akses
            if (! in_array(Auth::user()->role, ['tim_teknisi', 'tim_konten'])) {
                abort(403, 'Unauthorized access');
            }

            $tiket = Tiket::with(['status', 'user'])
                ->where('tiket_id', $tiket_id)
                ->where('assigned_to', Auth::id()) // Hanya tiket yang ditugaskan ke user login
                ->firstOrFail();

            $statusLama = $tiket->status->nama_status ?? null;

            $validated = $request->validate([
                'status_id' => 'required|exists:tiket_statuses,status_id',
                'catatan'   => 'nullable|string|max:500',
            ]);

            $tiket->update(['status_id' => $validated['status_id']]);
            $tiket->load(['status']);

            // 🔔 KIRIM NOTIFIKASI KE USER
            $pesan = "Status tiket #{$tiket->kode_tiket} telah diubah dari '{$statusLama}' menjadi '{$tiket->status->nama_status}' oleh " . Auth::user()->name;

            if (! empty($validated['catatan'])) {
                $pesan .= ". Catatan: {$validated['catatan']}";
            }

            Notification::create([
                'user_id'     => $tiket->user_id,
                'tiket_id'    => $tiket->tiket_id,
                'pesan'       => $pesan,
                'waktu_kirim' => now(),
                'status_baca' => false,
            ]);

            // 🔔 KIRIM NOTIFIKASI KE ADMIN
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id'  => $admin->user_id,
                    'tiket_id' => $tiket->tiket_id,
                    'pesan'    => Auth::user()->name . " telah mengubah status tiket #{$tiket->kode_tiket} menjadi '{$tiket->status->nama_status}'",
                    'waktu_kirim' => now(),
                    'status_baca' => false,
                ]);
            }

            return redirect()->back()->with('success', 'Status tiket berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update status: ' . $e->getMessage());
        }
    }
}
