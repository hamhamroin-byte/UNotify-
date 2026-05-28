<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Menampilkan daftar seluruh user/mahasiswa
    public function index()
    {
        // Proteksi tambahan memastikan hanya admin yang bisa masuk
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    // Memperbarui role atau kelas user dari panel admin
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $user = User::findOrFail($id);

        // Jangan izinkan admin menghapus/mengubah dirinya sendiri secara tidak sengaja
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa mengubah role akun Anda sendiri!');
        }

        $request->validate([
            'role' => 'required|string|in:admin,user',
            'class' => 'required|string|in:ALL,ICA24,ICB24,ICC24,ICD24,ICE24',
        ]);

        $user->update([
            'role' => $request->role,
            'class' => $request->class,
        ]);

        return redirect()->back()->with('success', 'Akun ' . $user->name . ' berhasil diperbarui!');
    }

    // Menghapus akun mahasiswa/user
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        // Hapus avatar user dari storage jika ada sebelum akunnya dihapus
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();
        return redirect()->back()->with('success', 'Akun user berhasil dihapus permanen!');
    }
}