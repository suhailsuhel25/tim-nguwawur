{{-- resources/views/admin/periods/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Periode Magang - Simagang')
@section('header_title', 'Periode Magang')

@section('content')
<div class="space-y-6">

    {{-- Hero Section --}}
    <div class="relative overflow-hidden rounded-[28px] bg-gradient-to-r from-[#0F172A] via-[#13223F] to-[#0B5B5B] px-8 py-8 shadow-xl">

        {{-- Blur Decoration --}}
        <div class="absolute top-0 right-0 h-40 w-40 bg-cyan-400/10 blur-3xl rounded-full"></div>
        <div class="absolute bottom-0 left-0 h-32 w-32 bg-primary/10 blur-3xl rounded-full"></div>

        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            {{-- Left --}}
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/10 text-white text-xs font-medium mb-5">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    Data Periode Aktif
                </div>

                <h1 class="text-3xl font-bold text-white tracking-tight">
                    Manajemen Periode Magang
                </h1>

                <p class="mt-3 text-sm text-slate-200 max-w-2xl leading-relaxed">
                    Kelola periode pelaksanaan kegiatan magang mahasiswa dengan tampilan modern,
                    rapi, dan lebih mudah digunakan.
                </p>
            </div>

            {{-- Button --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.periods.create') }}"
                   class="inline-flex items-center gap-2 bg-white text-slate-800 px-5 py-3 rounded-2xl text-sm font-semibold hover:bg-slate-100 transition shadow-lg shadow-black/10">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 4v16m8-8H4"/>
                    </svg>

                    Tambah Periode
                </a>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-[24px] border border-slate-200 shadow-sm p-5">

        <form method="GET"
              action="{{ route('admin.periods.index') }}"
              class="flex flex-col lg:flex-row gap-4">

            {{-- Search --}}
            <div class="relative flex-1">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400"
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
                       placeholder="Cari nama periode..."
                       class="w-full h-12 pl-12 pr-4 rounded-2xl border border-slate-200 bg-slate-50/50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
            </div>

            {{-- Status --}}
            <select name="status"
                    class="h-12 px-4 rounded-2xl border border-slate-200 bg-slate-50/50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">

                <option value="">Semua Status</option>

                <option value="active"
                    {{ request('status') === 'active' ? 'selected' : '' }}>
                    Aktif
                </option>

                <option value="inactive"
                    {{ request('status') === 'inactive' ? 'selected' : '' }}>
                    Tidak Aktif
                </option>
            </select>

            {{-- Button --}}
            <button type="submit"
                    class="h-12 px-8 rounded-2xl bg-[#0F172A] text-white text-sm font-semibold hover:bg-slate-800 transition">
                Filter
            </button>

            @if(request('search') || request('status'))
                <a href="{{ route('admin.periods.index') }}"
                   class="h-12 px-6 rounded-2xl border border-slate-200 text-slate-600 text-sm font-medium flex items-center justify-center hover:bg-slate-50 transition">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[28px] border border-slate-200 shadow-sm overflow-hidden"
         x-data="{ confirmId: null, confirmName: '' }">

        {{-- Delete Modal --}}
        <div x-show="confirmId !== null"
             x-transition.opacity
             class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm"
             style="display:none;">

            <div x-show="confirmId !== null"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-white rounded-3xl shadow-2xl p-6 max-w-sm w-full mx-4">

                <div class="flex items-center gap-4 mb-5">

                    <div class="h-12 w-12 rounded-2xl bg-red-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-6 w-6 text-red-600"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-base font-semibold text-slate-800">
                            Hapus Periode
                        </h3>

                        <p class="text-sm text-slate-500">
                            Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>
                </div>

                <p class="text-sm text-slate-600 mb-6 leading-relaxed">
                    Apakah Anda yakin ingin menghapus periode
                    <strong x-text="confirmName"></strong>?
                </p>

                <div class="flex justify-end gap-3">

                    <button @click="confirmId = null; confirmName = ''"
                            class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50 transition">
                        Batal
                    </button>

                    <form :action="'/admin/periods/' + confirmId"
                          method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="px-4 py-2.5 rounded-xl bg-red-600 text-white text-sm font-medium hover:bg-red-700 transition">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px]">

                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>

                        <th class="px-6 py-5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Periode
                        </th>

                        <th class="px-6 py-5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Jadwal
                        </th>

                        <th class="px-6 py-5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Total Mahasiswa
                        </th>

                        <th class="px-6 py-5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Status
                        </th>

                        <th class="px-6 py-5 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($periods as $period)

                        <tr class="hover:bg-slate-50/70 transition">

                            {{-- Periode --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-4">

                                    <div class="h-14 w-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold shadow-sm">
                                        PM
                                    </div>

                                    <div>
                                        <h3 class="font-semibold text-slate-800">
                                            {{ $period->name }}
                                        </h3>

                                        <p class="text-xs text-slate-400 mt-1">
                                            Periode pelaksanaan magang mahasiswa
                                        </p>
                                    </div>

                                </div>
                            </td>

                            {{-- Jadwal --}}
                            <td class="px-6 py-5">

                                <div class="text-sm font-medium text-slate-700">
                                    {{ \Carbon\Carbon::parse($period->start_date)->translatedFormat('d M Y') }}
                                </div>

                                <div class="text-xs text-slate-400 mt-1">
                                    sampai
                                    {{ \Carbon\Carbon::parse($period->end_date)->translatedFormat('d M Y') }}
                                </div>
                            </td>

                            {{-- Total --}}
                            <td class="px-6 py-5">

                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-100">
                                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                    {{ $period->internships_count ?? 0 }} Mahasiswa
                                </span>

                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-5">

                                @if($period->is_active)

                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-100">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold border border-slate-200">
                                        <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                                        Tidak Aktif
                                    </span>

                                @endif

                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center justify-end gap-3">

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.periods.edit', $period) }}"
                                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50 transition">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>

                                        Edit
                                    </a>

                                    {{-- Delete --}}
                                    <button
                                        @click="confirmId = {{ $period->id }}; confirmName = '{{ addslashes($period->name) }}'"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-red-50 text-red-600 text-xs font-semibold hover:bg-red-100 transition">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>

                                        Hapus
                                    </button>

                                </div>

                            </td>
                        </tr>

                    @empty

                        {{-- Empty State --}}
                        <tr>
                            <td colspan="5"
                                class="px-6 py-20 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="h-20 w-20 rounded-3xl bg-primary/10 flex items-center justify-center mb-5">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-10 w-10 text-primary"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="1.5"
                                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>

                                    <h3 class="text-base font-semibold text-slate-700">
                                        Belum ada periode magang
                                    </h3>

                                    <p class="text-sm text-slate-400 mt-1">
                                        Tambahkan periode baru untuk mulai mengelola data.
                                    </p>

                                    <a href="{{ route('admin.periods.create') }}"
                                       class="mt-5 inline-flex items-center gap-2 bg-primary text-white px-5 py-3 rounded-2xl text-sm font-medium hover:bg-primary/90 transition">
                                        Tambah Periode
                                    </a>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($periods->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                {{ $periods->links('pagination::tailwind') }}
            </div>
        @endif
    </div>

</div>
@endsection