<header class="bg-slate-900 border-b border-white/10 shadow-md relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <div class="flex-shrink-0 flex items-center gap-6">
                <a href="/dashboard" class="text-white font-bold text-xl tracking-wider hover:text-blue-400 transition">
                    UNotify
                </a>
                <nav class="hidden md:flex space-x-4">
                    <a href="/dashboard" class="text-sm text-slate-300 hover:text-white transition px-3 py-2 rounded-xl {{ request()->is('dashboard') ? 'bg-white/5 text-white' : '' }}">Dashboard</a>
                    <a href="/announcements" class="text-sm text-slate-300 hover:text-white transition px-3 py-2 rounded-xl {{ request()->is('announcements*') ? 'bg-white/5 text-white' : '' }}">Pengumuman</a>
                </nav>
            </div>

            <div class="ml-4 flex items-center md:ml-6 relative" x-data="{ open: false }">
                <button 
                    @click="open = !open" 
                    @click.away="open = false"
                    class="max-w-xs bg-white/5 border border-white/10 rounded-full flex items-center gap-2.5 px-3 py-1.5 text-sm focus:outline-none hover:bg-white/10 transition duration-150 ease-in-out" 
                    id="user-menu" 
                    aria-label="User menu" 
                    aria-haspopup="true"
                >
                    @if(auth()->user()->role === 'admin')
                        <span class="bg-red-500/20 border border-red-500/30 text-red-400 text-[9px] font-extrabold px-2 py-0.5 rounded-md tracking-wider">
                            ADMIN
                        </span>
                    @endif

                    <span class="text-slate-300 text-xs font-medium hidden sm:inline max-w-[100px] truncate">{{ auth()->user()->name }}</span>

                    <img class="h-8 w-8 rounded-full object-cover border-2 border-blue-500/50 shadow-sm bg-slate-800" 
                         src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'User') . '&color=fff&background=2563eb' }}" 
                         alt="Profile">
                </button>

                <div 
                    x-show="open"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="origin-top-right absolute right-0 top-full mt-2 w-52 rounded-xl shadow-2xl py-1 bg-slate-900 border border-white/10 ring-1 ring-black ring-opacity-5 focus:outline-none z-50 text-white"
                    style="display: none;"
                >
                    <div class="px-4 py-2.5 border-b border-white/5 bg-white/5 rounded-t-xl">
                        <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-blue-400 font-medium uppercase tracking-wider mt-0.5">Kelas: {{ auth()->user()->class ?? 'ALL' }}</p>
                    </div>

                    <div class="px-4 py-1.5 text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-1">
                        Menu Akun
                    </div>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition {{ request()->routeIs('admin.users.*') ? 'bg-white/5 text-white' : '' }}">
                            <span>👥</span> Kelola Pengguna
                        </a>
                    @endif

                    <a href="/profile" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition">
                        <span>⚙️</span> Pengaturan Profil
                    </a>

                    <div class="border-t border-white/5 my-1"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 transition font-medium rounded-b-xl">
                            <span>🚪</span> Keluar Akun
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>