{{-- resources/views/lecturer/final_grades/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Nilai Akhir - Simagang')
@section('header_title', 'Detail Nilai Akhir')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('lecturer.final_grades.index') }}"
           class="h-8 w-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Detail Nilai Akhir</h2>
            <p class="text-sm text-slate-500">{{ $finalGrade->internship->student->user->name }} — {{ $finalGrade->internship->company->name }}</p>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-lg shadow-sm">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Column --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Grade Card --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-5">Rincian Nilai</h3>

                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="bg-blue-50 rounded-xl p-4 text-center border border-blue-100">
                        <span class="block text-xs font-medium text-blue-600 uppercase tracking-wider mb-1">Laporan</span>
                        <span class="text-2xl font-bold text-blue-800 tabular-nums">{{ number_format($finalGrade->report_grade, 1) }}</span>
                        <span class="block text-[10px] text-blue-500 mt-1">Bobot 40%</span>
                    </div>
                    <div class="bg-violet-50 rounded-xl p-4 text-center border border-violet-100">
                        <span class="block text-xs font-medium text-violet-600 uppercase tracking-wider mb-1">Presentasi</span>
                        <span class="text-2xl font-bold text-violet-800 tabular-nums">{{ number_format($finalGrade->presentation_grade, 1) }}</span>
                        <span class="block text-[10px] text-violet-500 mt-1">Bobot 30%</span>
                    </div>
                    <div class="bg-amber-50 rounded-xl p-4 text-center border border-amber-100">
                        <span class="block text-xs font-medium text-amber-600 uppercase tracking-wider mb-1">Sikap</span>
                        <span class="text-2xl font-bold text-amber-800 tabular-nums">{{ number_format($finalGrade->attitude_grade, 1) }}</span>
                        <span class="block text-[10px] text-amber-500 mt-1">Bobot 30%</span>
                    </div>
                </div>

                @php
                    $fg = $finalGrade->final_grade;
                    $color = $fg >= 75 ? 'emerald' : ($fg >= 55 ? 'amber' : 'red');
                @endphp
                <div class="bg-{{ $color }}-50 rounded-xl p-6 text-center border border-{{ $color }}-200">
                    <span class="block text-xs font-medium text-{{ $color }}-600 uppercase tracking-wider mb-2">Nilai Akhir</span>
                    <span class="text-4xl font-bold text-{{ $color }}-800 tabular-nums">{{ number_format($fg, 1) }}</span>
                    <span class="block text-2xl font-bold text-{{ $color }}-700 mt-1">{{ $letterGrade }}</span>
                </div>
            </div>

            {{-- Student & Internship Info --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Informasi Mahasiswa</h3>
                <div class="space-y-3 text-sm">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                        <div class="font-medium text-slate-500">Nama</div>
                        <div class="sm:col-span-2 font-medium text-slate-800">{{ $finalGrade->internship->student->user->name }} ({{ $finalGrade->internship->student->user->username }})</div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                        <div class="font-medium text-slate-500">Perusahaan</div>
                        <div class="sm:col-span-2 text-slate-800">{{ $finalGrade->internship->company->name }}</div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                        <div class="font-medium text-slate-500">Tanggal Penilaian</div>
                        <div class="sm:col-span-2 text-slate-800">{{ \Carbon\Carbon::parse($finalGrade->grading_date)->translatedFormat('d F Y, H:i') }}</div>
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            @if($finalGrade->notes)
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Catatan</h3>
                <div class="bg-slate-50 p-4 rounded-lg border border-slate-100 text-sm text-slate-700 whitespace-pre-wrap">{{ $finalGrade->notes }}</div>
            </div>
            @endif
        </div>

        {{-- Right Column --}}
        <div class="space-y-6">
            {{-- Actions --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Aksi</h3>
                <a href="{{ route('lecturer.final_grades.edit', $finalGrade) }}"
                   class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-slate-800 text-white rounded-lg text-sm font-medium hover:bg-slate-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Nilai
                </a>
            </div>

            {{-- Summary Stats --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Ringkasan Magang</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-500">Laporan Mingguan</span>
                        <span class="text-sm font-bold text-slate-800">{{ $finalGrade->internship->weeklyReports->count() }} laporan</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-500">Sesi Bimbingan</span>
                        <span class="text-sm font-bold text-slate-800">{{ $finalGrade->internship->mentorshipSessions->where('status', 'completed')->count() }} sesi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
