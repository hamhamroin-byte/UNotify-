<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Tambahan untuk hit API Push Notification

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('comments.user')
            ->latest()
            ->get();
        
        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        // 1. Simpan pengumuman ke database Laragon
        $announcement = Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        // 2. LOGIK PUSH NOTIFICATION (Kirim ke Device HP / Laptop via OneSignal API)
        try {
            Http::withHeaders([
                'Authorization' => 'Basic ' . env('ONESIGNAL_REST_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://onesignal.com/api/v1/notifications', [
                'app_id'            => env('ONESIGNAL_APP_ID'),
                'included_segments' => ['All Users'], // Mengirim ke semua device yang terdaftar/subscribe
                'headings'          => ['en' => '📢 ' . $request->title],
                'contents'          => ['en' => $request->content],
                'url'               => route('announcements.index'), // Jika notif diklik, otomatis buka halaman ini
            ]);
        } catch (\Exception $e) {
            // Jika API OneSignal gagal/error (misal internet mati), aplikasi tetap berjalan lancar tanpa crash
        }

        // 3. Kembalikan ke halaman index dengan alert flash session internal
        return redirect()->route('announcements.index')
            ->with('success', '📢 Pengumuman Baru Telah Dirilis & Push Notif Dikirim!');
    }

    public function edit(Announcement $announcement)
    {
        return view('announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('announcements.index')
            ->with('success', '✅ Pengumuman berhasil diperbarui!');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('announcements.index')
            ->with('success', '🗑️ Pengumuman berhasil dihapus!');
    }
}