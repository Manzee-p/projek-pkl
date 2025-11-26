<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Tampilkan semua notifikasi sesuai role
    public function index()
    {
        $user = Auth::user();

        $notifications = Notification::where('user_id', $user->user_id)
            ->with('tiket')
            ->orderBy('waktu_kirim', 'desc')
            ->paginate(10);

        // Pisahkan view berdasarkan role
        if ($user->role === 'admin') {
            return view('admin.notifications.index', compact('notifications', 'user'));
        } else {
            return view('notifications.index', compact('notifications', 'user'));
        }
    }

    // Ambil notifikasi belum dibaca (untuk dropdown navbar)
    public function getUnread()
    {
        $user = Auth::user();

        $notifications = Notification::where('user_id', $user->user_id)
            ->where('status_baca', false)
            ->with('tiket')
            ->orderBy('waktu_kirim', 'desc')
            ->limit(5)
            ->get();

        $unreadCount = Notification::where('user_id', $user->user_id)
            ->where('status_baca', false)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    // Tandai notifikasi dibaca DAN redirect ke detail tiket
    public function read($id)
    {
        $user = Auth::user();
        
        $notification = Notification::where('notif_id', $id)
            ->where('user_id', $user->user_id)
            ->with('tiket')
            ->firstOrFail();

        // Tandai sebagai dibaca
        $notification->update(['status_baca' => true]);

        // Return JSON jika AJAX request
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        // Redirect ke detail tiket jika ada
        if ($notification->tiket_id && $notification->tiket) {
            if ($user->role === 'admin') {
                return redirect()->route('admin.tickets.show', $notification->tiket_id);
            } else {
                return redirect()->route('tickets.show', $notification->tiket_id);
            }
        }

        // Jika tidak ada tiket terkait, kembali ke halaman notifikasi
        return redirect()->route('notifications.index')
            ->with('info', 'Tiket terkait tidak ditemukan');
    }

    // Tandai satu notifikasi dibaca (untuk AJAX)
    public function markAsRead($id)
    {
        $user = Auth::user();
        
        $notification = Notification::where('notif_id', $id)
            ->where('user_id', $user->user_id)
            ->firstOrFail();

        $notification->update(['status_baca' => true]);

        return response()->json(['success' => true]);
    }

    // Tandai semua dibaca - FIXED untuk support AJAX
    public function markAllAsRead(Request $request)
    {
        $user = Auth::user();

        Notification::where('user_id', $user->user_id)
            ->where('status_baca', false)
            ->update(['status_baca' => true]);

        // Jika AJAX request, return JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Semua notifikasi telah ditandai sebagai dibaca'
            ]);
        }

        // Jika request biasa, redirect
        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca');
    }

    // Hapus notifikasi
    public function destroy($id)
    {
        $user = Auth::user();
        
        $notification = Notification::where('notif_id', $id)
            ->where('user_id', $user->user_id)
            ->firstOrFail();

        $notification->delete();

        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus');
    }
}