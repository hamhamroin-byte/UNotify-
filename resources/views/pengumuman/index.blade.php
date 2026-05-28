<x-app-layout>
    <div id="glow-container" class="py-10 min-h-screen relative overflow-hidden">
        <div id="cursor-glow" class="pointer-events-none absolute rounded-full opacity-0 blur-[120px] transition-opacity duration-300 z-0 w-[400px] h-[400px]" 
             style="background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);">
        </div>

        <div class="max-w-5xl mx-auto px-4 relative z-10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white">📢 Semua Pengumuman</h1>
                    <p class="text-blue-200 text-sm mt-1">Manajemen dan daftar seluruh informasi push notification.</p>
                </div>
                
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('announcements.create') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-500 text-white font-medium px-5 py-2.5 rounded-xl transition shadow-lg text-sm gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Buat Pengumuman
                    </a>
                @endif
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow border border-white/10 p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/10 text-blue-300 text-sm font-semibold">
                                <th class="pb-3 pl-2">Tipe</th>
                                <th class="pb-3">Judul</th>
                                <th class="pb-3">Isi Pengumuman</th>
                                <th class="pb-3">Tanggal dibuat</th>
                                @if(Auth::user()->role === 'admin')
                                    <th class="pb-3 text-center">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-white/5 text-blue-100/90">
                            @forelse($announcements ?? [] as $announcement)
                                <tr class="hover:bg-white/5 transition">
                                    <td class="py-4 pl-2 whitespace-nowrap">
                                        @php
                                            $badgeClasses = match($announcement->type ?? '') {
                                                'URGENT' => 'bg-red-500/20 text-red-300 border-red-500/30',
                                                'TUGAS' => 'bg-yellow-500/20 text-yellow-300 border-yellow-500/30',
                                                'UJIAN' => 'bg-purple-500/20 text-purple-300 border-purple-500/30',
                                                'LIBURAN' => 'bg-green-500/20 text-green-300 border-green-500/30',
                                                'AKADEMIK' => 'bg-blue-500/20 text-blue-300 border-blue-500/30',
                                                'EVENT' => 'bg-pink-500/20 text-pink-300 border-pink-500/30',
                                                default => 'bg-white/10 text-blue-200 border-white/10',
                                            };
                                        @endphp
                                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full border {{ $badgeClasses }}">
                                            {{ $announcement->type ?? 'UMUM' }}
                                        </span>
                                    </td>
                                    
                                    <td class="py-4 font-semibold text-white max-w-[150px] truncate">
                                        <a href="{{ route('announcements.show', $announcement->id) }}" class="hover:text-blue-300 transition duration-150">
                                            {{ $announcement->title }}
                                        </a>
                                    </td>
                                    
                                    <td class="py-4 max-w-[250px] truncate pr-4">{{ $announcement->content }}</td>
                                    <td class="py-4 text-xs text-blue-300/80 whitespace-nowrap">
                                        {{ $announcement->created_at ? $announcement->created_at->translatedFormat('d M Y, H:i') : '-' }}
                                    </td>
                                    
                                    @if(Auth::user()->role === 'admin')
                                        <td class="py-4 text-center whitespace-nowrap">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('announcements.edit', $announcement->id) }}" class="text-yellow-400 hover:text-yellow-300 bg-yellow-400/10 border border-yellow-400/20 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                                    Edit
                                                </a>
                                                <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-400 hover:text-red-300 bg-red-400/10 border border-red-400/20 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ Auth::user()->role === 'admin' ? 5 : 4 }}" class="text-center py-8 text-blue-300/50 italic">
                                        Tidak ada data pengumuman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
                container.addEventListener('mouseleave', () => { glow.style.opacity = '0'; });
            }
        });
    </script>
</x-app-layout>