<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\UserController; // FIX: Import UserController milik admin
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// File Auth bawaan Breeze dipanggil Paling Atas agar route custom kita di bawah bisa menimpanya
require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
});

// Dashboard (Bisa diakses Admin & User)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route khusus untuk ADMIN saja
Route::middleware(['auth', 'admin'])->group(function () {
    // Halaman tes admin
    Route::get('/admin', function () {
        return 'Halo Admin UNotify 🔥';
    });

    // Fitur Kelola Pengumuman (Admin)
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    // FIX: Rute Baru Manajemen User/Kelola Akun (Admin)
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

// Route yang bisa diakses oleh semua user yang sudah login (Admin & User)
Route::middleware('auth')->group(function () {
    // Komentar
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

    // Pengumuman Global
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/{id}', [AnnouncementController::class, 'show'])->name('announcements.show');

    // FIX UTAMA: Route Profile ditaruh di paling bawah (setelah auth.php) & diubah ke PUT agar sinkron dengan Blade
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});