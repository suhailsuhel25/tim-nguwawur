{{-- resources/views/notifications/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Notifikasi - Simagang')
@section('header_title', 'Notifikasi')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Semua Notifikasi</h2>
            <p class="text-sm text-slate-500 mt-1">Pemberitahuan aktivitas dan pembaruan sistem.</p>
        </div>
        @if($notifications->contains('is_read', false))
            <form action="{{ route('notifications.markAllRead') }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Tandai Semua Dibaca
                </button>
            </form>
        @endif
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-lg shadow-sm">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    {{-- Notifications List --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <ul class="divide-y divide-slate-100">
            @forelse($notifications as $notif)
                @php
                    $iconClass = match($notif->type) {
                        'info' => 'bg-blue-100 text-blue-600',
                        'warning' => 'bg-amber-100 text-amber-600',
                        'deadline' => 'bg-red-100 text-red-600',
                        'status_update' => 'bg-emerald-100 text-emerald-600',
                        default => 'bg-slate-100 text-slate-600'
                    };

                    $iconSvg = match($notif->type) {
                        'info' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        'warning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
                        'deadline' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        'status_update' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        default => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>'
                    };
                @endphp
                <li class="relative {{ $notif->is_read ? 'bg-white' : 'bg-slate-50/80' }} hover:bg-slate-50 transition-colors group">
                    <div class="p-5 flex gap-4">
                        <div class="shrink-0 h-10 w-10 rounded-full flex items-center justify-center {{ $iconClass }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                {!! $iconSvg !!}
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <p class="text-sm font-semibold {{ $notif->is_read ? 'text-slate-700' : 'text-slate-900' }}">
                                        {{ $notif->title }}
                                        @if(!$notif->is_read)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-primary text-white ml-2 align-middle">Baru</span>
                                        @endif
                                    </p>
                                    <p class="text-sm text-slate-600 mt-1 leading-relaxed line-clamp-2 group-hover:line-clamp-none transition-all">{{ $notif->message }}</p>
                                </div>
                                <span class="shrink-0 text-[11px] text-slate-400 font-medium whitespace-nowrap">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <div class="mt-3 flex items-center gap-3">
                                @if(!$notif->is_read)
                                <form action="{{ route('notifications.read', $notif) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs font-medium text-primary hover:text-primary/80">Tandai Dibaca</button>
                                </form>
                                @endif

                                @if($notif->related_model && $notif->related_id)
                                    @if(!$notif->is_read)
                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                    @endif
                                    <form action="{{ route('notifications.read', $notif) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs font-medium text-slate-500 hover:text-slate-800 flex items-center gap-1">
                                            Lihat Detail
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <li class="p-12 text-center">
                    <div class="inline-flex h-16 w-16 rounded-full bg-slate-100 text-slate-400 items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <p class="text-slate-500 font-medium">Belum ada notifikasi.</p>
                    <p class="text-sm text-slate-400 mt-1">Anda akan menerima pemberitahuan di sini.</p>
                </li>
            @endforelse
        </ul>
        
        @if($notifications->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $notifications->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection
