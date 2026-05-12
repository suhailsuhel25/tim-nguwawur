{{-- resources/views/admin/companies/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Perusahaan - Simagang')
@section('header_title', 'Manajemen Perusahaan')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Perusahaan Mitra</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola data perusahaan mitra tempat mahasiswa magang.</p>
        </div>
        <a href="{{ route('admin.companies.create') }}"
           id="btn-tambah-perusahaan"
           class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Perusahaan
        </a>
    </div>

    {{-- Filter & Search --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
        <form method="GET" action="{{ route('admin.companies.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" name="search" id="search-perusahaan"
                       value="{{ request('search') }}"
                       placeholder="Cari nama, industri, atau kontak..."
                       class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
            </div>
            <select name="industry" id="filter-industri"
                    class="px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                <option value="">Semua Industri</option>
                @foreach($industries as $industry)
                    <option value="{{ $industry }}" {{ request('industry') === $industry ? 'selected' : '' }}>
                        {{ $industry }}
                    </option>
                @endforeach
            </select>
            <button type="submit" id="btn-filter-perusahaan"
                    class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm font-medium hover:bg-slate-700 transition-colors">
                Filter
            </button>
            @if(request('search') || request('industry'))
                <a href="{{ route('admin.companies.index') }}"
                   class="px-4 py-2 border border-slate-200 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden"
         x-data="{ confirmId: null, confirmName: '' }">

        {{-- Delete Confirmation Modal --}}
        <div x-show="confirmId !== null"
             x-transition.opacity
             class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm"
             style="display:none;">
            <div x-show="confirmId !== null"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-white rounded-xl shadow-xl p-6 max-w-sm w-full mx-4">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-800">Hapus Perusahaan</h3>
                        <p class="text-sm text-slate-500">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                </div>
                <p class="text-sm text-slate-600 mb-5">
                    Apakah Anda yakin ingin menghapus perusahaan <strong x-text="confirmName"></strong>?
                </p>
                <div class="flex gap-3 justify-end">
                    <button @click="confirmId = null; confirmName = ''"
                            class="px-4 py-2 border border-slate-200 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">
                        Batal
                    </button>
                    <form :action="'/admin/companies/' + confirmId" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">#</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Nama Perusahaan</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Industri</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Kontak Person</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Email / Telepon</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($companies as $company)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-4 text-slate-400 tabular-nums">
                                {{ $companies->firstItem() + $loop->index }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-xs flex-shrink-0">
                                        {{ strtoupper(substr($company->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-800">{{ $company->name }}</p>
                                        <p class="text-xs text-slate-400 truncate max-w-[200px]">{{ $company->address }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    {{ $company->industry }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-slate-700">{{ $company->contact_person }}</td>
                            <td class="px-5 py-4 text-slate-500 text-xs">
                                @if($company->contact_email)
                                    <div>{{ $company->contact_email }}</div>
                                @endif
                                @if($company->contact_phone)
                                    <div class="text-slate-400">{{ $company->contact_phone }}</div>
                                @endif
                                @if(!$company->contact_email && !$company->contact_phone)
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.companies.edit', $company) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 border border-slate-200 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-50 hover:border-slate-300 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <button @click="confirmId = {{ $company->id }}; confirmName = '{{ addslashes($company->name) }}'"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 border border-red-200 text-red-600 rounded-lg text-xs font-medium hover:bg-red-50 hover:border-red-300 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <p class="text-slate-500 font-medium">Belum ada perusahaan mitra terdaftar.</p>
                                    <a href="{{ route('admin.companies.create') }}" class="text-primary text-sm hover:underline">+ Tambah perusahaan baru</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($companies->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $companies->links('pagination::tailwind') }}
            </div>
        @endif
    </div>

</div>
@endsection
