<x-app-layout>
    <div class="py-10 max-w-6xl mx-auto px-4 text-white">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">👥 Kelola Akun Pengguna</h1>
                <p class="text-slate-400 text-sm mt-1">Manajemen data hak akses (role) dan kelas mahasiswa UNotify.</p>
            </div>
            <div class="bg-blue-600/10 border border-blue-500/20 px-4 py-2 rounded-xl text-sm text-blue-400 font-medium">
                Total Pengguna: {{ $users->count() }}
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-4 rounded-xl mb-6 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl mb-6 text-sm">
                ❌ {{ session('error') }}
            </div>
        @endif

        <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/10 shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-black/20 border-b border-white/10 text-slate-300 text-xs font-semibold uppercase tracking-wider">
                            <th class="p-4">Pengguna</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Hak Akses (Role)</th>
                            <th class="p-4">Kelas</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        @foreach($users as $user)
                            <tr class="hover:bg-white/5 transition">
                                <td class="p-4 flex items-center gap-3">
                                    <img class="h-9 w-9 rounded-full object-cover border-2 border-blue-500/30 bg-slate-800" 
                                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=fff&background=2563eb' }}" 
                                         alt="{{ $user->name }}">
                                    <div>
                                        <p class="font-semibold text-white flex items-center gap-1.5">
                                            {{ $user->name }}
                                            @if($user->id === Auth::id())
                                                <span class="text-[9px] bg-white/10 text-slate-400 px-1.5 py-0.5 rounded">Anda</span>
                                            @endif
                                        </p>
                                        <p class="text-[11px] text-slate-400">Terdaftar: {{ $user->created_at->format('d M Y') }}</p>
                                    </div>
                                </td>

                                <td class="p-4 text-slate-300">
                                    {{ $user->email }}
                                </td>

                                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <td class="p-4">
                                        <select name="role" onchange="this.form.submit()" {{ $user->id === Auth::id() ? 'disabled' : '' }}
                                                class="bg-slate-900 border border-white/10 rounded-xl text-xs px-2.5 py-1.5 text-white focus:ring-blue-500 focus:border-blue-500 transition cursor-pointer">
                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>USER / MAHASISWA</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>ADMIN</option>
                                        </select>
                                    </td>

                                    <td class="p-4">
                                        <select name="class" onchange="this.form.submit()"
                                                class="bg-slate-900 border border-white/10 rounded-xl text-xs px-2.5 py-1.5 text-white focus:ring-blue-500 focus:border-blue-500 transition cursor-pointer">
                                            @foreach(['ALL', 'ICA24', 'ICB24', 'ICC24', 'ICD24', 'ICE24'] as $cl)
                                                <option value="{{ $cl }}" {{ $user->class === $cl ? 'selected' : '' }}>{{ $cl }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </form>

                                <td class="p-4 text-center">
                                    @if($user->id !== Auth::id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }} secara permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white px-3 py-1.5 rounded-xl text-xs font-medium transition shadow-sm border border-red-500/20">
                                                🗑️ Hapus Akun
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-500 italic">No Action</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>