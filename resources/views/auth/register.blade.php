<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-blue-900 via-slate-900 to-gray-900 px-4 py-12">
        
        <div class="mb-6 text-center">
            <h1 class="text-4xl font-extrabold text-white tracking-widest drop-shadow-md">
                📢 UNotify
            </h1>
            <p class="text-xs text-blue-300/70 mt-2 tracking-wider uppercase">
                Pendaftaran Akun Mahasiswa Baru
            </p>
        </div>

        <div class="w-full sm:max-w-md bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/10 shadow-2xl">
            
            <h2 class="text-xl font-bold text-white text-center mb-6">Buat Akun Baru</h2>

            @if ($errors->any())
                <div class="mb-4 bg-red-500/10 border border-red-500/20 text-red-300 text-sm p-3 rounded-xl">
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-semibold text-blue-200 uppercase tracking-wider mb-1">
                        Nama Lengkap
                    </label>
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                           placeholder="Masukkan nama lengkap Anda"
                           class="w-full text-sm border border-white/10 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white/5 text-white placeholder-blue-300/30 transition">
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-blue-200 uppercase tracking-wider mb-1">
                        Alamat Email Kampus / Pribadi
                    </label>
                    <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                           placeholder="nama@gmail.com"
                           class="w-full text-sm border border-white/10 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white/5 text-white placeholder-blue-300/30 transition">
                </div>

                <div>
    <label for="class" class="block text-xs font-semibold text-blue-200 uppercase tracking-wider mb-1">
        Pilih Kelas
    </label>
    <select id="class" name="class" required
            class="w-full text-sm border border-white/10 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-800 text-white transition">
        <option value="" disabled selected>-- Pilih Kelas Anda --</option>
        <option value="ICA24" {{ old('class') == 'ICA24' ? 'selected' : '' }}>ICA24</option>
        <option value="ICB24" {{ old('class') == 'ICB24' ? 'selected' : '' }}>ICB24</option>
        <option value="ICC24" {{ old('class') == 'ICC24' ? 'selected' : '' }}>ICC24</option>
        <option value="ICD24" {{ old('class') == 'ICD24' ? 'selected' : '' }}>ICD24</option>
        <option value="ICE24" {{ old('class') == 'ICE24' ? 'selected' : '' }}>ICE24</option>
    </select>
</div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-blue-200 uppercase tracking-wider mb-1">
                        Password
                    </label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           placeholder="Minimal 8 karakter"
                           class="w-full text-sm border border-white/10 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white/5 text-white placeholder-blue-300/30 transition">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-blue-200 uppercase tracking-wider mb-1">
                        Konfirmasi Password
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           placeholder="Ulangi password Anda"
                           class="w-full text-sm border border-white/10 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white/5 text-white placeholder-blue-300/30 transition">
                </div>

                <div class="pt-2">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-500 text-white p-3 rounded-xl text-sm font-bold tracking-wide transition shadow-lg transform active:scale-[0.98]">
                        Daftar Akun
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center border-t border-white/5 pt-4">
                <p class="text-xs text-blue-200/60">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-blue-400 hover:text-white font-semibold transition ml-1">
                        Masuk Di Sini
                    </a>
                </p>
            </div>

        </div>
    </div>
</x-guest-layout>