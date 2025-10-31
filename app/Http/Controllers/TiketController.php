<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    /**
     * Menampilkan semua tiket dengan filter opsional
     */
    public function index(Request $request)
    {
        // ✅ PERBAIKI: kategoris → kategori
        $query = Tiket::with(['user', 'kategori', 'prioritas', 'status', 'event']);

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

        if ($request->filled('tipe_pengguna')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('tipe_pengguna', $request->tipe_pengguna);
            });
        }

        $query->orderByRaw("
            CASE
                WHEN prioritas_id = 1 THEN 1
                WHEN prioritas_id = 2 THEN 2
                WHEN prioritas_id = 3 THEN 3
                ELSE 4
            END
        ")->orderByDesc('waktu_dibuat');

        $tikets = $query->get();

        return response()->json([
            'status'  => true,
            'message' => 'Daftar tiket berhasil diambil',
            'data'    => $tikets,
        ]);
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

        $today = Carbon::now()->format('Ymd');
        $countToday = Tiket::whereDate('waktu_dibuat', Carbon::today())->count() + 1;
        $kodeTiket = 'TCK-' . $today . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);

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

        // ✅ PERBAIKI: kategoris → kategori
        $tiket->load(['user', 'kategori', 'prioritas', 'status', 'event']);

        return response()->json([
            'status'  => true,
            'message' => 'Tiket berhasil dibuat',
            'data'    => $tiket,
        ], 201);
    }

    /**
     * Menampilkan detail tiket
     */
    public function show($tiket_id)
    {
        try {
            // ✅ PERBAIKI: kategoris → kategori
            $tiket = Tiket::with(['user', 'kategori', 'prioritas', 'status', 'event'])
                ->where('tiket_id', $tiket_id)
                ->firstOrFail();

            return response()->json([
                'status'  => true,
                'message' => 'Detail tiket berhasil diambil',
                'data'    => $tiket,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Tiket tidak ditemukan',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal mengambil detail tiket: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mengupdate tiket
     */
    public function update(Request $request, $tiket_id)
    {
        try {
            $tiket = Tiket::where('tiket_id', $tiket_id)->firstOrFail();

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
                    return response()->json([
                        'status' => false,
                        'message' => 'Format waktu_selesai tidak valid.',
                    ], 422);
                }
            }

            foreach ($validated as $key => $value) {
                if (!is_null($value)) {
                    $tiket->$key = $value;
                }
            }

            $tiket->save();

            // ✅ PERBAIKI: kategoris → kategori
            $tiket->load(['user', 'kategori', 'prioritas', 'status', 'event']);

            return response()->json([
                'status'  => true,
                'message' => 'Tiket berhasil diperbarui.',
                'data'    => $tiket,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Tiket tidak ditemukan',
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Menghapus tiket
     */
    public function destroy($tiket_id)
    {
        try {
            $tiket = Tiket::where('tiket_id', $tiket_id)->firstOrFail();
            $tiket->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Tiket berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Tiket tidak ditemukan',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menghapus tiket: ' . $e->getMessage(),
            ], 500);
        }
    }
}