<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    /**
     * 
     */
    public function index(Request $request)
    {
        // Query dasar tiket + relasi-relasinya
        $query = Tiket::with([
            'user',
            'kategoris',
            'priorities',
            'status',
            'event'
        ]);

        // Filter berdasarkan status
        if ($request->has('status_id') && $request->status_id !== null) {
            $query->where('status_id', $request->status_id);
        }

        // Filter berdasarkan kategori
        if ($request->has('kategori_id') && $request->kategori_id !== null) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter berdasarkan prioritas
        if ($request->has('prioritas_id') && $request->prioritas_id !== null) {
            $query->where('prioritas_id', $request->prioritas_id);
        }

        // Filter berdasarkan tipe pengguna (User / Vendor)
        if ($request->has('tipe_pengguna') && $request->tipe_pengguna !== null) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('tipe_pengguna', $request->tipe_pengguna);
            });
        }

        // Urutkan berdasarkan prioritas dan waktu dibuat
        $query->orderByRaw("FIELD(prioritas_id, 1, 2, 3)")->orderByDesc('waktu_dibuat');

        // Ambil hasil
        $tikets = $query->get();

        return response()->json([
            'status' => true,
            'message' => 'Daftar tiket berhasil diambil',
            'data' => $tikets,
        ]);
    }

    /**
     * 
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
     * 
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

        $tiket = Tiket::create([
            'user_id'       => $request->user_id,
            'event_id'      => $request->event_id,
            'kategori_id'   => $request->kategori_id,
            'status_id'     => $request->status_id,
            'prioritas_id'  => $request->prioritas_id,
            'judul'         => $request->judul,
            'deskripsi'     => $request->deskripsi,
            'waktu_dibuat'  => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Tiket berhasil dibuat',
            'data' => $tiket,
        ], 201);
    }

    /**
     * 
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
     * 
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
