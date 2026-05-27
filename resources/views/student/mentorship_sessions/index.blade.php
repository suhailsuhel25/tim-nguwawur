{{-- resources/views/student/mentorship_sessions/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Sesi Bimbingan - Simagang')
@section('header_title', 'Sesi Bimbingan')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-800 via-slate-700 to-slate-900 p-6 md:p-8 shadow-xl">
        
        <div class="absolute top-0 right-0 opacity-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-52 w-52" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 14.93V19h-2v-2.07A8.001 8.001 0 014.07 13H2v-2h2.07A8.001 8.001 0 0111 4.07V2h2v2.07A8.001 8.001 0 0119.93 11H22v2h-2.07A8.001 8.001 0 0113 16.93z"/>
            </svg>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            <div>
                <p class="text-slate-300 text-sm font-medium mb-2">
                    Monitoring Jadwal Bimbingan
                </p>

                <h1 class="text-3xl font-bold text-white leading-tight">
                    Sesi Bimbingan Mahasiswa
                </h1>

                <p class="text-slate-300 text-sm mt-3 max-w-2xl">
                    Pantau jadwal bimbingan, feedback dosen, dan progres konsultasi magang Anda secara terorganisir.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-4 min-w-[240px]">

                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/10">
                    <p class="text-slate-300 text-xs">Total Sesi</p>
                    <h3 class="text-2xl font-bold text-white mt-1">
                        {{ $sessions->total() }}
                    </h3>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/10">
                    <p class="text-slate-300 text-xs">Terjadwal</p>
                    <h3 class="text-2xl font-bold text-white mt-1">
                        {{ $sessions->where('status', 'scheduled')->count() }}
                    </h3>
                </div>

            </div>
        </div>
    </div>

    {{-- Sessions --}}
    <div class="space-y-5">

        @forelse($sessions as $session)

            <div class="group bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">

                <div class="flex flex-col lg:flex-row">

                    {{-- Date Section --}}
                    <div class="lg:w-52 shrink-0 bg-gradient-to-br
                        {{ $session->status === 'scheduled' ? 'from-slate-50 to-slate-100 border-slate-200' : '' }}
                        {{ $session->status === 'completed' ? 'from-emerald-50 to-green-50 border-emerald-100' : '' }}
                        {{ $session->status === 'canceled' ? 'from-red-50 to-rose-50 border-red-100' : '' }}
                        border-r p-6 flex flex-col justify-center items-center text-center">

                        <div class="h-16 w-16 rounded-2xl flex items-center justify-center mb-4
                            {{ $session->status === 'scheduled' ? 'bg-slate-200 text-slate-700' : '' }}
                            {{ $session->status === 'completed' ? 'bg-emerald-100 text-emerald-600' : '' }}
                            {{ $session->status === 'canceled' ? 'bg-red-100 text-red-600' : '' }}">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>

                        <h2 class="text-4xl font-extrabold text-slate-800">
                            {{ \Carbon\Carbon::parse($session->date)->format('d') }}
                        </h2>

                        <p class="text-sm font-semibold text-slate-600 uppercase mt-1">
                            {{ \Carbon\Carbon::parse($session->date)->translatedFormat('M Y') }}
                        </p>

                        <p class="text-xs text-slate-500 mt-2">
                            {{ \Carbon\Carbon::parse($session->date)->format('H:i') }} WIB
                        </p>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 p-6">

                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">

                            <div class="flex-1">

                                {{-- Status --}}
                                <div class="flex flex-wrap items-center gap-3 mb-3">

                                    @if($session->status === 'scheduled')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                            <span class="w-2 h-2 rounded-full bg-slate-500"></span>
                                            Terjadwal
                                        </span>

                                    @elseif($session->status === 'completed')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            Selesai
                                        </span>

                                    @elseif($session->status === 'canceled')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                            Dibatalkan
                                        </span>
                                    @endif

                                </div>

                                {{-- Topic --}}
                                <h2 class="text-xl font-bold text-slate-800 group-hover:text-primary transition-colors">
                                    {{ $session->topic }}
                                </h2>

                                {{-- Info --}}
                                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">

                                    {{-- Lecturer --}}
                                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">

                                        <p class="text-xs text-slate-500 mb-1">
                                            Dosen Pembimbing
                                        </p>

                                        <div class="flex items-center gap-3">

                                            <div class="h-10 w-10 rounded-xl bg-slate-200 text-slate-700 flex items-center justify-center font-bold">
                                                {{ substr($session->internship->lecturer->user->name ?? 'D', 0, 1) }}
                                            </div>

                                            <div>
                                                <p class="text-sm font-semibold text-slate-800">
                                                    {{ $session->internship->lecturer->user->name ?? '-' }}
                                                </p>

                                                <p class="text-xs text-slate-500">
                                                    Pembimbing Magang
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Company --}}
                                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">

                                        <p class="text-xs text-slate-500 mb-1">
                                            Tempat Magang
                                        </p>

                                        <div class="flex items-center gap-3">

                                            <div class="h-10 w-10 rounded-xl bg-slate-200 text-slate-700 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4"/>
                                                </svg>
                                            </div>

                                            <div>
                                                <p class="text-sm font-semibold text-slate-800">
                                                    {{ $session->internship->company->name }}
                                                </p>

                                                <p class="text-xs text-slate-500">
                                                    Perusahaan Magang
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- Feedback --}}
                                @if($session->feedback && $session->status === 'completed')
                                    <div class="mt-5 bg-emerald-50 border border-emerald-100 rounded-2xl p-4">

                                        <div class="flex items-center gap-2 mb-2">
                                            <div class="h-8 w-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                                </svg>
                                            </div>

                                            <p class="text-sm font-semibold text-emerald-700">
                                                Feedback Dosen
                                            </p>
                                        </div>

                                        <p class="text-sm text-emerald-800 leading-relaxed">
                                            {{ $session->feedback }}
                                        </p>

                                    </div>
                                @endif

                            </div>

                            {{-- Action --}}
                            <div class="flex lg:flex-col justify-end">

                                <a href="{{ route('student.mentorship_sessions.show', $session) }}"
                                   class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-slate-800 text-white text-sm font-semibold hover:bg-slate-700 shadow-lg shadow-slate-300 transition-all">

                                    Detail

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>

                                </a>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

        @empty

            {{-- Empty State --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-14 text-center">

                <div class="h-24 w-24 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>

                <h3 class="text-xl font-bold text-slate-800 mb-2">
                    Belum Ada Jadwal Bimbingan
                </h3>

                <p class="text-sm text-slate-500 max-w-md mx-auto leading-relaxed">
                    Jadwal sesi bimbingan akan muncul setelah dosen pembimbing membuat sesi konsultasi untuk kegiatan magang Anda.
                </p>

            </div>

        @endforelse

    </div>

    {{-- Pagination --}}
    @if($sessions->hasPages())
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm px-5 py-4">
            {{ $sessions->links('pagination::tailwind') }}
        </div>
    @endif

</div>
@endsection