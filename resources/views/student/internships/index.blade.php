{{-- resources/views/student/internships/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Riwayat Pengajuan Magang - Simagang')
@section('header_title', 'Riwayat Pengajuan Magang')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Riwayat Pengajuan Magang</h2>
            <p class="text-sm text-slate-500 mt-1">Daftar semua pengajuan magang yang telah Anda lakukan.</p>
        </div>
        <a href="{{ route('student.internships.create') }}"
           class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Ajukan Magang
        </a>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Perusahaan</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Periode & Waktu</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Dosen Pembimbing</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($internships as $internship)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-4">
                                <div class="font-medium text-slate-800">{{ $internship->company->name }}</div>
                                <div class="text-xs text-slate-500">{{ $internship->company->industry }}</div>
                            </td>
                            <td class="px-5 py-4 text-slate-600 text-xs">
                                <div class="font-medium text-slate-700">{{ $internship->internshipPeriod->name }}</div>
                                <div>{{ \Carbon\Carbon::parse($internship->start_date)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($internship->end_date)->translatedFormat('d M Y') }}</div>
                            </td>
                            <td class="px-5 py-4">
                                @if($internship->lecturer)
                                    <span class="text-slate-800">{{ $internship->lecturer->user->name }}</span>
                                @else
                                    <span class="text-slate-400 italic">Belum ditentukan</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                @if($internship->status === 'submitted')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800"> Menunggu </span>
                                @elseif($internship->status === 'approved')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"> Disetujui </span>
                                @elseif($internship->status === 'rejected')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800"
                                          x-data x-tooltip.raw="{{ $internship->rejection_note }}"> Ditolak </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600"> {{ ucfirst($internship->status) }} </span>
                                @endif
                                
                                @if($internship->status === 'rejected' && $internship->rejection_note)
                                    <p class="text-[10px] text-red-500 mt-1 max-w-[150px] truncate" title="{{ $internship->rejection_note }}">
                                        {{ $internship->rejection_note }}
                                    </p>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p>Belum ada pengajuan magang.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($internships->hasPages())
            <div class="px-5 py-4 border-t border-slate-200">
                {{ $internships->links() }}
            </div>
        @endif
    </div>
</div>
@endsection