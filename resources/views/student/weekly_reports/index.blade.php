{{-- resources/views/mahasiswa/weekly_reports/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Laporan Mingguan - Simagang')
@section('header_title', 'Laporan Mingguan')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-slate-800">Riwayat Laporan Mingguan</h2>
    <p class="text-slate-600 mt-1">Kelola dan buat laporan mingguan untuk kegiatan magang Anda.</p>
</div>

@if(session('success'))
<div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-lg mb-6 shadow-sm">
    <div class="flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r-lg mb-6 shadow-sm">
    <div class="flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="font-medium">{{ session('error') }}</span>
    </div>
</div>
@endif

<div class="mb-6">
    <h3 class="text-lg font-semibold text-slate-800 mb-3">Buat Laporan Baru</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($internships as $internship)
            <div class="bg-white border border-slate-200 p-5 rounded-xl shadow-sm flex flex-col justify-between hover:border-primary/30 transition-colors">
                <div>
                    <div class="flex items-start justify-between mb-2">
                        <h4 class="font-bold text-slate-800 text-lg">{{ $internship->company->name }}</h4>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Aktif</span>
                    </div>
                    <p class="text-sm text-slate-500 mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Periode: {{ $internship->internshipPeriod->name }}
                    </p>
                </div>
                <a href="{{ route('student.weekly_reports.create', ['internship_id' => $internship->id]) }}" class="inline-flex justify-center items-center px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-lg transition-colors w-full">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Buat Laporan Minggu Ini
                </a>
            </div>
        @empty
            <div class="bg-slate-50 border border-dashed border-slate-300 p-6 rounded-xl text-center md:col-span-2">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <h3 class="mt-2 text-sm font-medium text-slate-900">Tidak ada magang aktif</h3>
                <p class="mt-1 text-sm text-slate-500">Anda hanya bisa membuat laporan mingguan jika memiliki pengajuan magang yang telah disetujui.</p>
            </div>
        @endforelse
    </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-200">
        <h3 class="font-bold text-slate-800">Daftar Laporan</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-700 text-xs uppercase font-semibold">
                <tr>
                    <th class="px-6 py-4">Minggu Ke</th>
                    <th class="px-6 py-4">Perusahaan</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($reports as $report)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">
                            Minggu {{ $report->week_number }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $report->internship->company->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($report->start_date)->translatedFormat('d M Y') }} - 
                            {{ \Carbon\Carbon::parse($report->end_date)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($report->status === 'draft')
                                <span class="bg-slate-100 text-slate-800 text-xs font-medium px-2.5 py-0.5 rounded-full border border-slate-200">Draft</span>
                            @elseif($report->status === 'submitted')
                                <span class="bg-amber-50 text-amber-600 text-xs font-medium px-2.5 py-0.5 rounded-full border border-amber-200">Submitted</span>
                            @elseif($report->status === 'validated')
                                <span class="bg-emerald-50 text-emerald-600 text-xs font-medium px-2.5 py-0.5 rounded-full border border-emerald-200">Validated</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('student.weekly_reports.show', $report) }}" class="inline-flex items-center text-sm font-medium text-primary hover:text-primary-dark">
                                Detail
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                <p>Belum ada laporan mingguan yang dibuat.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($reports->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $reports->links() }}
        </div>
    @endif
</div>
@endsection
