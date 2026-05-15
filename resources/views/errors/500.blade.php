@extends('layouts.app')

@section('title', '500 Server Error - Simagang')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center text-center px-4">
    <div class="h-24 w-24 bg-red-50 text-red-600 rounded-full flex items-center justify-center mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </div>
    <h1 class="text-4xl font-bold text-slate-800 mb-2">500</h1>
    <h2 class="text-xl font-semibold text-slate-600 mb-4">Kesalahan Server Internal</h2>
    <p class="text-slate-500 max-w-md mx-auto mb-8">Maaf, terjadi kesalahan pada server kami. Tim teknis telah diberitahu dan sedang menangani masalah ini.</p>
    <a href="{{ Auth::check() ? route(Auth::user()->role . '.dashboard') : '/' }}" class="px-6 py-2.5 bg-primary text-white rounded-xl font-medium hover:bg-primary-dark transition-colors">
        Kembali ke Dashboard
    </a>
</div>
@endsection
