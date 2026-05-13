{{-- resources/views/mahasiswa/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa - Simagang')
@section('header_title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
        <div class="bg-blue-50 p-3 rounded-lg text-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500">Status Magang</p>
            <p class="text-xl font-bold text-slate-800">Belum Daftar</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
    <h2 class="text-lg font-bold text-slate-800 mb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
    <p class="text-slate-600">Ini adalah dashboard akademik Anda. Anda dapat mengajukan magang, memantau laporan mingguan, dan melihat jadwal bimbingan di sini.</p>
</div>
@endsection
