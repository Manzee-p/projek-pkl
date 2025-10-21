<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TiketController extends Controller
{
    /**
     * Menampilkan semua tiket
     */
    public function index(Request $request)
    {
        $query = Tiket::with(['user', 'kategoris', 'priorities', 'status', 'event']);

        // Filter
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

        // Urutkan
        $query->orderByRaw("FIELD(prioritas_id, 1, 2, 3)")
              ->orderByDesc('waktu_dibuat');

        $tikets = $query->get();

        return response()->json([
            'status' => true,
            'message' => 'Daftar tiket berhasil diambil',
            'data' => $tikets,
        ]);
    }

    /**
     * Menyimpan tiket baru dengan kode otomatis
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'       => 'required|exists:users,user_id',
            'event_id'      => 'required|exists:events,event_id',
            'kategori_id'   => 'required|exists:kategoris,kategori_id',
            'status_id'     => 'required|exists:tiket_statuses,status_id',
            'prioritas_id'  => 'required|exists:priorities,prioritas_id',
            'judul'         => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
        ]);

        $today = Carbon::now()->format('Ymd');
        $countToday = Tiket::whereDate('waktu_dibuat', Carbon::today())->count() + 1;
        $kodeTiket = 'TCK-' . $today . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);

        while (Tiket::where('kode_tiket', $kodeTiket)->exists()) {
            $countToday++;
            $kodeTiket = 'TCK-' . $today . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);
        }

        $tiket = Tiket::create([
            'user_id'       => $request->user_id,
            'event_id'      => $request->event_id,
            'kategori_id'   => $request->kategori_id,
            'status_id'     => $request->status_id,
            'prioritas_id'  => $request->prioritas_id,
            'judul'         => $request->judul,
            'deskripsi'     => $request->deskripsi,
            'kode_tiket'    => $kodeTiket,
            'waktu_dibuat'  => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Tiket berhasil dibuat',
            'data' => $tiket,
        ], 201);
    }

    /**
     * Menampilkan detail tiket
     */
    public function show($id)
    {
        $tiket = Tiket::with([
            'user',
            'kategoris',
            'priorities',
            'status',
            'event',
            'feedbacks',
            'notifications'
        ])->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Detail tiket berhasil diambil',
            'data' => $tiket,
        ]);
    }

    /**
     * Update status/prioritas tiket
     */
    public function update(Request $request, $id)
    {
        $tiket = Tiket::findOrFail($id);

        $tiket->update($request->only([
            'status_id',
            'prioritas_id',
            'kategori_id',
            'assigned_to',
            'waktu_selesai'
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Tiket berhasil diperbarui',
            'data' => $tiket,
        ]);
    }

    /**
     * Hapus tiket
     */
    public function destroy($id)
    {
        $tiket = Tiket::findOrFail($id);
        $tiket->delete();

        return response()->json([
            'status' => true,
            'message' => 'Tiket berhasil dihapus',
        ]);
    }
}
