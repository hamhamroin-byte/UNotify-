<x-app-layout>
    <div class="py-10 max-w-3xl mx-auto px-4">
        <h1 class="text-2xl font-bold text-white mb-6">📢 Buat Pengumuman Baru</h1>

        <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data" class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/10 shadow-lg">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-semibold text-white mb-2">Judul Pengumuman</label>
                <input type="text" name="title" required class="w-full rounded-xl bg-white/5 border-white/10 text-white focus:border-blue-500 focus:ring-blue-500">
                @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-white mb-2">🏷️ Kategori / Tipe Pengumuman (Bisa pilih lebih dari satu):</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 bg-black/20 p-4 rounded-xl border border-white/5">
                    @foreach(['URGENT', 'TUGAS', 'UJIAN', 'LIBURAN', 'AKADEMIK', 'EVENT'] as $genre)
                        <label class="flex items-center gap-2 text-sm text-blue-100 cursor-pointer hover:text-white transition">
                            <input type="checkbox" name="type[]" value="{{ $genre }}" class="rounded bg-white/10 border-white/20 text-blue-600 focus:ring-blue-500">
                            <span>{{ $genre }}</span>
                        </label>
                    @endforeach
                </div>
                @error('type') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-white mb-2">🎯 Target Kelas Pengumuman:</label>
                <select id="target_class" name="target_class" required 
                        class="w-full text-sm border border-white/10 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-800 text-white transition">
                    <option value="ALL" selected>Semua Kelas (Broadcast Global)</option>
                    <option value="ICA24">Khusus Kelas ICA24</option>
                    <option value="ICB24">Khusus Kelas ICB24</option>
                    <option value="ICC24">Khusus Kelas ICC24</option>
                    <option value="ICD24">Khusus Kelas ICD24</option>
                    <option value="ICE24">Khusus Kelas ICE24</option>
                </select>
                @error('target_class') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-white mb-2">Isi Pengumuman</label>
                <textarea name="content" rows="5" required class="w-full rounded-xl bg-white/5 border-white/10 text-white focus:border-blue-500 focus:ring-blue-500"></textarea>
                @error('content') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-white mb-2">📁 Lampiran File (Opsional)</label>
                <div class="bg-black/10 p-4 rounded-xl border border-white/10">
                    <input type="file" name="attachment" accept="image/*,application/pdf"
                           class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-500 file:transition file:cursor-pointer">
                    <p class="text-[11px] text-slate-400 mt-2">Ekstensi yang diizinkan: JPG, JPEG, PNG, atau PDF. Maksimal ukuran 5MB.</p>
                </div>
                @error('attachment') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('announcements.index') }}" class="px-5 py-2.5 rounded-xl bg-white/5 text-white hover:bg-white/10 transition text-sm">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 text-white hover:bg-blue-500 transition font-medium text-sm shadow-lg">Rilis & Kirim Notif</button>
            </div>
        </form>
    </div>
</x-app-layout>