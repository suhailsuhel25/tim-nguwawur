{{-- resources/views/components/navbar.blade.php --}}
<header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 sticky top-0 z-20">
    <!-- Mobile Hamburger -->
    <button @click="sidebarOpen = true" class="lg:hidden text-slate-500 hover:text-primary">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <div class="hidden lg:block font-medium text-slate-600">
        @yield('header_title', 'Dashboard')
    </div>

    <!-- Right Side -->
    <div class="flex items-center gap-4 ml-auto">
        <!-- Notification Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false" class="relative text-slate-400 hover:text-primary transition-colors focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                @if(isset($unreadCount) && $unreadCount > 0)
                    <span class="absolute -top-1.5 -right-1.5 flex h-4 w-4 items-center justify-center">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500 text-[9px] font-bold text-white items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                    </span>
                @endif
            </button>

            <!-- Dropdown menu -->
            <div x-show="open" x-transition.opacity.duration.200ms class="absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-lg border border-slate-200 z-50 overflow-hidden" style="display: none;">
                <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="text-sm font-bold text-slate-800">Notifikasi</h3>
                    @if(isset($unreadCount) && $unreadCount > 0)
                        <form action="{{ route('notifications.markAllRead') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs text-primary hover:text-primary/80 font-medium">Tandai semua dibaca</button>
                        </form>
                    @endif
                </div>
                
                <div class="max-h-[320px] overflow-y-auto">
                    @if(isset($unreadNotifications) && $unreadNotifications->count() > 0)
                        <ul class="divide-y divide-slate-100">
                            @foreach($unreadNotifications as $notif)
                                <li class="p-4 hover:bg-slate-50 transition-colors">
                                    <div class="flex gap-3">
                                        <div class="shrink-0 mt-0.5">
                                            @if($notif->type === 'warning' || $notif->type === 'deadline')
                                                <div class="h-2 w-2 rounded-full bg-red-500 mt-1.5"></div>
                                            @elseif($notif->type === 'status_update')
                                                <div class="h-2 w-2 rounded-full bg-emerald-500 mt-1.5"></div>
                                            @else
                                                <div class="h-2 w-2 rounded-full bg-primary mt-1.5"></div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-slate-800">{{ $notif->title }}</p>
                                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $notif->message }}</p>
                                            <div class="flex items-center justify-between mt-2">
                                                <span class="text-[10px] text-slate-400">{{ $notif->created_at->diffForHumans() }}</span>
                                                <form action="{{ route('notifications.read', $notif) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-[11px] font-medium text-primary hover:underline">Lihat Detail</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-6 text-center">
                            <p class="text-sm text-slate-500">Tidak ada notifikasi baru.</p>
                        </div>
                    @endif
                </div>

                <div class="p-3 border-t border-slate-100 bg-slate-50 text-center">
                    <a href="{{ route('notifications.index') }}" class="text-xs font-medium text-slate-600 hover:text-primary transition-colors">Lihat Semua Notifikasi</a>
                </div>
            </div>
        </div>

        <!-- User Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 text-sm font-medium text-slate-700 hover:text-primary focus:outline-none">
                <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center text-primary border border-primary/20">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <span class="hidden md:block">{{ Auth::user()->name ?? 'User Name' }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            
            <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 border border-slate-200 z-50" style="display: none;">
                <div class="px-4 py-2 border-b border-slate-100">
                    <p class="text-sm font-medium text-slate-900">{{ Auth::user()->name ?? 'User' }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ Auth::user()->username ?? 'ID' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">Sign Out</button>
                </form>
            </div>
        </div>
    </div>
</header>
