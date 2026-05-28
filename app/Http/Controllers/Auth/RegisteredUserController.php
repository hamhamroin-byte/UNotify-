<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // REVISI: Menambahkan 'class' ke dalam aturan validasi form
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'class' => ['required', 'string', 'in:ICA24,ICB24,ICC24,ICD24,ICE24'], // Memastikan pilihan kelas sesuai dropdown
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // REVISI: Menambahkan 'class' agar ikut disimpan saat user baru dibuat
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'class' => $request->class,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}