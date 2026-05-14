{{-- resources/views/lecturer/internships/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Pengajuan Magang - Simagang')
@section('header_title', 'Daftar Pengajuan Magang')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Pengajuan Magang Prodi</h2>
            <p class="text-sm text-slate-500 mt-1">Review dan kelola pengajuan magang baru dari mahasiswa program studi Anda.</p>
        </div>
    </div>

    {{-- Info Card --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-blue-800 text-sm flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p>Halaman ini menampilkan pengajuan magang yang belum diproses (Status: <strong>Menunggu</strong>) untuk program studi Anda.</p>
    </div>

    {{-- Pending Applications Table --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                Menunggu Persetujuan
                <span class="ml-2 text-xs font-medium bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">{{ count($pendingInternships) }}</span>
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">#</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Mahasiswa</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Perusahaan</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Periode</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pendingInternships as $internship)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-4 text-slate-400 tabular-nums">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-medium text-slate-800">{{ $internship->student->user->name }}</div>
                                <div class="text-xs text-slate-500">{{ $internship->student->user->username }}</div>
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
                                <a href="{{ route('lecturer.internships.show', $internship) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary text-white rounded-lg text-xs font-medium hover:bg-primary/90 transition-colors shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Review
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-slate-500">
                                <p>Tidak ada pengajuan magang baru yang menunggu persetujuan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- History Table --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                Riwayat Pengajuan Prodi
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">#</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Mahasiswa</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Perusahaan</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Status</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Dosen Reviewer</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($historyInternships as $internship)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-4 text-slate-400 tabular-nums">
                                {{ $historyInternships->firstItem() + $loop->index }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-medium text-slate-800">{{ $internship->student->user->name }}</div>
                                <div class="text-xs text-slate-500">{{ $internship->student->user->username }}</div>
                            </td>
                            <td class="px-5 py-4 text-slate-600">
                                {{ $internship->company->name }}
                            </td>
                            <td class="px-5 py-4">
                                @if($internship->status === 'approved' || $internship->status === 'finished')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-800 uppercase tracking-wider"> Disetujui </span>
                                @elseif($internship->status === 'rejected')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-800 uppercase tracking-wider"> Ditolak </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 uppercase tracking-wider"> {{ $internship->status }} </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-xs">
                                @if($internship->lecturer)
                                    <div class="font-medium text-slate-700">{{ $internship->lecturer->user->name }}</div>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <a href="{{ route('lecturer.internships.show', $internship) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 border border-slate-200 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-50 transition-colors">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-500">
                                <p>Belum ada riwayat pengajuan magang di program studi ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($historyInternships->hasPages())
            <div class="px-5 py-4 border-t border-slate-200">
                {{ $historyInternships->appends(['history_page' => request('history_page')])->links() }}
            </div>
        @endif
    </div>

</div>
@endsection