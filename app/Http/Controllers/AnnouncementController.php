<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // FIX: Import Storage untuk mengelola file

class AnnouncementController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            // Admin bisa melihat semua pengumuman yang pernah dibuat
            $announcements = Announcement::with('comments.user')->latest()->get();
        } else {
            // Menggunakan fungsi closure agar query 'where' dan 'orWhere' dibungkus tanda kurung ( )
            $announcements = Announcement::with('comments.user')
                                        ->where(function($query) use ($user) {
                                            $query->where('target_class', 'ALL')
                                                  ->orWhere('target_class', $user->class);
                                        })
                                        ->latest()
                                        ->get();
        }

        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('announcements.create');
    }   

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'type'         => 'required|array', 
            'type.*'       => 'string|in:URGENT,TUGAS,UJIAN,LIBURAN,AKADEMIK,EVENT',
            'target_class' => 'required|string|in:ALL,ICA24,ICB24,ICC24,ICD24,ICE24',
            'attachment'   => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120', // FIX: Validasi dokumen/foto maks 5MB
        ]);

        $attachmentPath = null;
        // FIX: Proses upload file lampiran jika dimasukkan oleh admin
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('announcements_attachments', 'public');
        }

        $announcement = Announcement::create([
            'title'        => $request->title,
            'content'      => $request->content,
            'type'         => $request->type, 
            'target_class' => $request->target_class,
            'user_id'      => Auth::id(), 
            'attachment'   => $attachmentPath, // FIX: Simpan path file ke database
        ]);

        try {
            $typesString = implode(', ', $request->type);
            Http::withHeaders([
                'Authorization' => 'Basic ' . env('ONESIGNAL_REST_API_KEY'),
                'Content-Type'  => 'application/json',
            ])->post('https://onesignal.com/api/v1/notifications', [
                'app_id'            => env('ONESIGNAL_APP_ID'),
                'included_segments' => ['All Users'],
                'headings'          => ['en' => '📢 [' . $typesString . '] ' . $request->title],
                'contents'          => ['en' => $request->content],
                'url'               => route('announcements.index'),
            ]);
        } catch (\Exception $e) {
            // Abaikan jika koneksi OneSignal bermasalah
        }

        return redirect()->route('announcements.index')->with('success', '📢 Pengumuman Baru Telah Dirilis!');
    }

    public function edit(Announcement $announcement)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'type'         => 'required|array',
            'type.*'       => 'string|in:URGENT,TUGAS,UJIAN,LIBURAN,AKADEMIK,EVENT',
            'target_class' => 'required|string|in:ALL,ICA24,ICB24,ICC24,ICD24,ICE24',
            'attachment'   => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120', // FIX: Validasi berkas update
        ]);

        // FIX: Proses update file lampiran baru
        if ($request->hasFile('attachment')) {
            // Hapus file lampiran lama dari storage jika sebelumnya sudah ada
            if ($announcement->attachment && Storage::disk('public')->exists($announcement->attachment)) {
                Storage::disk('public')->delete($announcement->attachment);
            }

            // Simpan file baru
            $path = $request->file('attachment')->store('announcements_attachments', 'public');
            $announcement->attachment = $path;
        }

        $announcement->update([
            'title'        => $request->title,
            'content'      => $request->content,
            'type'         => $request->type,
            'target_class' => $request->target_class,
            'attachment'   => $announcement->attachment, // Amankan data path terbaru
        ]);

        return redirect()->route('announcements.index')->with('success', '✅ Pengumuman berhasil diperbarui!');
    }

    public function destroy(Announcement $announcement)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        // FIX: Hapus file lampiran dari storage saat pengumuman dihapus permanen
        if ($announcement->attachment && Storage::disk('public')->exists($announcement->attachment)) {
            Storage::disk('public')->delete($announcement->attachment);
        }

        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', '🗑️ Pengumuman berhasil dihapus!');
    }

    public function show($id)
    {
        $announcement = Announcement::with('comments.user')->findOrFail($id);
        return view('announcements.show', compact('announcement'));
    } 
}