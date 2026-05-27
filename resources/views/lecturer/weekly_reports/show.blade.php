{{-- resources/views/dosen/weekly_reports/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Review Laporan Mingguan - Simagang')
@section('header_title', 'Review Laporan Mingguan')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Review Laporan Minggu Ke-{{ $weeklyReport->week_number }}</h2>
        <p class="text-slate-600 mt-1">Mahasiswa: <span class="font-semibold">{{ $weeklyReport->internship->student->user->name }}</span> ({{ $weeklyReport->internship->student->user->username }})</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('lecturer.weekly_reports.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-4 py-2 rounded-lg transition-colors">
            Kembali
        </a>
    </div>
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

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 space-y-6">
        <!-- Aksi Validasi -->
        <div class="bg-white rounded-xl border border-primary/20 shadow-sm overflow-hidden shadow-primary/5">
            <div class="p-5 border-b border-slate-100 bg-primary/5 flex justify-between items-center">
                <h3 class="font-bold text-slate-800">Aksi Validasi</h3>
                @if($weeklyReport->status === 'submitted')
                    <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2.5 py-1 rounded-full border border-amber-200">Menunggu</span>
                @elseif($weeklyReport->status === 'validated')
                    <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2.5 py-1 rounded-full border border-emerald-200">Tervalidasi</span>
                @endif
                @if($weeklyReport->is_late)
                    <span class="bg-red-100 text-red-700 text-xs font-bold px-2.5 py-1 rounded-full border border-red-200 ml-2">Terlambat</span>
                @endif
            </div>
            
            <div class="p-5">
                <form action="{{ route('lecturer.weekly_reports.update_status', $weeklyReport) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Ubah Status Laporan:</label>
                        <select name="status" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 text-sm">
                            <option value="submitted" {{ $weeklyReport->status === 'submitted' ? 'selected' : '' }}>Menunggu Validasi</option>
                            <option value="validated" {{ $weeklyReport->status === 'validated' ? 'selected' : '' }}>Validasi Laporan (Disetujui)</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="w-full justify-center inline-flex items-center px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        <!-- Info Magang -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Informasi Magang</h3>
            
            <div class="space-y-4">
                <div>
                    <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Perusahaan</span>
                    <p class="text-sm font-medium text-slate-900">{{ $weeklyReport->internship->company->name }}</p>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Periode Laporan</span>
                    <p class="text-sm text-slate-700">{{ \Carbon\Carbon::parse($weeklyReport->start_date)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($weeklyReport->end_date)->translatedFormat('d M Y') }}</p>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Dibuat Pada</span>
                    <p class="text-sm text-slate-700">{{ $weeklyReport->created_at->translatedFormat('d F Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-6">
        <!-- Rangkuman Mingguan -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Rangkuman Mingguan</h3>
            
            <div class="space-y-5 text-sm text-slate-700">
                <div>
                    <span class="block font-semibold text-slate-800 mb-1">Deskripsi Umum Kegiatan</span>
                    <div class="bg-slate-50 p-4 rounded-lg border border-slate-100 whitespace-pre-wrap">{{ $weeklyReport->activity_description }}</div>
                </div>

                @if($weeklyReport->challenges)
                <div>
                    <span class="block font-semibold text-slate-800 mb-1">Tantangan/Kendala</span>
                    <div class="bg-red-50 p-4 rounded-lg border border-red-100 whitespace-pre-wrap">{{ $weeklyReport->challenges }}</div>
                </div>
                @endif

                @if($weeklyReport->next_week_plan)
                <div>
                    <span class="block font-semibold text-slate-800 mb-1">Rencana Minggu Depan</span>
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 whitespace-pre-wrap">{{ $weeklyReport->next_week_plan }}</div>
                </div>
                @endif
                
                @if($weeklyReport->document_path)
                <div class="pt-4 border-t border-slate-100 mt-4">
                    <span class="block font-semibold text-slate-800 mb-2">Dokumentasi Lampiran</span>
                    <a href="{{ route('lecturer.weekly_reports.download', $weeklyReport) }}" target="_blank" class="inline-flex items-center gap-3 p-3 rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 hover:border-slate-300 transition-all w-full sm:w-auto">
                        <div class="h-10 w-10 bg-white rounded shadow-sm flex items-center justify-center text-blue-600 border border-blue-100 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Lihat File Lampiran</p>
                            <p class="text-xs text-slate-500">Klik untuk melihat dokumen</p>
                        </div>
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Aktivitas Harian -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800">Detail Aktivitas Harian</h3>
                <span class="text-sm text-slate-500 font-medium">Total Waktu: <strong class="text-primary bg-primary/10 px-2 py-1 rounded-md">{{ $weeklyReport->dailyActivities->sum('duration_hours') }} Jam</strong></span>
            </div>
            
            <div class="divide-y divide-slate-100">
                @forelse($weeklyReport->dailyActivities->sortBy('date') as $activity)
                    <div class="p-5 hover:bg-slate-50 transition-colors">
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                            <div class="flex-shrink-0 w-32 border-l-4 border-primary pl-3">
                                <div class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($activity->date)->translatedFormat('l') }}</div>
                                <div class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($activity->date)->translatedFormat('d M Y') }}</div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-slate-700 whitespace-pre-wrap">{{ $activity->activity_description }}</p>
                            </div>
                            <div class="flex-shrink-0 text-right">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 border border-slate-200 text-xs font-semibold">
                                    <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
