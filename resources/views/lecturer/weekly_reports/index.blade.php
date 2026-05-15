{{-- resources/views/dosen/weekly_reports/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Validasi Laporan Mingguan - Simagang')
@section('header_title', 'Validasi Laporan Mingguan')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Laporan Mingguan Mahasiswa</h2>
        <p class="text-slate-600 mt-1">Pantau dan validasi laporan kegiatan mingguan mahasiswa bimbingan Anda.</p>
    </div>
    
    <div class="flex items-center gap-2">
        <span class="text-sm text-slate-500 font-medium">Filter Status:</span>
        <div class="flex bg-slate-100 p-1 rounded-lg border border-slate-200">
            <a href="{{ route('lecturer.weekly_reports.index') }}" class="px-3 py-1.5 text-xs font-medium rounded-md transition-colors {{ !$status ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">Semua</a>
            <a href="{{ route('lecturer.weekly_reports.index', ['status' => 'submitted']) }}" class="px-3 py-1.5 text-xs font-medium rounded-md transition-colors {{ $status === 'submitted' ? 'bg-white text-amber-600 shadow-sm' : 'text-slate-600 hover:text-amber-600' }}">Menunggu</a>
            <a href="{{ route('lecturer.weekly_reports.index', ['status' => 'validated']) }}" class="px-3 py-1.5 text-xs font-medium rounded-md transition-colors {{ $status === 'validated' ? 'bg-white text-emerald-600 shadow-sm' : 'text-slate-600 hover:text-emerald-600' }}">Tervalidasi</a>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-700 text-xs uppercase font-semibold">
                <tr>
                    <th class="px-6 py-4">Mahasiswa</th>
                    <th class="px-6 py-4">Minggu Ke</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($reports as $report)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">{{ $report->internship->student->user->name }}</div>
                            <div class="text-xs text-slate-500">{{ $report->internship->student->user->username }}</div>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-700">
                            Minggu {{ $report->week_number }}
                        </td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($report->start_date)->translatedFormat('d M') }} - 
                            {{ \Carbon\Carbon::parse($report->end_date)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($report->status === 'draft')
                                <span class="bg-slate-100 text-slate-800 text-xs font-medium px-2.5 py-0.5 rounded-full border border-slate-200">Draft</span>
                            @elseif($report->status === 'submitted')
                                <span class="bg-amber-50 text-amber-600 text-xs font-medium px-2.5 py-0.5 rounded-full border border-amber-200 flex items-center w-fit">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span> Menunggu
                                </span>
                            @elseif($report->status === 'validated')
                                <span class="bg-emerald-50 text-emerald-600 text-xs font-medium px-2.5 py-0.5 rounded-full border border-emerald-200 flex items-center w-fit">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Tervalidasi
                                </span>
                            @endif
                            @if($report->is_late)
                                <span class="bg-red-50 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded-full border border-red-200 mt-1 inline-block">Terlambat</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('lecturer.weekly_reports.show', $report) }}" class="inline-flex items-center text-sm font-medium text-primary hover:text-primary-dark bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                Review
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p>Belum ada laporan mingguan dari mahasiswa.</p>
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
