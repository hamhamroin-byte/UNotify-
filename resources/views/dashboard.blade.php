<x-app-layout>
    <div id="glow-container" class="py-10 min-h-screen relative overflow-hidden">
        
        <div id="cursor-glow" class="pointer-events-none absolute rounded-full opacity-0 blur-[120px] transition-opacity duration-300 z-0 w-[400px] h-[400px]" 
             style="background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);">
        </div>

        <div class="max-w-5xl mx-auto px-4 relative z-10">
            
            <div class="bg-gradient-to-r transition-all from-blue-700/80 to-indigo-800/80 backdrop-blur-md rounded-2xl shadow-lg border border-white/10 p-6 mb-8 text-white">
                <h1 class="text-3xl font-bold">
                    Selamat Datang, {{ Auth::user()->name }}! 👋
                </h1>
                <p class="text-blue-200 mt-2">
                    Hari ini adalah hari yang bagus untuk memeriksa informasi terbaru di UNotify.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl shadow border border-white/10 flex items-center gap-4">
                    <div class="p-3 bg-blue-500/20 text-blue-300 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-blue-200/70 font-medium">Total Pengumuman</p>
                        <h3 class="text-2xl font-bold text-white">{{ $announcementsCount ?? 0 }}</h3>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl shadow border border-white/10 flex items-center gap-4">
                    <div class="p-3 bg-green-500/20 text-green-300 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-blue-200/70 font-medium">Komentar Anda</p>
                        <h3 class="text-2xl font-bold text-white">{{ $userCommentsCount ?? 0 }}</h3>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl shadow border border-white/10 flex items-center gap-4">
                    <div class="p-3 bg-purple-500/20 text-purple-300 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 002-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-blue-200/70 font-medium">Hari Ini</p>
                        <h3 class="text-lg font-bold text-white">{{ now()->translatedFormat('d F Y') }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow border border-white/10 p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div class="flex items-center gap-3">
                        <h2 class="text-xl font-bold text-white">
                            📌 Pengumuman Terbaru
                        </h2>
                        
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('announcements.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold px-3 py-1.5 rounded-xl transition shadow-md gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Buat Pengumuman
                            </a>
                        @endif
                    </div>
                    
                    <a href="{{ route('announcements.index') }}" class="text-blue-300 hover:text-blue-200 font-semibold text-sm flex items-center gap-1 transition">
                        Lihat Semua 
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($latestAnnouncements ?? [] as $announcement)
                        <div class="border border-white/10 rounded-xl p-6 bg-white/5 mb-4 shadow-sm hover:bg-white/10 transition duration-150">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-bold text-lg text-white hover:text-blue-300 transition duration-150">
                                        <a href="{{ route('announcements.show', $announcement->id ?? '#') }}">
                                            {{ $announcement->title ?? 'Tanpa Judul' }}
                                        </a>
                                    </h3>

                                    @if($announcement->type && is_array($announcement->type))
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($announcement->type as $singleType)
                                                @php
                                                    $badgeClasses = match($singleType) {
                                                        'URGENT' => 'bg-red-500/20 text-red-300 border-red-500/30',
                                                        'TUGAS' => 'bg-yellow-500/20 text-yellow-300 border-yellow-500/30',
                                                        'UJIAN' => 'bg-purple-500/20 text-purple-300 border-purple-500/30',
                                                        'LIBURAN' => 'bg-green-500/20 text-green-300 border-green-500/30',
                                                        'AKADEMIK' => 'bg-blue-500/20 text-blue-300 border-blue-500/30',
                                                        'EVENT' => 'bg-pink-500/20 text-pink-300 border-pink-500/30',
                                                        default => 'bg-white/10 text-blue-200 border-white/10',
                                                    };
                                                @endphp
                                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full border {{ $badgeClasses }}">
                                                    {{ $singleType }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <span class="text-xs text-blue-200 bg-white/10 border border-white/10 px-2 py-1 rounded-md shadow-sm whitespace-nowrap">
                                    {{ $announcement->created_at ? $announcement->created_at->diffForHumans() : '-' }}
                                </span>
                            </div>
                            
                            <p class="text-blue-100/80 text-sm leading-relaxed mb-4">
                                {{ $announcement->content ?? '' }}
                            </p>

                            <div class="mt-4 border-t border-white/10 pt-4">
                                <h4 class="font-semibold text-sm text-blue-200 mb-2">Komentar:</h4>
                                
                                <div class="space-y-2 max-h-40 overflow-y-auto mb-3">
                                    @forelse($announcement->comments ?? [] as $comment)
                                        <div class="bg-white/5 p-2 rounded-lg border border-white/5 text-xs mb-1">
                                            <span class="font-bold text-blue-300">
                                                {{ $comment->user->name ?? 'User' }}:
                                            </span>
                                            <span class="text-white/80">{{ $comment->content }}</span>
                                        </div>
                                    @empty
                                        <p class="text-xs text-blue-300/40 italic">Belum ada komentar.</p>
                                    @endforelse
                                </div>

                                <form action="{{ route('comments.store') }}" method="POST" class="flex gap-2">
                                    @csrf
                                    <input type="hidden" name="announcement_id" value="{{ $announcement->id ?? '' }}">
                                    <input type="text" name="content" placeholder="Tulis komentar..." 
                                           class="flex-1 border border-white/10 rounded-xl p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white/10 text-white placeholder-blue-300/50" required>
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-4 rounded-xl text-sm font-medium transition shadow-md">
                                        Kirim
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-blue-300/60">
                            <svg class="w-12 h-12 mx-auto mb-3 text-blue-300/40" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-4V8m0 0v8m0-8H8"></path></svg>
                            Belum ada pengumuman baru saat ini.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
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
</x-app-layout>