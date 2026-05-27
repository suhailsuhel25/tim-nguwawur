{{-- resources/views/admin/companies/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Perusahaan - Simagang')
@section('header_title', 'Manajemen Perusahaan')

@section('content')
<div class="space-y-6">

    {{-- Hero Header --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 p-8 shadow-xl">
        <div class="absolute top-0 right-0 w-72 h-72 bg-emerald-500/20 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-white text-xs font-medium mb-4 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Data Perusahaan Aktif
                </div>

                <h2 class="text-3xl font-bold text-white leading-tight">
                    Manajemen Perusahaan
                </h2>

                <p class="text-slate-300 mt-2 max-w-2xl text-sm">
                    Kelola perusahaan mitra magang mahasiswa dengan tampilan modern dan terstruktur.
                </p>
            </div>

            <a href="{{ route('admin.companies.create') }}"
               class="inline-flex items-center justify-center gap-2 bg-white text-slate-800 px-5 py-3 rounded-xl text-sm font-semibold hover:bg-slate-100 transition-all duration-200 shadow-lg hover:scale-[1.02]">
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
                Tambah Perusahaan
            </a>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <form method="GET"
              action="{{ route('admin.companies.index') }}"
              class="grid grid-cols-1 md:grid-cols-12 gap-4">

            {{-- Search --}}
            <div class="md:col-span-7 relative">
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
                       placeholder="Cari nama perusahaan, industri, atau kontak..."
                       class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 outline-none transition">
            </div>

            {{-- Industry --}}
            <div class="md:col-span-3">
                <select name="industry"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 outline-none transition">
                    <option value="">Semua Industri</option>

                    @foreach($industries as $industry)
                        <option value="{{ $industry }}"
                            {{ request('industry') === $industry ? 'selected' : '' }}>
                            {{ $industry }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Button --}}
            <div class="md:col-span-2 flex gap-2">
                <button type="submit"
                        class="flex-1 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium rounded-xl px-4 py-3 transition-all">
                    Filter
                </button>

                @if(request('search') || request('industry'))
                    <a href="{{ route('admin.companies.index') }}"
                       class="px-4 py-3 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all text-sm">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden"
         x-data="{ confirmId: null, confirmName: '' }">

        {{-- Delete Modal --}}
        <div x-show="confirmId !== null"
             x-transition.opacity
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
             style="display:none;">

            <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md mx-4"
                 x-transition>

                <div class="flex items-center gap-4 mb-5">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
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
                        <h3 class="font-bold text-slate-800">
                            Hapus Perusahaan
                        </h3>

                        <p class="text-sm text-slate-500">
                            Data tidak dapat dikembalikan.
                        </p>
                    </div>
                </div>

                <p class="text-sm text-slate-600 mb-6">
                    Yakin ingin menghapus perusahaan
                    <strong x-text="confirmName"></strong> ?
                </p>

                <div class="flex justify-end gap-3">
                    <button @click="confirmId = null; confirmName = ''"
                            class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                        Batal
                    </button>

                    <form :action="'/admin/companies/' + confirmId"
                          method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="px-4 py-2 rounded-xl bg-red-600 text-white hover:bg-red-700 transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Perusahaan
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Industri
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Kontak
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Email / Telepon
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($companies as $company)
                        <tr class="hover:bg-slate-50 transition-all duration-200">

                            {{-- Company --}}
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">

                                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm shadow-sm">
                                        {{ strtoupper(substr($company->name, 0, 2)) }}
                                    </div>

                                    <div>
                                        <div class="font-semibold text-slate-800">
                                            {{ $company->name }}
                                        </div>

                                        <div class="text-xs text-slate-400 mt-1 max-w-[250px] truncate">
                                            {{ $company->address }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Industry --}}
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    {{ $company->industry }}
                                </span>
                            </td>

                            {{-- Contact --}}
                            <td class="px-6 py-5">
                                <div class="font-medium text-slate-700">
                                    {{ $company->contact_person }}
                                </div>

                                <div class="text-xs text-slate-400 mt-1">
                                    PIC Perusahaan
                                </div>
                            </td>

                            {{-- Email / Phone --}}
                            <td class="px-6 py-5 text-sm">
                                @if($company->contact_email)
                                    <div class="text-slate-700">
                                        {{ $company->contact_email }}
                                    </div>
                                @endif

                                @if($company->contact_phone)
                                    <div class="text-slate-400 text-xs mt-1">
                                        {{ $company->contact_phone }}
                                    </div>
                                @endif

                                @if(!$company->contact_email && !$company->contact_phone)
                                    <span class="text-slate-400">
                                        -
                                    </span>
                                @endif
                            </td>

                            {{-- Action --}}
                            <td class="px-6 py-5">
                                <div class="flex items-center justify-end gap-2">

                                    <a href="{{ route('admin.companies.edit', $company) }}"
                                       class="inline-flex items-center gap-1 px-4 py-2 rounded-xl border border-slate-200 text-slate-600 text-xs font-medium hover:bg-slate-100 transition-all">
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

                                    <button
                                        @click="confirmId = {{ $company->id }}; confirmName = '{{ addslashes($company->name) }}'"
                                        class="inline-flex items-center gap-1 px-4 py-2 rounded-xl bg-red-50 text-red-600 text-xs font-medium hover:bg-red-100 transition-all">
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
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">

                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mb-5">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-10 w-10 text-slate-300"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="1.5"
                                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>

                                    <h3 class="text-lg font-semibold text-slate-700">
                                        Belum Ada Perusahaan
                                    </h3>

                                    <p class="text-sm text-slate-400 mt-1 mb-5">
                                        Tambahkan perusahaan mitra baru untuk mulai mengelola data magang.
                                    </p>

                                    <a href="{{ route('admin.companies.create') }}"
                                       class="inline-flex items-center gap-2 bg-emerald-600 text-white px-5 py-3 rounded-xl text-sm font-medium hover:bg-emerald-700 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Tambah Perusahaan
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- Pagination --}}
        @if($companies->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                {{ $companies->links('pagination::tailwind') }}
            </div>
        @endif

    </div>
</div>
@endsection