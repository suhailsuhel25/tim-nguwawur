@extends('layouts.app')

@section('title', '403 Forbidden - Simagang')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center text-center px-4">
    <div class="h-24 w-24 bg-red-50 text-red-500 rounded-full flex items-center justify-center mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
    </div>
    <h1 class="text-4xl font-bold text-slate-800 mb-2">403</h1>
    <h2 class="text-xl font-semibold text-slate-600 mb-4">Akses Ditolak</h2>
    <p class="text-slate-500 max-w-md mx-auto mb-8">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini atau melihat data tersebut.</p>
    <a href="{{ Auth::check() ? route(Auth::user()->role . '.dashboard') : route('login') }}" class="px-6 py-2.5 bg-primary text-white rounded-xl font-medium hover:bg-primary-dark transition-colors">
        Kembali ke Dashboard
    </a>
</div>
@endsection
