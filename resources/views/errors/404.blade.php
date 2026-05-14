@extends('layouts.app')

@section('title', '404 Not Found - Simagang')

@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center text-center px-4">
    <div class="text-primary mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </div>
    <h1 class="text-6xl font-bold text-slate-800 mb-4">404</h1>
    <h2 class="text-2xl font-semibold text-slate-700 mb-2">Halaman Tidak Ditemukan</h2>
    <p class="text-slate-500 max-w-md mx-auto mb-8">Maaf, halaman yang Anda cari mungkin telah dihapus, namanya diubah, atau sementara tidak tersedia.</p>
    
    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-xl font-medium hover:bg-primary-dark transition-colors shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Kembali ke Beranda
    </a>
</div>
@endsection
