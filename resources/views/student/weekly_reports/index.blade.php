{{-- resources/views/mahasiswa/weekly_reports/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Laporan Mingguan - Simagang')
@section('header_title', 'Laporan Mingguan')

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
                    Weekly Reports
                </p>

                <h1 class="text-3xl font-bold text-white">
                    Laporan Mingguan Magang
                </h1>

                <p class="text-slate-300 mt-3 max-w-2xl">
                    Kelola laporan mingguan kegiatan magang Anda,
                    pantau validasi dosen pembimbing,
                    dan dokumentasikan progres pekerjaan setiap minggu.
                </p>

            </div>

            <div class="hidden lg:flex items-center gap-3">

                <div class="bg-white/10 backdrop-blur-sm px-5 py-4 rounded-2xl border border-white/10">

                    <p class="text-xs text-slate-300">
                        Total Laporan
                    </p>

                    <h3 class="text-2xl font-bold text-white mt-1">
                        {{ $reports->count() }}
                    </h3>

                </div>

            </div>

        </div>

    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl shadow-sm flex items-center gap-3">

            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5 text-emerald-600"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M5 13l4 4L19 7"/>
                </svg>

            </div>

            <div>

                <p class="font-semibold">
                    Berhasil
                </p>

                <p class="text-sm">
                    {{ session('success') }}
                </p>

            </div>

        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl shadow-sm flex items-center gap-3">

            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5 text-red-600"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>

            </div>

            <div>

                <p class="font-semibold">
                    Gagal
                </p>

                <p class="text-sm">
                    {{ session('error') }}
                </p>

            </div>

        </div>
    @endif

    {{-- Create Report --}}
    <div>

        <div class="flex items-center justify-between mb-4">

            <div>

                <h2 class="text-xl font-bold text-slate-800">
                    Buat Laporan Baru
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Pilih perusahaan magang aktif untuk membuat laporan mingguan
                </p>

            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            @forelse($internships as $internship)

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-lg hover:-translate-y-1 transition duration-300">

                    <div class="p-6">

                        <div class="flex items-start justify-between mb-5">

                            <div class="flex items-center gap-4">

                                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-lg">

                                    {{ strtoupper(substr($internship->company->name, 0, 1)) }}

                                </div>

                                <div>

                                    <h3 class="font-bold text-slate-800 text-lg">
                                        {{ $internship->company->name }}
                                    </h3>

                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ $internship->internshipPeriod->name }}
                                    </p>

                                </div>

                            </div>

                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">

                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                                Aktif

                            </span>

                        </div>

                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 mb-5">

                            <div class="flex items-center gap-2 text-sm text-slate-600">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-4 h-4"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5
                                          21h14a2 2 0 002-2V7a2
                                          2 0 00-2-2H5a2 2 0 00-2
                                          2v12a2 2 0 002 2z"/>
                                </svg>

                                Periode Magang Aktif

                            </div>

                        </div>

                        <a href="{{ route('student.weekly_reports.create', ['internship_id' => $internship->id]) }}"
                           class="inline-flex items-center justify-center gap-2 w-full px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition">

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

                            Buat Laporan Minggu Ini

                        </a>

                    </div>

                </div>

            @empty

                <div class="col-span-full bg-white border border-dashed border-slate-300 rounded-3xl p-12 text-center shadow-sm">

                    <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-5">

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

                    <h3 class="text-lg font-bold text-slate-700">
                        Tidak Ada Magang Aktif
                    </h3>

                    <p class="text-slate-500 mt-2 max-w-md mx-auto">
                        Anda hanya dapat membuat laporan mingguan
                        jika memiliki pengajuan magang yang telah disetujui.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

    {{-- Report List --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">

            <div>

                <h2 class="text-lg font-bold text-slate-800">
                    Riwayat Laporan Mingguan
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Seluruh laporan mingguan yang pernah Anda buat
                </p>

            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50 border-b border-slate-200">

                    <tr>

                        <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Minggu
                        </th>

                        <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Perusahaan
                        </th>

                        <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Tanggal
                        </th>

                        <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Status
                        </th>

                        <th class="text-right px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($reports as $report)

                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-6 py-5">

                                <div class="font-semibold text-slate-800">
                                    Minggu {{ $report->week_number }}
                                </div>

                            </td>

                            <td class="px-6 py-5">

                                <div class="font-medium text-slate-700">
                                    {{ $report->internship->company->name }}
                                </div>

                            </td>

                            <td class="px-6 py-5 text-sm text-slate-500">

                                {{ \Carbon\Carbon::parse($report->start_date)->translatedFormat('d M Y') }}
                                -
                                {{ \Carbon\Carbon::parse($report->end_date)->translatedFormat('d M Y') }}

                            </td>

                            <td class="px-6 py-5">

                                @if($report->status === 'draft')

                                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold">

                                        <span class="w-2 h-2 rounded-full bg-slate-400"></span>

                                        Draft

                                    </span>

                                @elseif($report->status === 'submitted')

                                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">

                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>

                                        Menunggu Validasi

                                    </span>

                                @elseif($report->status === 'validated')

                                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">

                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                                        Tervalidasi

                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-5 text-right">

                                <a href="{{ route('student.weekly_reports.show', $report) }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-200 text-slate-700 text-sm font-medium hover:bg-slate-100 transition">

                                    Detail

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-4 h-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M9 5l7 7-7 7"/>
                                    </svg>

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="px-6 py-20 text-center">

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
                                                  d="M19 11H5m14 0a2 2
                                                  0 012 2v6a2 2 0
                                                  01-2 2H5a2 2 0
                                                  01-2-2v-6a2 2 0
                                                  012-2m14 0V9a2 2
                                                  0 00-2-2M5 11V9a2
                                                  2 0 002-2m0 0V5a2
                                                  2 0 012-2h6a2 2
                                                  0 012 2v2M7 7h10"/>
                                        </svg>

                                    </div>

                                    <h3 class="text-lg font-bold text-slate-700">
                                        Belum Ada Laporan
                                    </h3>

                                    <p class="text-slate-500 mt-2">
                                        Laporan mingguan yang Anda buat akan tampil di sini.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($reports->hasPages())

            <div class="px-6 py-5 border-t border-slate-200 bg-slate-50">
                {{ $reports->links() }}
            </div>

        @endif

    </div>

</div>
@endsection