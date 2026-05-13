{{-- resources/views/lecturer/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Dosen - Simagang')
@section('header_title', 'Dashboard')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    {{-- Welcome Banner --}}
    <div class="bg-gradient-to-r from-slate-800 to-slate-700 rounded-2xl p-8 text-white shadow-md flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p class="text-slate-300 text-sm max-w-2xl leading-relaxed">Kelola bimbingan mahasiswa, validasi laporan mingguan, dan pantau progres Praktik Kerja Lapangan mahasiswa bimbingan Anda dengan mudah.</p>
        </div>
        <div class="shrink-0 relative z-10 hidden md:block">
            <a href="{{ route('lecturer.internships.index') }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white px-5 py-2.5 rounded-lg font-medium transition-colors border border-white/20 backdrop-blur-sm">
                Lihat Daftar Mahasiswa
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>
        </div>
        <svg class="absolute right-0 bottom-0 text-white/5 w-64 h-64 -mb-20 -mr-16 transform rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group hover:border-blue-300 transition-colors">
            <div class="h-12 w-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
            <h3 class="text-3xl font-bold text-slate-800 mb-1">{{ $stats['active_students'] }}</h3>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Mahasiswa Aktif</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group hover:border-amber-300 transition-colors">
            <div class="h-12 w-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            </div>
            <h3 class="text-3xl font-bold text-slate-800 mb-1">{{ $stats['pending_reports'] }}</h3>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Laporan Menunggu</p>
            @if($stats['pending_reports'] > 0)
                <div class="absolute top-6 right-6 h-3 w-3 bg-red-500 rounded-full animate-pulse"></div>
            @endif
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group hover:border-violet-300 transition-colors">
            <div class="h-12 w-12 bg-violet-50 text-violet-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            </div>
            <h3 class="text-3xl font-bold text-slate-800 mb-1">{{ $stats['today_sessions'] }}</h3>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Bimbingan Hari Ini</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group hover:border-red-300 transition-colors">
            <div class="h-12 w-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
            </div>
            <h3 class="text-3xl font-bold text-slate-800 mb-1">{{ $stats['ungraded_students'] }}</h3>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Belum Dinilai</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Laporan Terbaru --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                <h3 class="font-bold text-slate-800">Laporan Memerlukan Validasi</h3>
                <a href="{{ route('lecturer.weekly_reports.index') }}" class="text-xs font-medium text-primary hover:underline">Lihat Semua</a>
            </div>
            
            @if($recentReports->count() > 0)
                <ul class="space-y-3">
                    @foreach($recentReports as $report)
                        <li class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-100 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shrink-0 border border-primary/20">
                                    {{ substr($report->internship->student->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">{{ $report->internship->student->user->name }}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Minggu {{ $report->week_number }} &bull; {{ $report->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('lecturer.weekly_reports.show', $report) }}" class="text-xs font-medium bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 rounded-lg transition-colors">
                                Review
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    <p class="text-sm font-medium text-slate-500">Semua laporan sudah divalidasi!</p>
                </div>
            @endif
        </div>

        {{-- Agenda Bimbingan --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                <h3 class="font-bold text-slate-800">Jadwal Bimbingan Terdekat</h3>
                <a href="{{ route('lecturer.mentorship_sessions.index') }}" class="text-xs font-medium text-primary hover:underline">Kalender</a>
            </div>
            
            @if($upcomingSessions->count() > 0)
                <ul class="space-y-3">
                    @foreach($upcomingSessions as $session)
                        <li class="flex items-start gap-4 p-3 rounded-xl border border-slate-100 bg-slate-50 hover:bg-slate-100 transition-colors">
                            <div class="shrink-0 bg-white border border-slate-200 rounded-lg p-2 text-center min-w-[50px] shadow-sm">
                                <span class="block text-[10px] font-bold text-red-500 uppercase">{{ \Carbon\Carbon::parse($session->date)->translatedFormat('M') }}</span>
                                <span class="block text-lg font-bold text-slate-800 leading-none mt-1">{{ \Carbon\Carbon::parse($session->date)->format('d') }}</span>
                            </div>
                            <div class="flex-1 pt-1">
                                <p class="text-sm font-bold text-slate-800 line-clamp-1">{{ $session->topic }}</p>
                                <p class="text-xs text-slate-500 mt-1">Dengan: {{ $session->internship->student->user->name }}</p>
                            </div>
                            <div class="shrink-0 pt-1">
                                <span class="inline-flex items-center gap-1 text-xs font-medium text-slate-500 bg-white px-2 py-1 border border-slate-200 rounded-md shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ \Carbon\Carbon::parse($session->date)->format('H:i') }}
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="flex flex-col items-center justify-center py-8 text-center border-2 border-dashed border-slate-100 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <p class="text-sm font-medium text-slate-500">Tidak ada jadwal bimbingan terdekat.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
