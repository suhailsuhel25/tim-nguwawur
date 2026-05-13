{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Admin - Simagang')
@section('header_title', 'Dashboard Administrator')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    {{-- Welcome Banner --}}
    <div class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-2xl p-8 text-white shadow-md flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-2xl font-bold mb-2">Sistem Monitoring Magang (Simagang)</h2>
            <p class="text-slate-300 text-sm max-w-2xl leading-relaxed">Selamat datang di Panel Admin. Di sini Anda dapat memantau seluruh aktivitas sistem, mengelola master data pengguna, perusahaan mitra, serta periode magang aktif.</p>
        </div>
        <div class="shrink-0 relative z-10 hidden md:flex items-center gap-3">
            <div class="text-right">
                <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Status Sistem</p>
                <div class="flex items-center gap-2 mt-1">
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                    <span class="text-sm font-bold text-white">Online & Normal</span>
                </div>
            </div>
        </div>
        <svg class="absolute right-0 bottom-0 text-white/5 w-64 h-64 -mb-16 -mr-16 transform rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
    </div>

    {{-- Global Metrics Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        {{-- Users Metric --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center hover:border-primary/50 transition-colors">
            <span class="block text-2xl font-bold text-slate-800">{{ $stats['total_students'] }}</span>
            <span class="block text-xs font-medium text-slate-500 mt-1 uppercase tracking-wider">Total Mahasiswa</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center hover:border-primary/50 transition-colors">
            <span class="block text-2xl font-bold text-slate-800">{{ $stats['total_lecturers'] }}</span>
            <span class="block text-xs font-medium text-slate-500 mt-1 uppercase tracking-wider">Total Dosen</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center hover:border-primary/50 transition-colors">
            <span class="block text-2xl font-bold text-slate-800">{{ $stats['total_companies'] }}</span>
            <span class="block text-xs font-medium text-slate-500 mt-1 uppercase tracking-wider">Perusahaan Mitra</span>
        </div>
        
        {{-- Internship Metrics --}}
        <div class="bg-emerald-50 p-5 rounded-2xl border border-emerald-100 shadow-sm text-center">
            <span class="block text-2xl font-bold text-emerald-700">{{ $stats['active_internships'] }}</span>
            <span class="block text-xs font-bold text-emerald-600 mt-1 uppercase tracking-wider">Magang Aktif</span>
        </div>
        <div class="bg-amber-50 p-5 rounded-2xl border border-amber-100 shadow-sm text-center">
            <span class="block text-2xl font-bold text-amber-700">{{ $stats['pending_internships'] }}</span>
            <span class="block text-xs font-bold text-amber-600 mt-1 uppercase tracking-wider">Pengajuan Baru</span>
        </div>
        <div class="bg-blue-50 p-5 rounded-2xl border border-blue-100 shadow-sm text-center">
            <span class="block text-2xl font-bold text-blue-700">{{ $stats['active_periods'] }}</span>
            <span class="block text-xs font-bold text-blue-600 mt-1 uppercase tracking-wider">Periode Aktif</span>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Recent Internships List --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col h-full">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-800">Pengajuan Magang Terbaru</h3>
                    <p class="text-xs text-slate-500 mt-1">Pantau aktivitas pengajuan magang yang masuk ke sistem.</p>
                </div>
            </div>
            
            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="text-left px-6 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Mahasiswa</th>
                            <th class="text-left px-6 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Perusahaan</th>
                            <th class="text-left px-6 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Status</th>
                            <th class="text-right px-6 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentInternships as $internship)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-800">{{ $internship->student->user->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $internship->student->user->username }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-800">{{ $internship->company->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColor = match($internship->status) {
                                            'approved' => 'bg-emerald-100 text-emerald-800',
                                            'pending' => 'bg-amber-100 text-amber-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            'completed' => 'bg-blue-100 text-blue-800',
                                            default => 'bg-slate-100 text-slate-800'
                                        };
                                        $statusLabel = match($internship->status) {
                                            'approved' => 'Disetujui',
                                            'pending' => 'Menunggu',
                                            'rejected' => 'Ditolak',
                                            'completed' => 'Selesai',
                                            default => ucfirst($internship->status)
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-xs text-slate-500 whitespace-nowrap">
                                    {{ $internship->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    Belum ada data pengajuan magang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Quick Actions & System Info --}}
        <div class="space-y-6">
            {{-- Quick Actions --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4">Aksi Cepat</h3>
                <div class="grid grid-cols-1 gap-3">
                    <a href="{{ route('admin.users.create') }}" class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:border-primary/30 hover:bg-slate-50 transition-colors group">
                        <div class="h-10 w-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800 group-hover:text-primary transition-colors">Tambah Pengguna Baru</p>
                            <p class="text-xs text-slate-500 mt-0.5">Dosen atau Mahasiswa</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.companies.create') }}" class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:border-primary/30 hover:bg-slate-50 transition-colors group">
                        <div class="h-10 w-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800 group-hover:text-primary transition-colors">Tambah Perusahaan Mitra</p>
                            <p class="text-xs text-slate-500 mt-0.5">Daftarkan tempat PKL baru</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.periods.create') }}" class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:border-primary/30 hover:bg-slate-50 transition-colors group">
                        <div class="h-10 w-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800 group-hover:text-primary transition-colors">Buka Periode Magang</p>
                            <p class="text-xs text-slate-500 mt-0.5">Konfigurasi jadwal magang</p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- System Info --}}
            <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-sm p-6 text-white relative overflow-hidden">
                <svg class="absolute right-0 bottom-0 text-white/5 w-32 h-32 -mb-8 -mr-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/><path d="M11 19.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.22.23-1.8L11 17v2.93zM13 4.07c3.95.49 7 3.85 7 7.93 0 .62-.08 1.22-.23 1.8L13 7V4.07z"/></svg>
                <h3 class="font-bold text-white border-b border-slate-700 pb-3 mb-4 relative z-10">Info Server</h3>
                <div class="space-y-3 text-sm relative z-10">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Versi Laravel</span>
                        <span class="font-medium text-slate-200">11.x</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Versi PHP</span>
                        <span class="font-medium text-slate-200">{{ PHP_VERSION }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Timezone</span>
                        <span class="font-medium text-slate-200">{{ config('app.timezone') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
