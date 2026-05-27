{{-- resources/views/student/internships/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Riwayat Pengajuan Magang - Simagang')
@section('header_title', 'Riwayat Pengajuan Magang')

@section('content')
<div class="space-y-6">

    {{-- Hero Section --}}
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-8 shadow-lg overflow-hidden relative">

        <div class="absolute right-0 top-0 opacity-10">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-72 h-72 text-white"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="1"
                      d="M9 12h6m-6 4h6m2
                      5H7a2 2 0 01-2-2V5a2
                      2 0 012-2h5.586a1 1
                      0 01.707.293l5.414
                      5.414a1 1 0 01.293.707V19a2
                      2 0 01-2 2z"/>
            </svg>
        </div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div>

                <p class="text-slate-300 text-sm font-medium mb-2">
                    Pengajuan Magang
                </p>

                <h1 class="text-3xl font-bold text-white">
                    Riwayat Pengajuan Magang
                </h1>

                <p class="text-slate-300 mt-3 max-w-2xl">
                    Pantau seluruh pengajuan magang Anda,
                    status persetujuan, dan dosen pembimbing
                    secara real-time.
                </p>

            </div>

            <a href="{{ route('student.internships.create') }}"
               class="inline-flex items-center gap-2 bg-white text-slate-800 px-5 py-3 rounded-2xl text-sm font-semibold hover:bg-slate-100 transition shadow">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 4v16m8-8H4"/>
                </svg>

                Ajukan Magang

            </a>

        </div>

    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">

            <div>

                <h2 class="text-lg font-bold text-slate-800">
                    Data Pengajuan Magang
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Daftar seluruh pengajuan magang yang telah Anda lakukan
                </p>

            </div>

            <div class="hidden md:flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-sm">

                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>

                Data Real-time

            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50 border-b border-slate-200">

                    <tr>

                        <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Perusahaan
                        </th>

                        <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Periode
                        </th>

                        <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Dosen Pembimbing
                        </th>

                        <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($internships as $internship)

                        <tr class="hover:bg-slate-50 transition duration-200">

                            {{-- Company --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-4">

                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-700 font-bold">

                                        {{ strtoupper(substr($internship->company->name, 0, 1)) }}

                                    </div>

                                    <div>

                                        <h3 class="font-semibold text-slate-800">
                                            {{ $internship->company->name }}
                                        </h3>

                                        <p class="text-xs text-slate-500 mt-1">
                                            {{ $internship->company->industry }}
                                        </p>

                                    </div>

                                </div>

                            </td>

                            {{-- Periode --}}
                            <td class="px-6 py-5">

                                <div class="space-y-1">

                                    <p class="font-semibold text-slate-700 text-sm">
                                        {{ $internship->internshipPeriod->name }}
                                    </p>

                                    <p class="text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($internship->start_date)->translatedFormat('d M Y') }}
                                        -
                                        {{ \Carbon\Carbon::parse($internship->end_date)->translatedFormat('d M Y') }}
                                    </p>

                                </div>

                            </td>

                            {{-- Lecturer --}}
                            <td class="px-6 py-5">

                                @if($internship->lecturer)

                                    <div class="flex items-center gap-3">

                                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-semibold">

                                            {{ strtoupper(substr($internship->lecturer->user->name, 0, 1)) }}

                                        </div>

                                        <div>

                                            <p class="font-medium text-slate-800 text-sm">
                                                {{ $internship->lecturer->user->name }}
                                            </p>

                                            <p class="text-xs text-slate-500">
                                                Dosen Pembimbing
                                            </p>

                                        </div>

                                    </div>

                                @else

                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-slate-100 text-slate-500 text-xs font-medium">
                                        Belum Ditentukan
                                    </span>

                                @endif

                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-5">

                                @if($internship->status === 'submitted')

                                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">

                                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>

                                        Menunggu

                                    </span>

                                @elseif($internship->status === 'approved')

                                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">

                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                                        Disetujui

                                    </span>

                                @elseif($internship->status === 'rejected')

                                    <div class="space-y-2">

                                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold bg-red-100 text-red-700">

                                            <span class="w-2 h-2 rounded-full bg-red-500"></span>

                                            Ditolak

                                        </span>

                                        @if($internship->rejection_note)

                                            <div class="max-w-xs bg-red-50 border border-red-100 rounded-xl p-3">

                                                <p class="text-[11px] text-red-600 leading-relaxed">
                                                    {{ $internship->rejection_note }}
                                                </p>

                                            </div>

                                        @endif

                                    </div>

                                @else

                                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">

                                        <span class="w-2 h-2 rounded-full bg-slate-400"></span>

                                        {{ ucfirst($internship->status) }}

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="px-6 py-20 text-center">

                                <div class="flex flex-col items-center justify-center">

                                    <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center mb-5">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="w-10 h-10 text-slate-400"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="1.5"
                                                  d="M9 12h6m-6 4h6m2
                                                  5H7a2 2 0 01-2-2V5a2
                                                  2 0 012-2h5.586a1 1
                                                  0 01.707.293l5.414
                                                  5.414a1 1 0 01.293.707V19a2
                                                  2 0 01-2 2z"/>
                                        </svg>

                                    </div>

                                    <h3 class="text-lg font-semibold text-slate-700">
                                        Belum Ada Pengajuan
                                    </h3>

                                    <p class="text-slate-500 mt-2">
                                        Anda belum pernah melakukan pengajuan magang.
                                    </p>

                                    <a href="{{ route('student.internships.create') }}"
                                       class="mt-5 inline-flex items-center gap-2 px-5 py-3 bg-slate-900 text-white rounded-2xl text-sm font-semibold hover:bg-slate-800 transition">

                                        + Ajukan Magang

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        @if($internships->hasPages())

            <div class="px-6 py-5 border-t border-slate-200 bg-slate-50">
                {{ $internships->links() }}
            </div>

        @endif

    </div>

</div>
@endsection