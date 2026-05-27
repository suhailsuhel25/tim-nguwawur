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
