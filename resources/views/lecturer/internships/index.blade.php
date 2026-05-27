{{-- resources/views/lecturer/internships/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Pengajuan Magang - Simagang')
@section('header_title', 'Pengajuan Magang')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-8 shadow-lg">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div>
                <h1 class="text-2xl font-bold text-white">
                    Daftar Pengajuan Magang
                </h1>

                <p class="text-slate-300 mt-2 text-sm">
                    Kelola dan review pengajuan magang mahasiswa.
                </p>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-2 gap-4 min-w-[320px]">

                <div class="bg-white/10 backdrop-blur rounded-2xl p-5 border border-white/10">
                    <p class="text-slate-300 text-sm">Total Pengajuan</p>
                    <h2 class="text-3xl font-bold text-white mt-2">
                        {{ $internships->total() }}
                    </h2>
                </div>

                <div class="bg-white/10 backdrop-blur rounded-2xl p-5 border border-white/10">
                    <p class="text-slate-300 text-sm">Menunggu</p>
                    <h2 class="text-3xl font-bold text-yellow-300 mt-2">
                        {{ $internships->where('status', 'submitted')->count() }}
                    </h2>
                </div>

            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">

        <div class="flex items-center gap-2 mb-4">
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
                          a1 1 0 01-.293.707L14 13.414V19a1 1 0
                          01-.553.894l-4 2A1 1 0 018 21v-7.586L3.293
                          6.707A1 1 0 013 6V4z"/>
                </svg>
            </div>

            <div>
                <h3 class="font-semibold text-slate-800">
                    Filter Pengajuan
                </h3>

                <p class="text-sm text-slate-500">
                    Pilih status pengajuan magang
                </p>
            </div>
        </div>

        <form method="GET"
              action="{{ route('lecturer.internships.index') }}"
              class="flex flex-col sm:flex-row gap-3">

            <select name="status"
                    id="filter-status"
                    class="px-4 py-3 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">

                <option value="">Semua Status</option>

                <option value="pending"
                    {{ request('status') === 'pending' ? 'selected' : '' }}>
                    Menunggu Persetujuan
                </option>

                <option value="approved"
                    {{ request('status') === 'approved' ? 'selected' : '' }}>
                    Disetujui
                </option>

                <option value="rejected"
                    {{ request('status') === 'rejected' ? 'selected' : '' }}>
                    Ditolak
                </option>
            </select>

            <button type="submit"
                    class="px-5 py-3 bg-slate-900 text-white rounded-xl text-sm font-semibold hover:bg-slate-800 transition">
                Terapkan Filter
            </button>

            @if(request('status'))
                <a href="{{ route('lecturer.internships.index') }}"
                   class="px-5 py-3 border border-slate-200 text-slate-600 rounded-xl text-sm font-medium hover:bg-slate-50 transition">
                    Reset
                </a>
            @endif

        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        {{-- Header Table --}}
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">

            <div>
                <h2 class="text-lg font-bold text-slate-800">
                    Data Pengajuan Magang
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Daftar seluruh pengajuan mahasiswa
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
                            #
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Mahasiswa
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Perusahaan
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Periode
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

                    @forelse($internships as $internship)

                        <tr class="hover:bg-slate-50 transition duration-200">

                            <td class="px-6 py-5 text-slate-400 font-medium">
                                {{ $internships->firstItem() + $loop->index }}
                            </td>

                            {{-- Mahasiswa --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-4">

                                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-700">
                                        {{ strtoupper(substr($internship->student->user->name, 0, 1)) }}
                                    </div>

                                    <div>
                                        <h3 class="font-semibold text-slate-800">
                                            {{ $internship->student->user->name }}
                                        </h3>

                                        <p class="text-xs text-slate-500 mt-1">
                                            {{ $internship->student->user->username }}
                                            •
                                            {{ $internship->student->study_program }}
                                        </p>
                                    </div>

                                </div>

                            </td>

                            {{-- Perusahaan --}}
                            <td class="px-6 py-5">

                                <div>
                                    <h3 class="font-semibold text-slate-800">
                                        {{ $internship->company->name }}
                                    </h3>

                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ $internship->company->industry }}
                                    </p>
                                </div>

                            </td>

                            {{-- Periode --}}
                            <td class="px-6 py-5 text-sm text-slate-600">

                                <div class="font-semibold text-slate-700">
                                    {{ $internship->internshipPeriod->name }}
                                </div>

                                <div class="text-xs text-slate-500 mt-1">
                                    {{ \Carbon\Carbon::parse($internship->start_date)->translatedFormat('d M Y') }}
                                    -
                                    {{ \Carbon\Carbon::parse($internship->end_date)->translatedFormat('d M Y') }}
                                </div>

                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-5">

                                @if($internship->status === 'submitted')
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                        <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                                        Menunggu
                                    </span>

                                @elseif($internship->status === 'approved')
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                        Disetujui
                                    </span>

                                @elseif($internship->status === 'rejected')
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                        Ditolak
                                    </span>

                                @endif

                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-5 text-center">

                                <a href="{{ route('lecturer.internships.show', $internship) }}"
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

                                    {{ $internship->status === 'submitted' ? 'Review' : 'Detail' }}
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">

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
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0
                                                  01-2-2V5a2 2 0 012-2h5.586a1
                                                  1 0 01.707.293l5.414 5.414a1
                                                  1 0 01.293.707V19a2 2 0
                                                  01-2 2z" />
                                        </svg>
                                    </div>

                                    <h3 class="text-lg font-semibold text-slate-700">
                                        Belum Ada Pengajuan
                                    </h3>

                                    <p class="text-slate-500 mt-2">
                                        Data pengajuan magang mahasiswa akan muncul di sini.
                                    </p>

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