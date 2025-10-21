<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();

        return response()->json([
            'status'  => 200,
            'message' => 'Data event berhasil diambil',
            'data'    => $events,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_event'      => 'required|string|max:255',
            'lokasi'          => 'required|string',
            'area'            => 'required|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $event = Event::create($validated);

        return response()->json([
            'status'  => 201,
            'message' => 'Event berhasil dibuat',
            'data'    => $event,
        ]);
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);

        return response()->json([
            'status'  => 200,
            'message' => 'Detail event berhasil diambil',
            'data'    => $event,
        ]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'nama_event'      => 'required|string|max:255',
            'lokasi'          => 'required|string',
            'area'            => 'required|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $event->update($validated);

        return response()->json([
            'status'  => 200,
            'message' => 'Event berhasil diperbarui',
            'data'    => $event,
        ]);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json([
            'status'  => 200,
            'message' => 'Event berhasil dihapus',
        ]);
    }
}
