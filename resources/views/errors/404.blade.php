@extends('layouts.app')

@section('title', '404 Not Found - Simagang')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center text-center px-4">
    <div class="h-24 w-24 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
    </div>
    <h1 class="text-4xl font-bold text-slate-800 mb-2">404</h1>
    <h2 class="text-xl font-semibold text-slate-600 mb-4">Halaman Tidak Ditemukan</h2>
    <p class="text-slate-500 max-w-md mx-auto mb-8">Maaf, halaman yang Anda cari tidak dapat ditemukan. Mungkin URL salah atau halaman telah dipindahkan.</p>
    <a href="{{ Auth::check() ? route(Auth::user()->role . '.dashboard') : '/' }}" class="px-6 py-2.5 bg-primary text-white rounded-xl font-medium hover:bg-primary-dark transition-colors">
        Kembali ke Dashboard
    </a>
</div>
@endsection
