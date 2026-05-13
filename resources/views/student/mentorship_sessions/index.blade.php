{{-- resources/views/student/mentorship_sessions/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Sesi Bimbingan - Simagang')
@section('header_title', 'Sesi Bimbingan')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div>
        <h2 class="text-xl font-bold text-slate-800">Jadwal Bimbingan</h2>
        <p class="text-sm text-slate-500 mt-1">Riwayat dan jadwal sesi bimbingan dengan dosen pembimbing Anda.</p>
    </div>

    {{-- Timeline --}}
    <div class="space-y-4">
        @forelse($sessions as $session)
            <div class="bg-white rounded-xl border shadow-sm overflow-hidden transition-all hover:shadow-md
                        {{ $session->status === 'scheduled' ? 'border-blue-200' : ($session->status === 'completed' ? 'border-slate-200' : 'border-red-200') }}">
                <div class="flex flex-col sm:flex-row">
                    {{-- Date Badge --}}
                    <div class="sm:w-28 shrink-0 p-4 flex sm:flex-col items-center sm:justify-center gap-2 sm:gap-0
                                {{ $session->status === 'scheduled' ? 'bg-blue-50' : ($session->status === 'completed' ? 'bg-emerald-50' : 'bg-red-50') }}">
                        <span class="text-2xl font-bold {{ $session->status === 'scheduled' ? 'text-blue-700' : ($session->status === 'completed' ? 'text-emerald-700' : 'text-red-400') }}">
                            {{ \Carbon\Carbon::parse($session->date)->format('d') }}
                        </span>
                        <span class="text-xs font-medium {{ $session->status === 'scheduled' ? 'text-blue-600' : ($session->status === 'completed' ? 'text-emerald-600' : 'text-red-400') }} uppercase">
                            {{ \Carbon\Carbon::parse($session->date)->translatedFormat('M Y') }}
                        </span>
                        <span class="text-xs {{ $session->status === 'scheduled' ? 'text-blue-500' : ($session->status === 'completed' ? 'text-emerald-500' : 'text-red-400') }}">
                            {{ \Carbon\Carbon::parse($session->date)->format('H:i') }}
                        </span>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 p-4 sm:p-5">
                        <div class="flex items-start justify-between gap-3 mb-2">
                            <div>
                                <h3 class="font-semibold text-slate-800 text-sm">{{ $session->topic }}</h3>
                                <p class="text-xs text-slate-500 mt-1">
                                    Dosen: {{ $session->internship->lecturer->user->name ?? '-' }} • {{ $session->internship->company->name }}
                                </p>
                            </div>
                            <div>
                                @if($session->status === 'scheduled')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Terjadwal
                                    </span>
                                @elseif($session->status === 'completed')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai
                                    </span>
                                @elseif($session->status === 'canceled')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Dibatalkan
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if($session->feedback && $session->status === 'completed')
                            <div class="mt-3 bg-emerald-50 rounded-lg p-3 border border-emerald-100">
                                <span class="text-xs font-semibold text-emerald-700 block mb-1">Feedback Dosen:</span>
                                <p class="text-xs text-emerald-800 line-clamp-2">{{ $session->feedback }}</p>
                            </div>
                        @endif

                        <div class="mt-3">
                            <a href="{{ route('student.mentorship_sessions.show', $session) }}"
                               class="inline-flex items-center text-xs font-medium text-primary hover:text-primary/80">
                                Lihat Detail
                                <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-slate-500 font-medium">Belum ada jadwal sesi bimbingan.</p>
                <p class="text-xs text-slate-400 mt-1">Dosen pembimbing Anda akan menjadwalkan sesi bimbingan.</p>
            </div>
        @endforelse
    </div>

    @if($sessions->hasPages())
        <div class="mt-4">
            {{ $sessions->links('pagination::tailwind') }}
        </div>
    @endif

</div>
@endsection
