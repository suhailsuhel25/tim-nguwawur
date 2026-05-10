{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Admin - Simagang')
@section('header_title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
        <div class="bg-blue-50 p-3 rounded-lg text-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500">Total Mitra</p>
            <p class="text-xl font-bold text-slate-800">0</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
    <h2 class="text-lg font-bold text-slate-800 mb-2">Selamat Datang, Administrator!</h2>
    <p class="text-slate-600">Ini adalah panel admin. Anda dapat mengelola data master pengguna, perusahaan mitra, dan periode magang di sini.</p>
</div>
@endsection
