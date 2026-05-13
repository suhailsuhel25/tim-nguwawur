{{-- resources/views/dosen/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Dosen - Simagang')
@section('header_title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
        <div class="bg-blue-50 p-3 rounded-lg text-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500">Mahasiswa Bimbingan</p>
            <p class="text-xl font-bold text-slate-800">0</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
    <h2 class="text-lg font-bold text-slate-800 mb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
    <p class="text-slate-600">Ini adalah dashboard akademik Anda. Anda dapat memantau mahasiswa bimbingan, menyetujui pengajuan magang, dan memberikan penilaian.</p>
</div>
@endsection
