{{-- resources/views/lecturer/final_grades/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Penilaian Akhir - Simagang')
@section('header_title', 'Penilaian Akhir')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Penilaian Akhir Magang</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola nilai akhir mahasiswa bimbingan Anda.</p>
        </div>
        <a href="{{ route('lecturer.final_grades.create') }}"
           class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Input Nilai Baru
        </a>
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

    {{-- Stats --}}
    @if($ungradedCount > 0)
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-center gap-3">
        <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-amber-800">{{ $ungradedCount }} mahasiswa belum dinilai</p>
            <p class="text-xs text-amber-700">Terdapat mahasiswa bimbingan yang belum mendapatkan penilaian akhir.</p>
        </div>
    </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">#</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Mahasiswa</th>
                        <th class="text-center px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Laporan</th>
                        <th class="text-center px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Presentasi</th>
                        <th class="text-center px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Sikap</th>
                        <th class="text-center px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Nilai Akhir</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($grades as $grade)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-4 text-slate-400 tabular-nums">{{ $grades->firstItem() + $loop->index }}</td>
                            <td class="px-5 py-4">
                                <div class="font-medium text-slate-800">{{ $grade->internship->student->user->name }}</div>
                                <div class="text-xs text-slate-500">{{ $grade->internship->company->name }}</div>
                            </td>
                            <td class="px-5 py-4 text-center tabular-nums font-medium text-slate-700">{{ number_format($grade->report_grade, 0) }}</td>
                            <td class="px-5 py-4 text-center tabular-nums font-medium text-slate-700">{{ number_format($grade->presentation_grade, 0) }}</td>
                            <td class="px-5 py-4 text-center tabular-nums font-medium text-slate-700">{{ number_format($grade->attitude_grade, 0) }}</td>
                            <td class="px-5 py-4 text-center">
                                @php
                                    $fg = $grade->final_grade;
                                    $color = $fg >= 75 ? 'emerald' : ($fg >= 55 ? 'amber' : 'red');
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-{{ $color }}-100 text-{{ $color }}-800">
                                    {{ number_format($fg, 1) }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <a href="{{ route('lecturer.final_grades.show', $grade) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 border border-slate-200 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-50 hover:border-slate-300 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                    <p class="text-slate-500 font-medium">Belum ada penilaian akhir.</p>
                                    <a href="{{ route('lecturer.final_grades.create') }}" class="text-primary text-sm hover:underline">+ Input nilai baru</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($grades->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $grades->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection
