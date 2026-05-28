<x-app-layout>
    <div class="py-10 max-w-4xl mx-auto px-4">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm text-blue-300 hover:text-white transition gap-2 mb-6">
            ← Kembali ke Dashboard
        </a>

        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 sm:p-8 border border-white/10 shadow-xl mb-6">
            <div class="flex justify-between items-start gap-4 mb-2">
                <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ $announcement->title }}</h1>
                <span class="text-xs text-blue-300/70 bg-white/5 px-3 py-1.5 rounded-xl border border-white/5 whitespace-nowrap">
                    {{ $announcement->created_at ? $announcement->created_at->diffForHumans() : '-' }}
                </span>
            </div>

            @if($announcement->type && is_array($announcement->type))
                <div class="flex flex-wrap gap-1.5 mb-6">
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
                        <span class="text-xs font-bold px-2.5 py-0.5 rounded-full border {{ $badgeClasses }}">
                            {{ $singleType }}
                        </span>
                    @endforeach
                </div>
            @endif

            <div class="text-blue-100 text-base leading-relaxed border-t border-white/10 pt-4 mb-4">
                {!! nl2br(e($announcement->content)) !!}
            </div>

            @if($announcement->attachment)
                <div class="mt-6 pt-6 border-t border-white/10">
                    <h4 class="text-xs font-semibold text-blue-300 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                        <span>📂</span> Lampiran Dokumen / Foto:
                    </h4>
                    
                    @php
                        $extension = pathinfo($announcement->attachment, PATHINFO_EXTENSION);
                    @endphp

                    @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                        <div class="relative max-w-xl rounded-xl overflow-hidden border border-white/10 shadow-lg group">
                            <img src="{{ asset('storage/' . $announcement->attachment) }}" 
                                 alt="Lampiran Pengumuman" 
                                 class="w-full h-auto object-cover max-h-96 transition duration-300 group-hover:scale-[1.02]">
                            <a href="{{ asset('storage/' . $announcement->attachment) }}" target="_blank" 
                               class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-sm font-medium text-white transition duration-200">
                                🔍 Lihat Gambar Penuh
                            </a>
                        </div>
                    @elseif(strtolower($extension) === 'pdf')
                        <div class="flex items-center justify-between p-4 bg-white/5 border border-white/10 rounded-xl max-w-md hover:bg-white/10 transition">
                            <div class="flex items-center gap-3 truncate mr-4">
                                <span class="text-3xl flex-shrink-0">📄</span>
                                <div class="truncate">
                                    <p class="text-sm font-medium text-white truncate">Dokumen_Lampiran.pdf</p>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-wider">{{ $extension }} File</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $announcement->attachment) }}" target="_blank" 
                               class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold px-4 py-2 rounded-xl transition shadow-md flex-shrink-0">
                                Lihat / Unduh
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10 shadow-xl mb-6">
            <h3 class="text-lg font-bold text-white mb-4">💬 Komentar ({{ $announcement->comments->count() }})</h3>
            
            <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 mb-6">
                @forelse($announcement->comments as $comment)
                    <div class="bg-white/5 border border-white/5 rounded-xl p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold text-blue-300">
                                {{ $comment->user->name ?? 'Anonim' }}
                            </span>
                            <span class="text-[11px] text-blue-100/50">
                                {{ $comment->created_at ? $comment->created_at->diffForHumans() : '-' }}
                            </span>
                        </div>
                        <p class="text-sm text-blue-100 leading-relaxed">
                            {{ $comment->content }}
                        </p>
                    </div>
                @empty
                    <p class="text-sm italic text-blue-300/50 py-4 text-center">Belum ada komentar. Jadilah yang pertama memberikan respon!</p>
                @endempty
            </div>

            <form action="{{ route('comments.store') }}" method="POST" class="border-t border-white/10 pt-4">
                @csrf
                <input type="hidden" name="announcement_id" value="{{ $announcement->id }}">
                
                <div class="mb-3">
                    <label for="content" class="block text-xs font-medium text-blue-200 mb-2">Tulis Respon / Komentar Anda:</label>
                    <textarea name="content" id="content" rows="3" required placeholder="Ketik komentar di sini..." 
                              class="w-full text-sm border border-white/10 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white/5 text-white placeholder-blue-300/40"></textarea>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-medium transition shadow-md">
                        Kirim Komentar
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>