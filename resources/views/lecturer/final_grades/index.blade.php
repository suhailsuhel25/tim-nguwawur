{{-- resources/views/lecturer/final_grades/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Penilaian Akhir - Simagang')
@section('header_title', 'Penilaian Akhir')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-8 shadow-lg">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div>
                <h1 class="text-2xl font-bold text-white">
                    Penilaian Akhir Magang
                </h1>

                <p class="text-slate-300 mt-2 text-sm">
                    Kelola dan pantau nilai akhir mahasiswa bimbingan.
                </p>
            </div>

            <a href="{{ route('lecturer.final_grades.create') }}"
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

                Input Nilai Baru
            </a>

        </div>

    </div>

    {{-- Flash Message --}}
    @if(session('success'))

        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl shadow-sm">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5 text-emerald-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>

                </div>

                <div>
                    <h3 class="font-semibold">
                        Berhasil
                    </h3>

                    <p class="text-sm mt-1">
                        {{ session('success') }}
                    </p>
                </div>

            </div>

        </div>

    @endif

    {{-- Warning --}}
    @if($ungradedCount > 0)

        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 shadow-sm">

            <div class="flex items-start gap-4">

                <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center shrink-0">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-6 h-6 text-amber-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 9v2m0 4h.01M10.29
                              3.86L1.82 18a2 2 0
                              001.71 3h16.94a2 2 0
                              001.71-3L13.71 3.86a2
                              2 0 00-3.42 0z"/>
                    </svg>

                </div>

                <div>

                    <h3 class="font-semibold text-amber-800">
                        {{ $ungradedCount }} Mahasiswa Belum Dinilai
                    </h3>

                    <p class="text-sm text-amber-700 mt-1">
                        Terdapat mahasiswa yang belum mendapatkan penilaian akhir magang.
                    </p>

                </div>

            </div>

        </div>

    @endif

    {{-- Table --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        {{-- Header Table --}}
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">

            <div>
                <h2 class="text-lg font-bold text-slate-800">
                    Data Penilaian Mahasiswa
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Daftar nilai akhir mahasiswa bimbingan
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
                            #
                        </th>

                        <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Mahasiswa
                        </th>

                        <th class="text-center px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Laporan
                        </th>

                        <th class="text-center px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Presentasi
                        </th>

                        <th class="text-center px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Sikap
                        </th>

                        <th class="text-center px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Nilai Akhir
                        </th>

                        <th class="text-center px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($grades as $grade)

                        <tr class="hover:bg-slate-50 transition duration-200">

                            {{-- Number --}}
                            <td class="px-6 py-5 text-slate-400 font-medium">
                                {{ $grades->firstItem() + $loop->index }}
                            </td>

                            {{-- Mahasiswa --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-4">

                                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-700">
                                        {{ strtoupper(substr($grade->internship->student->user->name, 0, 1)) }}
                                    </div>

                                    <div>

                                        <h3 class="font-semibold text-slate-800">
                                            {{ $grade->internship->student->user->name }}
                                        </h3>

                                        <p class="text-xs text-slate-500 mt-1">
                                            {{ $grade->internship->company->name }}
                                        </p>

                                    </div>

                                </div>

                            </td>

                            {{-- Nilai Laporan --}}
                            <td class="px-6 py-5 text-center">

                                <span class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 font-bold">
                                    {{ number_format($grade->report_grade, 0) }}
                                </span>

                            </td>

                            {{-- Presentasi --}}
                            <td class="px-6 py-5 text-center">

                                <span class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-purple-50 text-purple-700 font-bold">
                                    {{ number_format($grade->presentation_grade, 0) }}
                                </span>

                            </td>

                            {{-- Sikap --}}
                            <td class="px-6 py-5 text-center">

                                <span class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 font-bold">
                                    {{ number_format($grade->attitude_grade, 0) }}
                                </span>

                            </td>

                            {{-- Final Grade --}}
                            <td class="px-6 py-5 text-center">

                                @php
                                    $fg = $grade->final_grade;
                                    $color = $fg >= 75 ? 'emerald' : ($fg >= 55 ? 'amber' : 'red');
                                @endphp

                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold bg-{{ $color }}-100 text-{{ $color }}-700">

                                    <span class="w-2 h-2 rounded-full bg-{{ $color }}-500"></span>

                                    {{ number_format($fg, 1) }}

                                </span>

                            </td>

                            {{-- Action --}}
                            <td class="px-6 py-5 text-center">

                                <a href="{{ route('lecturer.final_grades.show', $grade) }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-4 h-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5
                                              12 5c4.478 0 8.268 2.943 9.542 7
                                              -1.274 4.057-5.064 7-9.542
                                              7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>

                                    Detail

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="px-6 py-16 text-center">

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
                                                  d="M9 5H7a2 2 0
                                                  00-2 2v12a2 2 0
                                                  002 2h10a2 2 0
                                                  002-2V7a2 2 0
                                                  00-2-2h-2M9 5a2 2
                                                  0 002 2h2a2 2 0
                                                  002-2M9 5a2 2 0
                                                  012-2h2a2 2 0
                                                  012 2m-6 9l2 2 4-4"/>
                                        </svg>

                                    </div>

                                    <h3 class="text-lg font-semibold text-slate-700">
                                        Belum Ada Penilaian
                                    </h3>

                                    <p class="text-slate-500 mt-2">
                                        Data penilaian akhir mahasiswa akan muncul di sini.
                                    </p>

                                    <a href="{{ route('lecturer.final_grades.create') }}"
                                       class="mt-5 inline-flex items-center gap-2 px-5 py-3 bg-slate-900 text-white rounded-2xl text-sm font-semibold hover:bg-slate-800 transition">

                                        + Input Nilai Baru

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        @if($grades->hasPages())

            <div class="px-6 py-5 border-t border-slate-200 bg-slate-50">
                {{ $grades->links('pagination::tailwind') }}
            </div>

        @endif

    </div>

</div>
@endsection