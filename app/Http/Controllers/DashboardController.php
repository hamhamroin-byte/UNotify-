<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil query dasar pengumuman beserta komentar terbarunya
        $query = Announcement::with(['comments' => function($q) {
            $q->latest();
        }, 'comments.user']);

        // FIX: Jika bukan admin, batasi pengumuman hanya untuk ALL atau kelas si mahasiswa
        if ($user->role !== 'admin') {
            $query->where(function($q) use ($user) {
                $q->where('target_class', 'ALL')
                  ->orWhere('target_class', $user->class);
            });
        }

        // Ambil 3 data pengumuman terbaru yang sudah difilter hak aksesnya
        $latestAnnouncements = $query->latest()->take(3)->get();

        return view('dashboard', [
            'announcementsCount'  => Announcement::count(),
            'userCommentsCount'   => Comment::where('user_id', Auth::id())->count(),
            'latestAnnouncements' => $latestAnnouncements
        ]);
    }
}