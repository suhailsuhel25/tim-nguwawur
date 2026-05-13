{{-- resources/views/student/final_grades/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Nilai Akhir Magang - Simagang')
@section('header_title', 'Nilai Akhir Magang')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div>
        <h2 class="text-xl font-bold text-slate-800">Nilai Akhir Magang</h2>
        <p class="text-sm text-slate-500 mt-1">Lihat hasil penilaian akhir magang dari dosen pembimbing.</p>
    </div>

    @forelse($grades as $grade)
        @php
            $fg = $grade->final_grade;
            $color = $fg >= 75 ? 'emerald' : ($fg >= 55 ? 'amber' : 'red');
            $letter = match(true) {
                $fg >= 85 => 'A', $fg >= 80 => 'A-', $fg >= 75 => 'B+',
                $fg >= 70 => 'B', $fg >= 65 => 'B-', $fg >= 60 => 'C+',
                $fg >= 55 => 'C', $fg >= 50 => 'D', default => 'E',
            };
        @endphp
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
            <div class="flex flex-col sm:flex-row">
                {{-- Grade Badge --}}
                <div class="sm:w-36 shrink-0 bg-{{ $color }}-50 p-6 flex flex-col items-center justify-center border-b sm:border-b-0 sm:border-r border-{{ $color }}-100">
                    <span class="text-4xl font-bold text-{{ $color }}-700 tabular-nums">{{ number_format($fg, 1) }}</span>
                    <span class="text-2xl font-bold text-{{ $color }}-600 mt-1">{{ $letter }}</span>
                </div>

                {{-- Details --}}
                <div class="flex-1 p-5 sm:p-6">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div>
                            <h3 class="font-bold text-slate-800">{{ $grade->internship->company->name }}</h3>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Periode: {{ $grade->internship->internshipPeriod->name ?? '-' }} •
                                Dinilai oleh: {{ $grade->lecturer->user->name }}
                            </p>
                            <p class="text-xs text-slate-400 mt-0.5">
                                {{ \Carbon\Carbon::parse($grade->grading_date)->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    </div>

                    {{-- Grade Breakdown --}}
                    <div class="grid grid-cols-3 gap-3 mb-4">
                        <div class="bg-blue-50 rounded-lg p-3 text-center border border-blue-100">
                            <span class="block text-[10px] font-medium text-blue-600 uppercase">Laporan</span>
                            <span class="text-lg font-bold text-blue-800 tabular-nums">{{ number_format($grade->report_grade, 0) }}</span>
                        </div>
                        <div class="bg-violet-50 rounded-lg p-3 text-center border border-violet-100">
                            <span class="block text-[10px] font-medium text-violet-600 uppercase">Presentasi</span>
                            <span class="text-lg font-bold text-violet-800 tabular-nums">{{ number_format($grade->presentation_grade, 0) }}</span>
                        </div>
                        <div class="bg-amber-50 rounded-lg p-3 text-center border border-amber-100">
                            <span class="block text-[10px] font-medium text-amber-600 uppercase">Sikap</span>
                            <span class="text-lg font-bold text-amber-800 tabular-nums">{{ number_format($grade->attitude_grade, 0) }}</span>
                        </div>
                    </div>

                    <a href="{{ route('student.final_grades.show', $grade) }}"
                       class="inline-flex items-center text-xs font-medium text-primary hover:text-primary/80">
                        Lihat Detail
                        <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-12 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <p class="text-slate-500 font-medium">Belum ada nilai akhir.</p>
            <p class="text-xs text-slate-400 mt-1">Dosen pembimbing akan menerbitkan nilai akhir setelah masa magang selesai.</p>
        </div>
    @endforelse
</div>
@endsection
