<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Fungsi ini yang dicari oleh Laravel
    public function index()
    {
        return view('dashboard', [
            'announcementsCount' => Announcement::count(),
            'userCommentsCount' => Comment::where('user_id', Auth::id())->count(),
            'latestAnnouncements' => Announcement::with('comments.user')->latest()->take(3)->get()
        ]);
    }
}