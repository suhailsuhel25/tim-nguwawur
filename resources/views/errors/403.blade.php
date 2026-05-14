@extends('layouts.app')

@section('title', '403 Forbidden - Simagang')

@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center text-center px-4">
    <div class="text-primary mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
    </div>
    <h1 class="text-6xl font-bold text-slate-800 mb-4">403</h1>
    <h2 class="text-2xl font-semibold text-slate-700 mb-2">Akses Ditolak</h2>
    <p class="text-slate-500 max-w-md mx-auto mb-8">Anda tidak memiliki izin untuk mengakses halaman atau data ini. Silakan kembali ke dashboard Anda.</p>
    
    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-xl font-medium hover:bg-primary-dark transition-colors shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Kembali ke Beranda
    </a>
</div>
@endsection
