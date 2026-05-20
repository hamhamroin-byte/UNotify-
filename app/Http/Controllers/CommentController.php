<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'announcement_id' => 'required|exists:announcements,id',
            'content' => 'required',
        ]);

        Comment::create([
            'announcement_id' => $request->announcement_id,
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}