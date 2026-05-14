@extends('layouts.app')

@section('title', '500 Server Error - Simagang')

@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center text-center px-4">
    <div class="text-red-500 mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </div>
    <h1 class="text-6xl font-bold text-slate-800 mb-4">500</h1>
    <h2 class="text-2xl font-semibold text-slate-700 mb-2">Terjadi Kesalahan Server</h2>
    <p class="text-slate-500 max-w-md mx-auto mb-8">Maaf, ada sesuatu yang salah di sisi kami. Tim kami telah diberitahu dan sedang memperbaikinya. Silakan coba beberapa saat lagi.</p>
    
    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-slate-800 text-white px-6 py-3 rounded-xl font-medium hover:bg-slate-900 transition-colors shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
        Segarkan Halaman
    </a>
</div>
@endsection
