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

        $notifications = Notification::where(function ($query) use ($user) {
                // User biasa hanya melihat notifikasi mereka sendiri
                $query->where('user_id', $user->user_id);
                
                // Admin juga bisa melihat notifikasi mereka sendiri
                // Tidak ada kolom 'role' di tabel, jadi cukup berdasarkan user_id
            })
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
            ->where('status_baca', false) // Hanya yang belum dibaca
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

    // Tandai satu notifikasi dibaca
    public function markAsRead($id)
    {
        $user = Auth::user();
        
        $notification = Notification::where('notif_id', $id)
            ->where('user_id', $user->user_id)
            ->firstOrFail();

        $notification->update(['status_baca' => true]);

        return response()->json(['success' => true]);
    }

    // Tandai semua dibaca
    public function markAllAsRead()
    {
        $user = Auth::user();

        Notification::where('user_id', $user->user_id)
            ->where('status_baca', false)
            ->update(['status_baca' => true]);

        return response()->json(['success' => true]);
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