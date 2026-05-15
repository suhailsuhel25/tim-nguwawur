{{-- resources/views/student/weekly_reports/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Laporan Mingguan - Simagang')
@section('header_title', 'Laporan Mingguan')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Riwayat Laporan Mingguan</h2>
        <p class="text-slate-600 mt-1">Kelola dan buat laporan mingguan untuk kegiatan magang Anda.</p>
    </div>
    @if($internships->count() > 0)
    <a href="{{ route('student.weekly_reports.create', ['internship_id' => $internships->first()->id]) }}" class="shrink-0 inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-bold rounded-xl transition-colors shadow-sm shadow-blue-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Buat Laporan
    </a>
    @endif
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



<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-100">
        <h3 class="font-bold text-slate-800">Riwayat Laporan</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50/50 text-slate-500 text-[10px] uppercase font-bold tracking-wider">
                <tr>
                    <th class="px-6 py-4">Minggu Ke</th>
                    <th class="px-6 py-4">Perusahaan</th>
                    <th class="px-6 py-4">Tanggal Submit</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($reports as $report)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4 font-bold text-slate-800">
                            Minggu {{ $report->week_number }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $report->internship->company->name }}
                        </td>
                        <td class="px-6 py-4 text-xs font-medium">
                            {{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($report->status === 'draft')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                    Draft
                                </span>
                            @elseif($report->status === 'submitted')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                    Review
                                </span>
                            @elseif($report->status === 'validated')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    Approved
                                </span>
                            @endif
                            @if($report->is_late)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-600 border border-red-200 ml-1">
                                    Terlambat
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('student.weekly_reports.show', $report) }}" class="text-slate-400 hover:text-blue-600 transition-colors" title="Lihat Laporan">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </a>
                                @if($report->status === 'draft' || $report->status === 'submitted')
                                <a href="#" class="text-slate-400 hover:text-amber-500 transition-colors" title="Edit Laporan">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                <p>Belum ada riwayat laporan mingguan yang dibuat.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($reports->hasPages())
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $reports->links() }}
        </div>
    @endif
</div>
@endsection
