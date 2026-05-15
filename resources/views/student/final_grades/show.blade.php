{{-- resources/views/student/final_grades/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Nilai Akhir - Simagang')
@section('header_title', 'Detail Nilai Akhir')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('student.final_grades.index') }}"
           class="h-8 w-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Detail Nilai Akhir</h2>
            <p class="text-sm text-slate-500">{{ $finalGrade->internship->company->name }}</p>
        </div>
    </div>

    {{-- Grade Hero Card --}}
    @php
        $fg = $finalGrade->final_grade;
        $color = $fg >= 75 ? 'emerald' : ($fg >= 55 ? 'amber' : 'red');
    @endphp
    <div class="bg-gradient-to-br from-{{ $color }}-50 to-{{ $color }}-100/50 rounded-xl border border-{{ $color }}-200 shadow-sm p-8 text-center">
        <span class="block text-xs font-medium text-{{ $color }}-600 uppercase tracking-wider mb-3">Nilai Akhir Magang</span>
        <span class="text-5xl font-bold text-{{ $color }}-800 tabular-nums">{{ number_format($fg, 1) }}</span>
        <span class="block text-3xl font-bold text-{{ $color }}-700 mt-2">{{ $letterGrade }}</span>
        <p class="text-sm text-{{ $color }}-600 mt-3">Diterbitkan pada {{ \Carbon\Carbon::parse($finalGrade->grading_date)->translatedFormat('d F Y') }}</p>
    </div>

    {{-- Grade Breakdown --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-5">Rincian Komponen Nilai</h3>
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-blue-50 rounded-xl p-5 text-center border border-blue-100">
                <span class="block text-xs font-medium text-blue-600 uppercase tracking-wider mb-2">Laporan</span>
                <span class="text-3xl font-bold text-blue-800 tabular-nums">{{ number_format($finalGrade->report_grade, 1) }}</span>
                <span class="block text-[10px] text-blue-500 mt-1">Bobot 40%</span>
            </div>
            <div class="bg-violet-50 rounded-xl p-5 text-center border border-violet-100">
                <span class="block text-xs font-medium text-violet-600 uppercase tracking-wider mb-2">Presentasi</span>
                <span class="text-3xl font-bold text-violet-800 tabular-nums">{{ number_format($finalGrade->presentation_grade, 1) }}</span>
                <span class="block text-[10px] text-violet-500 mt-1">Bobot 30%</span>
            </div>
            <div class="bg-amber-50 rounded-xl p-5 text-center border border-amber-100">
                <span class="block text-xs font-medium text-amber-600 uppercase tracking-wider mb-2">Sikap</span>
                <span class="text-3xl font-bold text-amber-800 tabular-nums">{{ number_format($finalGrade->attitude_grade, 1) }}</span>
                <span class="block text-[10px] text-amber-500 mt-1">Bobot 30%</span>
            </div>
        </div>
    </div>

    {{-- Internship Info --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Informasi Magang</h3>
        <div class="space-y-3 text-sm">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                <div class="font-medium text-slate-500">Perusahaan</div>
                <div class="sm:col-span-2 font-medium text-slate-800">{{ $finalGrade->internship->company->name }}</div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                <div class="font-medium text-slate-500">Periode</div>
                <div class="sm:col-span-2 text-slate-800">{{ $finalGrade->internship->internshipPeriod->name ?? '-' }}</div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                <div class="font-medium text-slate-500">Dosen Pembimbing</div>
                <div class="sm:col-span-2 text-slate-800">{{ $finalGrade->lecturer->user->name }}</div>
            </div>
        </div>
    </div>

    {{-- Notes --}}
    @if($finalGrade->notes)
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
            </svg>
            Catatan dari Dosen
        </h3>
        <div class="bg-slate-50 p-4 rounded-lg border border-slate-100 text-sm text-slate-700 whitespace-pre-wrap">{{ $finalGrade->notes }}</div>
    </div>
    @endif
</div>
@endsection
