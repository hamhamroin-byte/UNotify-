<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UNotify - Pusat Informasi Kampus</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased bg-[#0B192C] text-white">

    <div id="glow-container" class="min-h-screen flex flex-col justify-between relative overflow-hidden bg-gradient-to-br from-[#0B192C] via-[#1E3E62] to-[#00D2FC]">
        
        <div id="cursor-glow" class="pointer-events-none absolute rounded-full opacity-0 blur-[120px] transition-opacity duration-300 z-0 w-[400px] h-[400px]" 
             style="background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);">
        </div>

        <header class="w-full max-w-7xl mx-auto px-6 py-6 flex justify-between items-center relative z-10">
            <div class="flex items-center gap-2">
                <span class="text-2xl font-black tracking-wider text-white">📢 UNotify</span>
            </div>
            
            <nav class="flex gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 text-sm font-medium transition backdrop-blur-md">
                            Masuk Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-blue-200 hover:text-white transition">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-semibold bg-blue-600 hover:bg-blue-500 text-white rounded-xl shadow-lg transition transform active:scale-95">
                                Daftar Akun
                            </a>
                        @endif
                    @endauth
                @endif
            </nav>
        </header>

        <main class="max-w-4xl mx-auto px-6 text-center my-auto py-12 relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/20 text-xs text-blue-300 font-medium uppercase tracking-wider mb-6 animate-pulse">
                🚀 Platform Pengumuman Digital Modern
            </div>
            
            <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-none mb-6">
                Informasi Kampus, <br>
                <span class="bg-gradient-to-r from-blue-400 to-cyan-300 bg-clip-text text-transparent">Cepat & Tersegmentasi.</span>
            </h1>
            
            <p class="text-base sm:text-lg text-blue-100/70 max-w-2xl mx-auto mb-10 leading-relaxed">
                Dapatkan notifikasi real-time mengenai tugas, ujian, akademik, dan liburan langsung berdasarkan target kelas Anda (ICA24 - ICE24) tanpa tercampur aduk.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-3xl mx-auto text-left">
                <div class="p-5 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl">
                    <div class="text-xl mb-2">🎯</div>
                    <h3 class="font-bold text-white mb-1 text-sm">Target Kelas</h3>
                    <p class="text-xs text-blue-200/60">Pengumuman difilter khusus untuk kelas mahasiswa masing-masing.</p>
                </div>
                <div class="p-5 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl">
                    <div class="text-xl mb-2">🔔</div>
                    <h3 class="font-bold text-white mb-1 text-sm">Push Notification</h3>
                    <p class="text-xs text-blue-200/60">Terintegrasi dengan OneSignal untuk siaran info super kilat.</p>
                </div>
                <div class="p-5 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl">
                    <div class="text-xl mb-2">💬</div>
                    <h3 class="font-bold text-white mb-1 text-sm">Kolom Diskusi</h3>
                    <p class="text-xs text-blue-200/60">Mahasiswa dapat langsung bertanya lewat kolom komentar di bawah pengumuman.</p>
                </div>
            </div>
        </main>

        <footer class="w-full text-center py-6 border-t border-white/5 text-xs text-blue-200/40 relative z-10 bg-black/10 backdrop-blur-sm">
            <div class="max-w-4xl mx-auto px-4 space-y-2">
                <p class="text-blue-200 font-medium tracking-wide">
                    🛠️ Project By : Ihda Sibri Moh Ibda Amroin, Syarif Hidayatullah, Ach. Zakiul Fuadi, Putri Ravela, Kholilurrohim, Umam, Rachmat
                </p>
                <p class="text-white/40">
                    &copy; 2026 UNotify Project. All rights reserved.
                </p>
            </div>
        </footer>

    </div>

    <script>
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

                container.addEventListener('mouseleave', () => {
                    glow.style.opacity = '0';
                });
            }
        });
    </script>

</body>
</html>