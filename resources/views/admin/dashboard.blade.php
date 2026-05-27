{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Admin - Simagang')
@section('header_title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Welcome Banner --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-800 via-slate-700 to-slate-900 p-8 shadow-lg">
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="max-w-2xl">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 text-white text-xs font-medium border border-white/10 mb-4">
                    Panel Administrator
                </span>

                <h1 class="text-3xl font-bold text-white leading-tight">
                    Selamat Datang, Administrator
                </h1>

                <p class="mt-3 text-slate-300 text-sm leading-relaxed">
                    Kelola seluruh sistem magang mulai dari data pengguna, perusahaan mitra,
                    periode magang, hingga monitoring aktivitas mahasiswa dalam satu dashboard.
                </p>

                <div class="flex flex-wrap gap-3 mt-6">
                    <a href="{{ route('admin.users.index') }}"
                       class="inline-flex items-center gap-2 bg-white text-slate-800 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-slate-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M17 20h5V18a3 3 0 00-5.356-1.857M17 20H7m10 0v-2
                                  c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0
                                  015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857
                                  m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0
                                  3 3 0 016 0z"/>
                        </svg>
                        Kelola Pengguna
                    </a>

                    <a href="{{ route('admin.companies.index') }}"
                       class="inline-flex items-center gap-2 bg-slate-700/50 text-white px-4 py-2 rounded-xl text-sm font-medium border border-white/10 hover:bg-slate-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14
                                  0h2m-2 0h-5m-9 0H3m2 0h5"/>
                        </svg>
                        Data Mitra
                    </a>
                </div>
            </div>

            {{-- Illustration --}}
            <div class="hidden lg:flex items-center justify-center">
                <div class="w-40 h-40 rounded-full bg-white/10 flex items-center justify-center border border-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-20 w-20 text-white/80"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.5"
                              d="M9.75 3v2.25m4.5-2.25v2.25M4.5
                              8.25h15M5.25 5.25h13.5A2.25 2.25
                              0 0121 7.5v11.25A2.25 2.25 0
                              0118.75 21H5.25A2.25 2.25 0
                              013 18.75V7.5a2.25 2.25 0
                              012.25-2.25z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Decorative Blur --}}
        <div class="absolute top-0 right-0 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-indigo-500/10 rounded-full blur-3xl"></div>
    </div>

    {{-- Statistic Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

        {{-- Total Mitra --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Mitra
                    </p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $totalCompanies ?? 0 }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-1">
                        Perusahaan mitra aktif
                    </p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2
                              2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Mahasiswa --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Mahasiswa
                    </p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $totalStudents ?? 0 }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-1">
                        Total mahasiswa terdaftar
                    </p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17
                              20H7m10 0v-2c0-.656-.126-1.283-.356-1.857
                              M7 20H2v-2a3 3 0 015.356-1.857"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Dosen --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Dosen
                    </p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $totalLecturers ?? 0 }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-1">
                        Dosen pembimbing aktif
                    </p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-violet-50 flex items-center justify-center text-violet-600">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 14l9-5-9-5-9 5 9 5zm0
                              0l6.16-3.422A12.083 12.083 0
                              0112 20.055a12.083 12.083 0
                              01-6.16-9.477L12 14z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Pengajuan --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Pengajuan Magang
                    </p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $totalInternships ?? 0 }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-1">
                        Total pengajuan masuk
                    </p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 12h6m-6 4h6m2
                              5H7a2 2 0 01-2-2V5a2
                              2 0 012-2h5.586a1 1 0
                              01.707.293l5.414 5.414a1
                              1 0 01.293.707V19a2 2 0
                              01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Information Card --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-6 w-6"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21
                          12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <div>
                <h3 class="text-lg font-bold text-slate-800">
                    Informasi Dashboard
                </h3>

                <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                    Dashboard admin digunakan untuk mengelola seluruh aktivitas sistem magang,
                    mulai dari data pengguna, perusahaan mitra, periode magang,
                    validasi data, hingga monitoring pengajuan mahasiswa.
                </p>
            </div>
        </div>
    </div>

</div>
@endsection