<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-blue-900 via-slate-900 to-gray-900 px-4">
        
        <div class="mb-8 text-center animate-fade-in">
            <h1 class="text-4xl font-extrabold text-white tracking-widest drop-shadow-md">
                📢 UNotify
            </h1>
            <p class="text-xs text-blue-300/70 mt-2 tracking-wider uppercase">
                Sistem Informasi Pengumuman Kampus
            </p>
        </div>

        <div class="w-full sm:max-w-md bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/10 shadow-2xl">
            
            <h2 class="text-xl font-bold text-white text-center mb-6">Selamat Datang Kembali</h2>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-400 bg-green-500/10 p-3 rounded-xl border border-green-500/20">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-500/10 border border-red-500/20 text-red-300 text-sm p-3 rounded-xl">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            {{-- Modifikasi pesan error default agar lebih ramah --}}
                            <li>{{ $error == 'auth.failed' || $error == __('auth.failed') ? 'Email atau password salah.' : $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold text-blue-200 uppercase tracking-wider mb-2">
                        Alamat Email
                    </label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                           placeholder="nama@gmail.com"
                           class="w-full text-sm border border-white/10 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white/5 text-white placeholder-blue-300/30 transition">
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-blue-200 uppercase tracking-wider mb-2">
                        Password
                    </label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           placeholder="••••••••"
                           class="w-full text-sm border border-white/10 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white/5 text-white placeholder-blue-300/30 transition">
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label for="remember_me" class="inline-flex items-center text-blue-200 hover:text-white cursor-pointer transition">
                        <input id="remember_me" type="checkbox" name="remember" 
                               class="rounded border-white/10 bg-white/5 text-blue-600 focus:ring-blue-500 focus:ring-offset-slate-950 mr-2">
                        <span>Ingat Saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-blue-400 hover:text-white transition">
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <div class="pt-2">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-500 text-white p-3 rounded-xl text-sm font-bold tracking-wide transition shadow-lg transform active:scale-[0.98]">
                        Masuk Sekarang
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center border-t border-white/5 pt-4">
                <p class="text-xs text-blue-200/60">
                    Belum punya akun mahasiswa? 
                    <a href="{{ route('register') }}" class="text-blue-400 hover:text-white font-semibold transition ml-1">
                        Daftar Di Sini
                    </a>
                </p>
            </div>

        </div>
    </div>
</x-guest-layout>