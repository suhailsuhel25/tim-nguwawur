{{-- resources/views/student/final_grades/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Nilai Akhir Magang - Simagang')
@section('header_title', 'Nilai Akhir Magang')

@section('content')
<div class="space-y-6">

    {{-- Hero Section --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-800 via-slate-700 to-slate-900 p-6 md:p-8 shadow-xl">

        <div class="absolute top-0 right-0 opacity-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-56 w-56" fill="currentColor" viewBox="0 0 24 24">
                <path d="M9 17v-2h6v2H9zm0-4v-2h10v2H9zm0-4V7h10v2H9zM5 21V3h14v18H5z"/>
            </svg>
        </div>

        <div class="relative z-10">

            <p class="text-slate-300 text-sm font-medium mb-2">
                Hasil Evaluasi Magang
            </p>

            <h1 class="text-3xl font-bold text-white leading-tight">
                Nilai Akhir Magang
            </h1>

            <p class="text-slate-300 text-sm mt-3 max-w-2xl">
                Lihat hasil penilaian akhir magang yang diberikan oleh dosen pembimbing berdasarkan performa, laporan, presentasi, dan sikap selama kegiatan magang berlangsung.
            </p>

        </div>
    </div>

    {{-- Grade Cards --}}
    <div class="space-y-5">

        @forelse($grades as $grade)

            @php
                $fg = $grade->final_grade;

                $color = $fg >= 75
                    ? 'emerald'
                    : ($fg >= 55 ? 'amber' : 'red');

                $letter = match(true) {
                    $fg >= 85 => 'A',
                    $fg >= 80 => 'A-',
                    $fg >= 75 => 'B+',
                    $fg >= 70 => 'B',
                    $fg >= 65 => 'B-',
                    $fg >= 60 => 'C+',
                    $fg >= 55 => 'C',
                    $fg >= 50 => 'D',
                    default => 'E',
                };
            @endphp

            <div class="group bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">

                <div class="flex flex-col lg:flex-row">

                    {{-- Score Section --}}
                    <div class="lg:w-64 shrink-0 bg-gradient-to-br
                        {{ $color === 'emerald' ? 'from-emerald-50 to-green-50 border-emerald-100' : '' }}
                        {{ $color === 'amber' ? 'from-amber-50 to-yellow-50 border-amber-100' : '' }}
                        {{ $color === 'red' ? 'from-red-50 to-rose-50 border-red-100' : '' }}
                        border-r p-8 flex flex-col items-center justify-center text-center">

                        <div class="h-20 w-20 rounded-3xl flex items-center justify-center mb-5
                            {{ $color === 'emerald' ? 'bg-emerald-100 text-emerald-600' : '' }}
                            {{ $color === 'amber' ? 'bg-amber-100 text-amber-600' : '' }}
                            {{ $color === 'red' ? 'bg-red-100 text-red-600' : '' }}">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.586-3.586a2 2 0 010 2.828l-8.172 8.172a4 4 0 01-5.656 0l-2.172-2.172a4 4 0 010-5.656l8.172-8.172a2 2 0 012.828 0z"/>
                            </svg>
                        </div>

                        <h2 class="text-5xl font-extrabold tabular-nums
                            {{ $color === 'emerald' ? 'text-emerald-700' : '' }}
                            {{ $color === 'amber' ? 'text-amber-700' : '' }}
                            {{ $color === 'red' ? 'text-red-700' : '' }}">
                            {{ number_format($fg, 1) }}
                        </h2>

                        <p class="text-lg font-bold mt-2
                            {{ $color === 'emerald' ? 'text-emerald-600' : '' }}
                            {{ $color === 'amber' ? 'text-amber-600' : '' }}
                            {{ $color === 'red' ? 'text-red-600' : '' }}">
                            Grade {{ $letter }}
                        </p>

                        <div class="mt-4">
                            @if($fg >= 75)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    Sangat Baik
                                </span>
                            @elseif($fg >= 55)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-200">
                                    Cukup
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                    Perlu Evaluasi
                                </span>
                            @endif
                        </div>

                    </div>

                    {{-- Detail Section --}}
                    <div class="flex-1 p-6 md:p-8">

                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">

                            <div class="flex-1">

                                {{-- Company --}}
                                <div class="mb-6">

                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-2">
                                        Tempat Magang
                                    </p>

                                    <h2 class="text-2xl font-bold text-slate-800 group-hover:text-primary transition-colors">
                                        {{ $grade->internship->company->name }}
                                    </h2>

                                    <div class="flex flex-wrap items-center gap-2 text-sm text-slate-500 mt-2">

                                        <span>
                                            {{ $grade->internship->internshipPeriod->name ?? '-' }}
                                        </span>

                                        <span>•</span>

                                        <span>
                                            Dinilai oleh {{ $grade->lecturer->user->name }}
                                        </span>

                                    </div>

                                    <p class="text-xs text-slate-400 mt-2">
                                        Tanggal Penilaian:
                                        {{ \Carbon\Carbon::parse($grade->grading_date)->translatedFormat('d F Y') }}
                                    </p>

                                </div>

                                {{-- Breakdown --}}
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                                    {{-- Report --}}
                                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 text-center">

                                        <div class="h-12 w-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mx-auto mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>

                                        <p class="text-xs text-slate-500 uppercase font-semibold">
                                            Nilai Laporan
                                        </p>

                                        <h3 class="text-2xl font-bold text-slate-800 mt-1">
                                            {{ number_format($grade->report_grade, 0) }}
                                        </h3>

                                    </div>

                                    {{-- Presentation --}}
                                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 text-center">

                                        <div class="h-12 w-12 rounded-2xl bg-violet-100 text-violet-600 flex items-center justify-center mx-auto mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14m-6 2h6a2 2 0 002-2V8a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                            </svg>
                                        </div>

                                        <p class="text-xs text-slate-500 uppercase font-semibold">
                                            Presentasi
                                        </p>

                                        <h3 class="text-2xl font-bold text-slate-800 mt-1">
                                            {{ number_format($grade->presentation_grade, 0) }}
                                        </h3>

                                    </div>

                                    {{-- Attitude --}}
                                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 text-center">

                                        <div class="h-12 w-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center mx-auto mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>

                                        <p class="text-xs text-slate-500 uppercase font-semibold">
                                            Sikap
                                        </p>

                                        <h3 class="text-2xl font-bold text-slate-800 mt-1">
                                            {{ number_format($grade->attitude_grade, 0) }}
                                        </h3>

                                    </div>

                                </div>

                            </div>

                            {{-- Action --}}
                            <div class="flex lg:flex-col justify-end">

                                <a href="{{ route('student.final_grades.show', $grade) }}"
                                   class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-slate-800 text-white text-sm font-semibold hover:bg-slate-700 shadow-lg shadow-slate-300 transition-all">

                                    Lihat Detail

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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>

                <h3 class="text-xl font-bold text-slate-800 mb-2">
                    Belum Ada Nilai Akhir
                </h3>

                <p class="text-sm text-slate-500 max-w-md mx-auto leading-relaxed">
                    Nilai akhir magang akan ditampilkan setelah dosen pembimbing menyelesaikan proses penilaian.
                </p>

            </div>

        @endforelse

    </div>

</div>
@endsection