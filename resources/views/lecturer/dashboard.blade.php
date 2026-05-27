{{-- resources/views/dosen/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Dosen - Simagang')
@section('header_title', 'Dashboard Dosen')

@section('content')

<div class="space-y-8">

    {{-- Hero Section --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 shadow-xl">

        {{-- Blur Decoration --}}
        <div class="absolute top-0 right-0 w-72 h-72 bg-blue-500/20 blur-3xl rounded-full"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-indigo-500/20 blur-3xl rounded-full"></div>

        <div class="relative z-10 p-8 lg:p-10">

            <div class="flex flex-col lg:flex-row items-center justify-between gap-10">

                {{-- Left --}}
                <div class="max-w-2xl">

                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 text-white text-sm border border-white/10 backdrop-blur">
                        Dashboard Dosen
                    </span>

                    <h1 class="mt-5 text-4xl font-bold text-white leading-tight">
                        Selamat Datang,
                        <span class="text-blue-300">
                            {{ Auth::user()->name }}
                        </span> 
                    </h1>

                    <p class="mt-4 text-slate-300 leading-relaxed text-sm lg:text-base">
                        Kelola mahasiswa bimbingan, monitoring laporan magang,
                        serta pantau perkembangan aktivitas mahasiswa secara
                        lebih modern, cepat, dan terstruktur.
                    </p>

                    {{-- Quick Button --}}
                    <div class="flex flex-wrap gap-4 mt-8">

                        <a href="{{ route('lecturer.internships.index') }}"
                           class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-white text-slate-900 text-sm font-semibold hover:bg-slate-100 transition">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M9 12h6"/>
                            </svg>

                            Kelola Magang
                        </a>


                    </div>

                </div>

                {{-- Right Illustration --}}
                <div class="hidden lg:flex items-center justify-center">

                    <div class="w-72 h-72 rounded-full bg-white/5 border border-white/10 backdrop-blur flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-40 h-40 text-white/80"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.2"
                                  d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083
                                  12.083 0 0112 20.055a12.083 12.083 0
                                  01-6.16-9.477L12 14z"/>
                        </svg>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Menu Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Card 1 --}}
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm hover:shadow-lg transition duration-300">

            <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 mb-5">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-7 h-7"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17
                          20H7m10 0v-2c0-.656-.126-1.283-.356-1.857"/>
                </svg>

            </div>

            <h3 class="text-lg font-bold text-slate-800">
                Mahasiswa Bimbingan
            </h3>

            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                Pantau dan kelola seluruh mahasiswa yang sedang menjalani magang.
            </p>

        </div>

        {{-- Card 2 --}}
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm hover:shadow-lg transition duration-300">

            <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600 mb-5">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-7 h-7"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 12h6m-6 4h6m2
                          5H7a2 2 0 01-2-2V5"/>
                </svg>

            </div>

            <h3 class="text-lg font-bold text-slate-800">
                Monitoring Laporan
            </h3>

            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                Cek aktivitas dan perkembangan laporan mingguan mahasiswa magang.
            </p>

        </div>

        {{-- Card 3 --}}
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm hover:shadow-lg transition duration-300">

            <div class="w-14 h-14 rounded-2xl bg-violet-100 flex items-center justify-center text-violet-600 mb-5">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-7 h-7"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M5 13l4 4L19 7"/>
                </svg>

            </div>

            <h3 class="text-lg font-bold text-slate-800">
                Verifikasi Data
            </h3>

            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                Validasi dan verifikasi pengajuan magang mahasiswa secara mudah.
            </p>

        </div>

    </div>

    {{-- Table --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-6 border-b border-slate-200">

            <div>

                <h2 class="text-xl font-bold text-slate-800">
                    Mahasiswa Bimbingan
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Daftar mahasiswa yang sedang dibimbing
                </p>

            </div>


        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">
                            Nama Mahasiswa
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">
                            NIM
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">
                            Perusahaan
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-semibold text-slate-600">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

@forelse($internships as $internship)

<tr>

    <td class="px-6 py-4">
        {{ $internship->student->name ?? '-' }}
    </td>

    <td class="px-6 py-4">
        {{ $internship->student->nim ?? '-' }}
    </td>

    <td class="px-6 py-4">
        {{ $internship->company->name ?? '-' }}
    </td>

    <td class="px-6 py-4">

        @if($internship->status == 'approved')
            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                Approved
            </span>

        @elseif($internship->status == 'pending')
            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs">
                Pending
            </span>

        @else
            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs">
                Rejected
            </span>
        @endif

    </td>

    <td class="px-6 py-4">
        <a href="#"
           class="px-3 py-1 bg-slate-100 rounded-lg text-sm">
            Detail
        </a>
    </td>

</tr>

@empty

<tr>
    <td colspan="5" class="text-center py-8 text-slate-500">
        Belum ada data mahasiswa
    </td>
</tr>

@endforelse

</tbody>

            </table>

        </div>

    </div>

</div>

@endsection