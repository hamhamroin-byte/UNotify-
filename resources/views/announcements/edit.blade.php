<x-app-layout>
    <div id="glow-container" class="py-10 min-h-screen relative overflow-hidden">
        <div id="cursor-glow" class="pointer-events-none absolute rounded-full opacity-0 blur-[120px] transition-opacity duration-300 z-0 w-[400px] h-[400px]" 
             style="background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);">
        </div>

        <div class="max-w-2xl mx-auto px-4 relative z-10">
            <div class="mb-6">
                <a href="{{ route('announcements.index') }}" class="text-blue-300 hover:text-blue-200 text-sm font-medium flex items-center gap-1 transition">
                    ← Batal & Kembali
                </a>
                <h1 class="text-3xl font-bold text-white mt-2">✏️ Edit Pengumuman</h1>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow border border-white/10 p-6">
                <form action="{{ route('announcements.update', $announcement->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-sm font-semibold text-blue-200 mb-2">Judul Pengumuman</label>
                        <input type="text" name="title" value="{{ old('title', $announcement->title) }}" required
                            class="w-full border border-white/10 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white/10 text-white placeholder-blue-300/40">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-blue-200 mb-2">Isi Konten Informasi</label>
                        <textarea name="content" rows="5" required
                            class="w-full border border-white/10 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white/10 text-white placeholder-blue-300/40">{{ old('content', $announcement->content) }}</textarea>
                    </div>

                    <div class="pt-2 flex justify-end gap-3">
                        <a href="{{ route('announcements.index') }}" class="bg-white/5 border border-white/10 hover:bg-white/10 text-blue-200 px-5 py-2.5 rounded-xl text-sm font-medium transition">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2.5 rounded-xl text-sm font-medium transition shadow-md">
                            💾 Simpan Perubahan
                        </button>
                    </div>
                </form>
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