{{-- resources/views/lecturer/students/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Mahasiswa Bimbingan - Simagang')
@section('header_title', 'Mahasiswa Bimbingan')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Mahasiswa Bimbingan Anda</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola dan pantau progres mahasiswa yang sedang melaksanakan magang di bawah bimbingan Anda.</p>
        </div>
    </div>

    {{-- Filter & Search --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
        <form method="GET" action="{{ route('lecturer.students.index') }}" class="flex flex-col sm:flex-row gap-3">
            <select name="status" id="filter-status"
                    class="px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                <option value="">Semua Status</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Aktif (Magang)</option>
                <option value="finished" {{ request('status') === 'finished' ? 'selected' : '' }}>Selesai</option>
            </select>
            <button type="submit"
                    class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm font-medium hover:bg-slate-700 transition-colors">
                Filter
            </button>
            @if(request('status'))
                <a href="{{ route('lecturer.students.index') }}"
                   class="px-4 py-2 border border-slate-200 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">#</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Mahasiswa</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Perusahaan</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Periode</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Status</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students as $internship)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-4 text-slate-400 tabular-nums">
                                {{ $students->firstItem() + $loop->index }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-medium text-slate-800">{{ $internship->student->user->name }}</div>
                                <div class="text-xs text-slate-500">{{ $internship->student->user->username }} - {{ $internship->student->study_program }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-medium text-slate-800">{{ $internship->company->name }}</div>
                                <div class="text-xs text-slate-500">{{ $internship->company->industry }}</div>
                            </td>
                            <td class="px-5 py-4 text-slate-600 text-xs">
                                <div class="font-medium">{{ $internship->internshipPeriod->name }}</div>
                                <div>{{ \Carbon\Carbon::parse($internship->start_date)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($internship->end_date)->translatedFormat('d M Y') }}</div>
                            </td>
                            <td class="px-5 py-4">
                                @if($internship->status === 'approved')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"> Aktif </span>
                                @elseif($internship->status === 'finished')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800"> Selesai ({{ number_format($internship->finalGrade?->final_grade ?? 0, 1) }}) </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600"> {{ ucfirst($internship->status) }} </span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('lecturer.internships.show', $internship) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 border border-slate-200 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-50 hover:border-slate-300 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p>Anda belum memiliki mahasiswa bimbingan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($students->hasPages())
            <div class="px-5 py-4 border-t border-slate-200">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
