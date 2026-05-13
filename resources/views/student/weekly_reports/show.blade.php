{{-- resources/views/mahasiswa/weekly_reports/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Laporan Mingguan - Simagang')
@section('header_title', 'Detail Laporan Mingguan')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Laporan Minggu Ke-{{ $weeklyReport->week_number }}</h2>
        <p class="text-slate-600 mt-1">{{ \Carbon\Carbon::parse($weeklyReport->start_date)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($weeklyReport->end_date)->translatedFormat('d M Y') }}</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('student.weekly_reports.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-4 py-2 rounded-lg transition-colors">
            Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800">Status Laporan</h3>
                @if($weeklyReport->status === 'draft')
                    <span class="bg-slate-100 text-slate-800 text-xs font-medium px-2.5 py-1 rounded-full border border-slate-200">Draft</span>
                @elseif($weeklyReport->status === 'submitted')
                    <span class="bg-amber-50 text-amber-600 text-xs font-medium px-2.5 py-1 rounded-full border border-amber-200">Menunggu Validasi</span>
                @elseif($weeklyReport->status === 'validated')
                    <span class="bg-emerald-50 text-emerald-600 text-xs font-medium px-2.5 py-1 rounded-full border border-emerald-200">Tervalidasi</span>
                @endif
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Perusahaan</span>
                    <p class="text-sm font-medium text-slate-900">{{ $weeklyReport->internship->company->name }}</p>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Dibuat Pada</span>
                    <p class="text-sm text-slate-700">{{ $weeklyReport->created_at->translatedFormat('d F Y, H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Rangkuman</h3>
            
            <div class="space-y-4">
                <div>
                    <span class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi Umum</span>
                    <p class="text-sm text-slate-600 whitespace-pre-wrap">{{ $weeklyReport->activity_description }}</p>
                </div>

                @if($weeklyReport->challenges)
                <div>
                    <span class="block text-sm font-semibold text-slate-700 mb-1">Tantangan/Kendala</span>
                    <p class="text-sm text-slate-600 whitespace-pre-wrap">{{ $weeklyReport->challenges }}</p>
                </div>
                @endif

                @if($weeklyReport->next_week_plan)
                <div>
                    <span class="block text-sm font-semibold text-slate-700 mb-1">Rencana Minggu Depan</span>
                    <p class="text-sm text-slate-600 whitespace-pre-wrap">{{ $weeklyReport->next_week_plan }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800">Aktivitas Harian</h3>
                <span class="text-sm text-slate-500">Total: <strong class="text-slate-800">{{ $weeklyReport->dailyActivities->sum('duration_hours') }} Jam</strong></span>
            </div>
            
            <div class="divide-y divide-slate-100">
                @forelse($weeklyReport->dailyActivities->sortBy('date') as $activity)
                    <div class="p-5 hover:bg-slate-50 transition-colors">
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                            <div class="flex-shrink-0 w-32">
                                <div class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($activity->date)->translatedFormat('l') }}</div>
                                <div class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($activity->date)->translatedFormat('d M Y') }}</div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-slate-700 whitespace-pre-wrap">{{ $activity->activity_description }}</p>
                            </div>
                            <div class="flex-shrink-0 text-right">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-xs font-semibold">
                                    {{ $activity->duration_hours }} Jam
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-500">
                        Tidak ada catatan aktivitas harian.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
