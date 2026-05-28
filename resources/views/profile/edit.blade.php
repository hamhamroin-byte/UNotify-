<x-app-layout>
    <div id="glow-container" class="py-10 min-h-screen relative overflow-hidden bg-slate-900 text-white">
        <div id="cursor-glow" class="pointer-events-none absolute rounded-full opacity-0 blur-[120px] transition-opacity duration-300 z-0 w-[400px] h-[400px]" 
             style="background: radial-gradient(circle, rgba(59,130,246,0.2) 0%, rgba(59,130,246,0) 70%);">
        </div>

        <div class="max-w-3xl mx-auto px-4 relative z-10">
            <div class="mb-8">
                <h1 class="text-3xl font-bold tracking-tight">⚙️ Pengaturan Profil</h1>
                <p class="text-slate-400 text-sm mt-1">Kelola informasi akun, perbarui kata sandi, dan ganti foto profil Anda.</p>
            </div>

            @if(session('success'))
                <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-4 rounded-xl mb-6 text-sm flex items-center gap-2">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white/5 backdrop-blur-md rounded-2xl shadow-2xl border border-white/10 p-6 sm:p-8">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col sm:flex-row items-center gap-6 pb-8 border-b border-white/5">
                        <div class="relative group">
                            <img id="avatar-preview" 
                                 src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=2563eb&color=fff' }}" 
                                 alt="Avatar {{ Auth::user()->name }}" 
                                 class="w-28 h-28 rounded-full object-cover border-4 border-blue-600/50 shadow-xl transition duration-300 group-hover:scale-105">
                        </div>
                        <div class="flex-1 text-center sm:text-left space-y-2">
                            <label class="block text-sm font-semibold text-blue-400">Foto Profil Anda</label>
                            <input type="file" name="avatar" id="avatar-input" accept="image/*"
                                   class="text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-500 file:transition-all file:cursor-pointer shadow-md">
                            <p class="text-[11px] text-slate-400/60">Format file yang didukung: JPG, JPEG, atau PNG. Maksimal 2MB.</p>
                            @error('avatar') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-md font-medium text-slate-300 flex items-center gap-2">
                            <span>👤</span> Informasi Personal
                        </h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                                       class="w-full border border-white/10 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-950/40 text-white transition">
                                @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-2">Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                                       class="w-full border border-white/10 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-950/40 text-white transition">
                                @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 pt-4 border-t border-white/5">
                        <div>
                            <h3 class="text-md font-medium text-slate-300 flex items-center gap-2">
                                <span>🔒</span> Ubah Kata Sandi <span class="text-xs text-slate-500 font-normal">(Kosongkan jika tidak ingin diubah)</span>
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-2">Password Baru</label>
                                <input type="password" name="password" placeholder="Minimal 8 karakter"
                                       class="w-full border border-white/10 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-950/40 text-white transition">
                                @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-2">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                                       class="w-full border border-white/10 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-950/40 text-white transition">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-6 border-t border-white/5">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-3 rounded-xl transition duration-200 shadow-lg hover:shadow-blue-600/20 text-sm w-full sm:w-auto">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Realtime Preview Gambar saat memilih file
        document.getElementById('avatar-input').addEventListener('change', function(e) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            if(this.files[0]) {
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Efek Mouse Glow tracker
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('glow-container');
            const glow = document.getElementById('cursor-glow');
            if (container && glow) {
                container.addEventListener('mousemove', (e) => {
                    const rect = container.getBoundingClientRect();
                    const x = e.clientX - rect.left - (glow.offsetWidth / 2);
                    const y = e.clientY - rect.top - (glow.offsetHeight / 2);
                    glow.style.opacity = '1';
                    glow.style.transform = `translate(${x}px, ${y}px)`;
                });
                container.addEventListener('mouseleave', () => { glow.style.opacity = '0'; });
            }
        });
    </script>
</x-app-layout>