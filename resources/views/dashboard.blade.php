<x-app-layout>
    <div class="py-10 bg-gray-100 min-h-screen">
        <div class="max-w-5xl mx-auto px-4">
            
            <div class="bg-gradient-to-r transition-all from-blue-600 to-indigo-700 rounded-2xl shadow-lg p-6 mb-8 text-white">
                <h1 class="text-3xl font-bold">
                    Selamat Datang, {{ Auth::user()->name }}! 👋
                </h1>
                <p class="text-blue-100 mt-2">
                    Hari ini adalah hari yang bagus untuk memeriksa informasi terbaru di UNotify.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                <div class="bg-white p-5 rounded-2xl shadow flex items-center gap-4">
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Pengumuman</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $announcementsCount ?? 0 }}</h3>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow flex items-center gap-4">
                    <div class="p-3 bg-green-100 text-green-600 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Komentar Anda</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $userCommentsCount ?? 0 }}</h3>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow flex items-center gap-4">
                    <div class="p-3 bg-purple-100 text-purple-600 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 002-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Hari Ini</p>
                        <h3 class="text-lg font-bold text-gray-800">{{ now()->translatedFormat('d F Y') }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800">
                        📌 Pengumuman Terbaru
                    </h2>
                    <a href="{{ route('announcements.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm flex items-center gap-1">
                        Lihat Semua 
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>

                <div class="space-y-4">
                   @forelse($latestAnnouncements ?? [] as $announcement)
    <div class="border border-gray-100 rounded-xl p-6 transition duration-200 bg-gray-50 mb-4">
        <div class="flex justify-between items-start mb-2">
            <h3 class="font-bold text-lg text-gray-800">
                {{ $announcement->title }}
            </h3>
            <span class="text-xs text-gray-400 bg-white border px-2 py-1 rounded-md shadow-sm">
                {{ $announcement->created_at->diffForHumans() }}
            </span>
        </div>
        <p class="text-gray-600 text-sm leading-relaxed mb-4">
            {{ $announcement->content }}
        </p>

        <div class="mt-4 border-t pt-4">
            <h4 class="font-semibold text-sm text-gray-700 mb-2">Komentar:</h4>
            
            <div class="space-y-2 max-h-40 overflow-y-auto mb-3">
                @forelse($announcement->comments as $comment)
                    <div class="bg-white border rounded-xl p-3 text-sm shadow-sm">
                        <div class="font-semibold text-gray-800">{{ $comment->user->name }}</div>
                        <div class="text-gray-600 mt-0.5">{{ $comment->content }}</div>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 italic">Belum ada komentar.</p>
                @endforelse
            </div>

            <form action="{{ route('comments.store') }}" method="POST" class="flex gap-2">
                @csrf
                <input type="hidden" name="announcement_id" value="{{ $announcement->id }}">
                <input type="text" name="content" placeholder="Tulis komentar..." 
                    class="flex-1 border rounded-xl p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded-xl text-sm font-medium">
                    Kirim
                </button>
            </form>
        </div>
    </div>
@empty
    <div class="text-center py-8 text-gray-400">
        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-4V8m0 0v8m0-8H8"></path></svg>
        Belum ada pengumuman baru saat ini.
    </div>
@endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>