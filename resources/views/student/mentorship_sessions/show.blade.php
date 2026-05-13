{{-- resources/views/student/mentorship_sessions/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Sesi Bimbingan - Simagang')
@section('header_title', 'Detail Sesi Bimbingan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('student.mentorship_sessions.index') }}"
           class="h-8 w-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Detail Sesi Bimbingan</h2>
            <p class="text-sm text-slate-500">{{ \Carbon\Carbon::parse($mentorshipSession->date)->translatedFormat('l, d F Y — H:i') }} WIB</p>
        </div>
    </div>

    {{-- Status Card --}}
    <div class="rounded-xl border shadow-sm overflow-hidden
                {{ $mentorshipSession->status === 'scheduled' ? 'bg-blue-50 border-blue-200' : ($mentorshipSession->status === 'completed' ? 'bg-emerald-50 border-emerald-200' : 'bg-red-50 border-red-200') }}">
        <div class="p-5 flex items-center gap-4">
            @if($mentorshipSession->status === 'scheduled')
                <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-blue-800">Sesi Terjadwal</h3>
                    <p class="text-sm text-blue-700">Sesi bimbingan dijadwalkan pada {{ \Carbon\Carbon::parse($mentorshipSession->date)->translatedFormat('d F Y, H:i') }} WIB.</p>
                </div>
            @elseif($mentorshipSession->status === 'completed')
                <div class="h-12 w-12 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-emerald-800">Sesi Selesai</h3>
                    <p class="text-sm text-emerald-700">Sesi bimbingan telah selesai dilaksanakan.</p>
                </div>
            @else
                <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-red-800">Sesi Dibatalkan</h3>
                    <p class="text-sm text-red-700">Sesi bimbingan ini telah dibatalkan oleh dosen pembimbing.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Session Info --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Informasi Sesi</h3>
        <div class="space-y-4 text-sm">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                <div class="font-medium text-slate-500">Dosen Pembimbing</div>
                <div class="sm:col-span-2 font-medium text-slate-800">{{ $mentorshipSession->internship->lecturer->user->name ?? '-' }}</div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                <div class="font-medium text-slate-500">Perusahaan</div>
                <div class="sm:col-span-2 text-slate-800">{{ $mentorshipSession->internship->company->name }}</div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                <div class="font-medium text-slate-500">Jadwal</div>
                <div class="sm:col-span-2 font-medium text-slate-800">
                    {{ \Carbon\Carbon::parse($mentorshipSession->date)->translatedFormat('l, d F Y — H:i') }} WIB
                </div>
            </div>
        </div>
    </div>

    {{-- Topic --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Topik Bimbingan</h3>
        <div class="bg-slate-50 p-4 rounded-lg border border-slate-100 whitespace-pre-wrap text-sm text-slate-700">{{ $mentorshipSession->topic }}</div>
    </div>

    {{-- Feedback from Lecturer --}}
    @if($mentorshipSession->feedback && $mentorshipSession->status === 'completed')
    <div class="bg-white rounded-xl border border-emerald-200 shadow-sm p-6">
        <h3 class="font-semibold text-emerald-800 border-b border-emerald-100 pb-3 mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
            </svg>
            Feedback Dosen
        </h3>
        <div class="bg-emerald-50 p-4 rounded-lg border border-emerald-100 whitespace-pre-wrap text-sm text-slate-700">{{ $mentorshipSession->feedback }}</div>
    </div>
    @endif

</div>
@endsection
