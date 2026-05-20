<x-app-layout>
    <div class="py-10 bg-gray-100 min-h-screen">
        <div class="max-w-5xl mx-auto">

            @if(session('success'))
                <div id="notification-alert" class="mb-6 flex items-center justify-between p-4 bg-green-100 border-l-4 border-green-500 rounded-xl text-green-700 shadow-sm transition-opacity duration-500 opacity-100">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="document.getElementById('notification-alert').remove()" class="text-green-500 hover:text-green-700 font-bold px-2">
                        ✕
                    </button>
                </div>
            @endif

            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800">
                        Pengumuman
                    </h1>
                    <p class="text-gray-500 mt-1">
                        Semua informasi terbaru UNotify
                    </p>
                </div>
                
                @if(Auth::user()->role == 'admin' || Auth::user()->is_admin == 1)
                    <a href="{{ route('announcements.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl shadow">
                        + Buat Pengumuman
                    </a>
                @endif
            </div>

            @foreach($announcements as $announcement)
                <div class="bg-white rounded-2xl shadow p-6 mb-5">
                    
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">
                        {{ $announcement->title }}
                    </h2>

                    <p class="text-gray-600 leading-relaxed">
                        {{ $announcement->content }}
                    </p>

                    <div class="mt-4 text-sm text-gray-400">
                        Diposting: {{ $announcement->created_at->diffForHumans() }}
                    </div>

                    @if(Auth::user()->role == 'admin' || Auth::user()->is_admin == 1)
                        <div class="flex gap-3 mt-5">
                            <a href="{{ route('announcements.edit', $announcement->id) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center justify-center">
                                Edit
                            </a>

                            <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @endif

                    <div class="mt-6 border-t pt-5">
                        <h3 class="font-bold text-lg mb-3">
                            Komentar
                        </h3>

                        @foreach($announcement->comments as $comment)
                            <div class="bg-gray-100 rounded-xl p-3 mb-2">
                                <div class="font-semibold text-sm">
                                    {{ $comment->user->name }}
                                </div>
                                <div class="text-gray-700">
                                    {{ $comment->content }}
                                </div>
                            </div>
                        @endforeach

                        <form action="{{ route('comments.store') }}" method="POST" class="mt-4 flex gap-3">
                            @csrf
                            <input type="hidden" name="announcement_id" value="{{ $announcement->id }}">
                            
                            <input type="text" name="content" placeholder="Tulis komentar..." 
                                class="flex-1 border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 rounded-xl">
                                Kirim
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach

        </div>
    </div>

    <script>
        setTimeout(() => {
            const alert = document.getElementById('notification-alert');
            if (alert) {
                // Mengubah opacity menjadi 0 agar efek transisi Tailwind berjalan
                alert.classList.remove('opacity-100');
                alert.classList.add('opacity-0');
                
                // Menghapus elemen dari struktur HTML setelah transisi memudar selesai (500ms)
                setTimeout(() => alert.remove(), 500);
            }
        }, 4000);
    </script>
</x-app-layout>