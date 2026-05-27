{{-- resources/views/dosen/weekly_reports/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Validasi Laporan Mingguan - Simagang')
@section('header_title', 'Laporan Mingguan')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-8 shadow-lg">

        <div>
            <h1 class="text-2xl font-bold text-white">
                Laporan Mingguan Mahasiswa
            </h1>

            <p class="text-slate-300 mt-2 text-sm">
                Pantau dan validasi laporan kegiatan mahasiswa bimbingan.
            </p>
        </div>

    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">

        <div class="flex items-center gap-3 mb-5">

            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2
                          a1 1 0 01-.293.707L14 13.414V19a1
                          1 0 01-.553.894l-4 2A1 1 0 018
                          21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
            </div>

            <div>
                <h3 class="font-semibold text-slate-800">
                    Filter Status
                </h3>

                <p class="text-sm text-slate-500">
                    Pilih status laporan mingguan
                </p>
            </div>

        </div>

        <div class="flex flex-wrap gap-3">

            <a href="{{ route('lecturer.weekly_reports.index') }}"
               class="px-4 py-2 rounded-xl text-sm font-medium transition
               {{ !$status
                    ? 'bg-slate-900 text-white shadow'
                    : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua
            </a>

            <a href="{{ route('lecturer.weekly_reports.index', ['status' => 'submitted']) }}"
               class="px-4 py-2 rounded-xl text-sm font-medium transition
               {{ $status === 'submitted'
                    ? 'bg-yellow-500 text-white shadow'
                    : 'bg-yellow-50 text-yellow-700 hover:bg-yellow-100' }}">
                Menunggu
            </a>

            <a href="{{ route('lecturer.weekly_reports.index', ['status' => 'validated']) }}"
               class="px-4 py-2 rounded-xl text-sm font-medium transition
               {{ $status === 'validated'
                    ? 'bg-emerald-600 text-white shadow'
                    : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                Tervalidasi
            </a>

        </div>

    </div>

    {{-- Table --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        {{-- Header Table --}}
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">

            <div>
                <h2 class="text-lg font-bold text-slate-800">
                    Data Laporan Mingguan
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Daftar laporan mahasiswa bimbingan
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
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Mahasiswa
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Minggu
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($reports as $report)

                        <tr class="hover:bg-slate-50 transition duration-200">

                            {{-- Mahasiswa --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-4">

                                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-700">
                                        {{ strtoupper(substr($report->internship->student->user->name, 0, 1)) }}
                                    </div>

                                    <div>
                                        <h3 class="font-semibold text-slate-800">
                                            {{ $report->internship->student->user->name }}
                                        </h3>

                                        <p class="text-xs text-slate-500 mt-1">
                                            {{ $report->internship->student->user->username }}
                                        </p>
                                    </div>

                                </div>

                            </td>

                            {{-- Minggu --}}
                            <td class="px-6 py-5">

                                <div class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-sm font-semibold">
                                    Minggu {{ $report->week_number }}
                                </div>

                            </td>

                            {{-- Tanggal --}}
                            <td class="px-6 py-5 text-sm text-slate-600">

                                <div class="font-medium text-slate-700">
                                    {{ \Carbon\Carbon::parse($report->start_date)->translatedFormat('d M') }}
                                    -
                                    {{ \Carbon\Carbon::parse($report->end_date)->translatedFormat('d M Y') }}
                                </div>

                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-5">

                                @if($report->status === 'draft')

                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                        <span class="w-2 h-2 rounded-full bg-slate-500"></span>
                                        Draft
                                    </span>

                                @elseif($report->status === 'submitted')

                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                        <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                                        Menunggu
                                    </span>

                                @elseif($report->status === 'validated')

                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        Tervalidasi
                                    </span>

                                @endif

                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-5 text-center">

                                <a href="{{ route('lecturer.weekly_reports.show', $report) }}"
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

                                    Review
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">

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
                                                  d="M9 12h6m-6 4h6m2 5H7a2
                                                  2 0 01-2-2V5a2 2 0
                                                  012-2h5.586a1 1 0
                                                  01.707.293l5.414
                                                  5.414a1 1 0
                                                  01.293.707V19a2 2
                                                  0 01-2 2z"/>
                                        </svg>

                                    </div>

                                    <h3 class="text-lg font-semibold text-slate-700">
                                        Belum Ada Laporan
                                    </h3>

                                    <p class="text-slate-500 mt-2">
                                        Data laporan mingguan mahasiswa akan muncul di sini.
                                    </p>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        @if($reports->hasPages())
            <div class="px-6 py-5 border-t border-slate-200 bg-slate-50">
                {{ $reports->links() }}
            </div>
        @endif

    </div>

</div>
@endsection