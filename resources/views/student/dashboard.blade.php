{{-- resources/views/mahasiswa/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa - Simagang')
@section('header_title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Hero Section --}}
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-8 shadow-lg overflow-hidden relative">

        <div class="absolute right-0 top-0 opacity-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-72 h-72 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 4h14a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z" />
            </svg>
        </div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div>

                <p class="text-slate-300 text-sm font-medium mb-2">
                    Dashboard Mahasiswa
                </p>

                <h1 class="text-3xl font-bold text-white leading-tight">
                    Selamat Datang, {{ Auth::user()->name }} 
                </h1>

                <p class="text-slate-300 mt-3 max-w-2xl">
                    Pantau proses magang, laporan mingguan, jadwal bimbingan,
                    dan perkembangan akademik Anda secara mudah dalam satu dashboard.
                </p>

            </div>

            <div class="flex flex-wrap gap-3">

                
                    <a href="{{ route('student.internships.create') }}"
                class="px-6 py-3 bg-white text-slate-800 rounded-2xl font-medium shadow hover:scale-105 transition inline-block">
                    + Ajukan Magang
                </a>

            </div>

        </div>

    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        {{-- Status Magang --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">

            <div class="flex items-center justify-between mb-5">

                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>

                </div>

                <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-600 text-xs font-semibold">
                    Pending
                </span>

            </div>

            <h3 class="text-sm text-slate-500 font-medium">
                Status Magang
            </h3>

            <p class="text-2xl font-bold text-slate-800 mt-2">
                Belum Daftar
            </p>

            <p class="text-xs text-slate-400 mt-2">
                Segera lakukan pengajuan magang
            </p>

        </div>

        {{-- Laporan --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">

            <div class="flex items-center justify-between mb-5">

                <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>

                </div>

                <span class="text-xs font-semibold text-slate-400">
                    Mingguan
                </span>

            </div>

            <h3 class="text-sm text-slate-500 font-medium">
                Laporan Terkirim
            </h3>

            <p class="text-2xl font-bold text-slate-800 mt-2">
                0
            </p>

            <p class="text-xs text-slate-400 mt-2">
                Belum ada laporan yang dikirim
            </p>

        </div>

        {{-- Bimbingan --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">

            <div class="flex items-center justify-between mb-5">

                <div class="w-14 h-14 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>

                </div>

                <span class="text-xs font-semibold text-slate-400">
                    Jadwal
                </span>

            </div>

            <h3 class="text-sm text-slate-500 font-medium">
                Sesi Bimbingan
            </h3>

            <p class="text-2xl font-bold text-slate-800 mt-2">
                0
            </p>

            <p class="text-xs text-slate-400 mt-2">
                Belum ada jadwal bimbingan
            </p>

        </div>

        {{-- Nilai --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">

            <div class="flex items-center justify-between mb-5">

                <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-1.042-.133-2.052-.382-3.016z" />
                    </svg>

                </div>

                <span class="text-xs font-semibold text-slate-400">
                    Akademik
                </span>

            </div>

            <h3 class="text-sm text-slate-500 font-medium">
                Nilai Akhir
            </h3>

            <p class="text-2xl font-bold text-slate-800 mt-2">
                -
            </p>

            <p class="text-xs text-slate-400 mt-2">
                Belum tersedia
            </p>

        </div>

    </div>

    {{-- Informasi --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Aktivitas --}}
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-200">

                <h2 class="text-lg font-bold text-slate-800">
                    Aktivitas Terbaru
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Informasi terbaru terkait kegiatan magang Anda
                </p>

            </div>

            <div class="p-6">

                <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">

                    <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21
                                12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                    </div>

                    <div>

                        <h3 class="font-semibold text-slate-800">
                            Belum Ada Aktivitas
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Aktivitas terbaru Anda akan muncul di sini.
                        </p>

                    </div>

                </div>

            </div>

        </div>

        {{-- Informasi Cepat --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-200">

                <h2 class="text-lg font-bold text-slate-800">
                    Informasi Cepat
                </h2>

            </div>

            <div class="p-6 space-y-4">

                <div class="p-4 rounded-2xl bg-blue-50 border border-blue-100">
                    <p class="text-sm font-semibold text-blue-700">
                        Pengajuan Magang
                    </p>
                    <p class="text-xs text-blue-600 mt-1">
                        Lengkapi data magang Anda sebelum batas waktu.
                    </p>
                </div>

                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100">
                    <p class="text-sm font-semibold text-emerald-700">
                        Laporan Mingguan
                    </p>
                    <p class="text-xs text-emerald-600 mt-1">
                        Jangan lupa mengisi laporan setiap minggu.
                    </p>
                </div>

                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-100">
                    <p class="text-sm font-semibold text-amber-700">
                        Bimbingan
                    </p>
                    <p class="text-xs text-amber-600 mt-1">
                        Pantau jadwal bimbingan bersama dosen pembimbing.
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection