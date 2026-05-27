{{-- resources/views/lecturer/mentorship_sessions/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Sesi Bimbingan - Simagang')
@section('header_title', 'Sesi Bimbingan')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-8 shadow-lg">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div>
                <h1 class="text-2xl font-bold text-white">
                    Sesi Bimbingan
                </h1>

                <p class="text-slate-300 mt-2 text-sm">
                    Kelola jadwal dan catatan sesi bimbingan mahasiswa.
                </p>
            </div>

            <a href="{{ route('lecturer.mentorship_sessions.create') }}"
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

                Jadwalkan Sesi Baru
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
                    Filter & Pencarian
                </h3>

                <p class="text-sm text-slate-500">
                    Cari mahasiswa atau filter status sesi
                </p>
            </div>

        </div>

        <form method="GET"
              action="{{ route('lecturer.mentorship_sessions.index') }}"
              class="flex flex-col lg:flex-row gap-3">

            {{-- Search --}}
            <div class="relative flex-1">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama mahasiswa..."
                       class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-2xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-300">

            </div>

            {{-- Status --}}
            <select name="status"
                    class="px-4 py-3 border border-slate-200 rounded-2xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-300">

                <option value="">Semua Status</option>

                <option value="scheduled"
                    {{ request('status') === 'scheduled' ? 'selected' : '' }}>
                    Terjadwal
                </option>

                <option value="completed"
                    {{ request('status') === 'completed' ? 'selected' : '' }}>
                    Selesai
                </option>

                <option value="canceled"
                    {{ request('status') === 'canceled' ? 'selected' : '' }}>
                    Dibatalkan
                </option>

            </select>

            {{-- Button --}}
            <button type="submit"
                    class="px-5 py-3 bg-slate-900 text-white rounded-2xl text-sm font-semibold hover:bg-slate-800 transition">

                Filter

            </button>

            @if(request('search') || request('status'))

                <a href="{{ route('lecturer.mentorship_sessions.index') }}"
                   class="px-5 py-3 border border-slate-200 text-slate-600 rounded-2xl text-sm font-medium hover:bg-slate-50 transition">

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
                    Data Sesi Bimbingan
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Daftar seluruh sesi bimbingan mahasiswa
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
                            Topik
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Jadwal
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

                    @forelse($sessions as $session)

                        <tr class="hover:bg-slate-50 transition duration-200">

                            {{-- Number --}}
                            <td class="px-6 py-5 text-slate-400 font-medium">
                                {{ $sessions->firstItem() + $loop->index }}
                            </td>

                            {{-- Mahasiswa --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-4">

                                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-700">
                                        {{ strtoupper(substr($session->internship->student->user->name, 0, 1)) }}
                                    </div>

                                    <div>

                                        <h3 class="font-semibold text-slate-800">
                                            {{ $session->internship->student->user->name }}
                                        </h3>

                                        <p class="text-xs text-slate-500 mt-1">
                                            {{ $session->internship->company->name }}
                                        </p>

                                    </div>

                                </div>

                            </td>

                            {{-- Topik --}}
                            <td class="px-6 py-5 text-slate-700 max-w-[240px]">

                                <div class="font-medium truncate"
                                     title="{{ $session->topic }}">

                                    {{ $session->topic }}

                                </div>

                            </td>

                            {{-- Jadwal --}}
                            <td class="px-6 py-5 text-sm text-slate-600">

                                <div class="font-semibold text-slate-700">
                                    {{ \Carbon\Carbon::parse($session->date)->translatedFormat('d M Y') }}
                                </div>

                                <div class="text-xs text-slate-500 mt-1">
                                    {{ \Carbon\Carbon::parse($session->date)->translatedFormat('H:i') }} WIB
                                </div>

                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-5">

                                @if($session->status === 'scheduled')

                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">

                                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>

                                        Terjadwal

                                    </span>

                                @elseif($session->status === 'completed')

                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">

                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                                        Selesai

                                    </span>

                                @elseif($session->status === 'canceled')

                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">

                                        <span class="w-2 h-2 rounded-full bg-red-500"></span>

                                        Dibatalkan

                                    </span>

                                @endif

                            </td>

                            {{-- Action --}}
                            <td class="px-6 py-5 text-center">

                                <a href="{{ route('lecturer.mentorship_sessions.show', $session) }}"
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
                                                  d="M8 7V3m8 4V3m-9 8h10M5
                                                  21h14a2 2 0 002-2V7a2 2
                                                  0 00-2-2H5a2 2 0 00-2
                                                  2v12a2 2 0 002 2z"/>
                                        </svg>

                                    </div>

                                    <h3 class="text-lg font-semibold text-slate-700">
                                        Belum Ada Sesi Bimbingan
                                    </h3>

                                    <p class="text-slate-500 mt-2">
                                        Jadwal sesi bimbingan mahasiswa akan muncul di sini.
                                    </p>

                                    <a href="{{ route('lecturer.mentorship_sessions.create') }}"
                                       class="mt-5 inline-flex items-center gap-2 px-5 py-3 bg-slate-900 text-white rounded-2xl text-sm font-semibold hover:bg-slate-800 transition">

                                        + Jadwalkan Sesi Baru

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        @if($sessions->hasPages())

            <div class="px-6 py-5 border-t border-slate-200 bg-slate-50">
                {{ $sessions->links('pagination::tailwind') }}
            </div>

        @endif

    </div>

</div>
@endsection