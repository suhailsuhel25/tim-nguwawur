{{-- resources/views/student/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa - Simagang')
@section('header_title', 'Dashboard')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">
    {{-- Welcome Banner --}}
    <div class="bg-gradient-to-r from-primary to-blue-600 rounded-2xl p-8 text-white shadow-md relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-primary-100 max-w-xl text-sm leading-relaxed">Ini adalah dashboard akademik Anda. Pantau status magang, kumpulkan laporan mingguan, dan jadwalkan sesi bimbingan dengan dosen pembimbing Anda.</p>
        </div>
        <svg class="absolute right-0 bottom-0 text-white/10 w-64 h-64 -mb-16 -mr-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 22h20L12 2zm0 4.5l6.5 13h-13L12 6.5z"/></svg>
    </div>

    @if(!$internship)
        {{-- No Internship Yet --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-10 text-center">
            <div class="inline-flex h-16 w-16 rounded-full bg-slate-50 items-center justify-center mb-4 border border-slate-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Belum Terdaftar Magang</h3>
            <p class="text-slate-500 text-sm max-w-md mx-auto mb-6">Anda belum memiliki data magang yang aktif. Silakan daftar terlebih dahulu untuk memulai periode magang Anda.</p>
            <a href="{{ route('student.internships.create') }}" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-2.5 rounded-xl font-medium hover:bg-primary/90 transition-colors shadow-sm">
                Daftar Magang Sekarang
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column: Stats & Progress --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Status Card --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col sm:flex-row items-center gap-6">
                    <div class="h-20 w-20 rounded-full flex items-center justify-center shrink-0 shadow-inner
                        @if($internship->status === 'approved') bg-emerald-100 text-emerald-600
                        @elseif($internship->status === 'pending') bg-amber-100 text-amber-600
                        @elseif($internship->status === 'rejected') bg-red-100 text-red-600
                        @else bg-slate-100 text-slate-600 @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            @if($internship->status === 'approved') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            @elseif($internship->status === 'pending') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            @elseif($internship->status === 'rejected') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            @else <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /> @endif
                        </svg>
                    </div>
                    <div class="text-center sm:text-left flex-1">
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Status Magang Saat Ini</p>
                        <h3 class="text-2xl font-bold text-slate-800 capitalize mb-2">
                            @if($internship->status === 'approved') Disetujui / Aktif
                            @elseif($internship->status === 'pending') Menunggu Persetujuan
                            @elseif($internship->status === 'rejected') Ditolak
                            @else Selesai @endif
                        </h3>
                        <p class="text-sm text-slate-600">Perusahaan: <strong>{{ $internship->company->name }}</strong></p>
                    </div>
                    @if($internship->status === 'approved')
                        <a href="{{ route('student.internships.index') }}" class="shrink-0 px-4 py-2 border border-slate-200 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">Lihat Detail</a>
                    @endif
                </div>

                {{-- Stats Grid --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center">
                        <span class="block text-3xl font-bold text-blue-600">{{ $stats['weekly_reports'] }}</span>
                        <span class="block text-xs font-medium text-slate-500 mt-1 uppercase tracking-wider">Total Laporan</span>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center">
                        <span class="block text-3xl font-bold text-amber-600">{{ $stats['pending_reports'] }}</span>
                        <span class="block text-xs font-medium text-slate-500 mt-1 uppercase tracking-wider">Menunggu Validasi</span>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center">
                        <span class="block text-3xl font-bold text-violet-600">{{ $stats['mentorship_sessions'] }}</span>
                        <span class="block text-xs font-medium text-slate-500 mt-1 uppercase tracking-wider">Sesi Bimbingan</span>
                    </div>
                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 p-5 rounded-2xl border border-emerald-200 shadow-sm text-center flex flex-col justify-center relative overflow-hidden">
                        @if($internship->finalGrade)
                            <span class="block text-4xl font-bold text-emerald-700 z-10">{{ $internship->finalGrade->final_grade }}</span>
                            <span class="block text-xs font-bold text-emerald-600 mt-1 uppercase tracking-wider z-10">Nilai Akhir</span>
                            <svg class="absolute right-0 bottom-0 text-emerald-200/50 w-24 h-24 -mb-8 -mr-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>
                        @else
                            <span class="block text-2xl font-bold text-emerald-700/50 z-10">-</span>
                            <span class="block text-xs font-medium text-emerald-600/70 mt-1 uppercase tracking-wider z-10">Nilai Belum Keluar</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Column: Agenda --}}
            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 h-full flex flex-col">
                    <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4 flex items-center justify-between">
                        <span>Agenda Bimbingan Terdekat</span>
                        <a href="{{ route('student.mentorship_sessions.index') }}" class="text-xs font-medium text-primary hover:underline">Lihat Semua</a>
                    </h3>
                    
                    @if($upcomingSessions->count() > 0)
                        <ul class="space-y-4 flex-1">
                            @foreach($upcomingSessions as $session)
                                <li class="flex gap-4 p-3 rounded-xl border border-slate-100 bg-slate-50 hover:bg-slate-100 transition-colors">
                                    <div class="shrink-0 bg-white border border-slate-200 rounded-lg p-2 text-center min-w-[50px] shadow-sm">
                                        <span class="block text-[10px] font-bold text-red-500 uppercase">{{ \Carbon\Carbon::parse($session->date)->translatedFormat('M') }}</span>
                                        <span class="block text-lg font-bold text-slate-800 leading-none mt-1">{{ \Carbon\Carbon::parse($session->date)->format('d') }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-slate-800 line-clamp-1">{{ $session->topic }}</p>
                                        <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            {{ \Carbon\Carbon::parse($session->date)->format('H:i') }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="flex-1 flex flex-col items-center justify-center text-center p-6 border-2 border-dashed border-slate-100 rounded-xl">
                            <div class="h-12 w-12 rounded-full bg-slate-50 flex items-center justify-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-slate-500">Tidak ada jadwal bimbingan terdekat.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
