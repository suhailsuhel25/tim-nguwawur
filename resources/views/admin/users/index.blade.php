{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Pengguna - Simagang')
@section('header_title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6">

    {{-- Hero Header --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 p-8 shadow-xl">
        <div class="absolute top-0 right-0 w-72 h-72 bg-primary/20 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-white text-xs font-medium mb-4 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Sistem Aktif
                </div>

                <h2 class="text-3xl font-bold text-white leading-tight">
                    Manajemen Pengguna
                </h2>

                <p class="text-slate-300 mt-2 max-w-2xl text-sm">
                    Kelola akun mahasiswa dan dosen dengan tampilan modern, cepat, dan terstruktur.
                </p>
            </div>

            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center justify-center gap-2 bg-white text-slate-800 px-5 py-3 rounded-xl text-sm font-semibold hover:bg-slate-100 transition-all duration-200 shadow-lg hover:scale-[1.02]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Pengguna
            </a>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <form method="GET"
              action="{{ route('admin.users.index') }}"
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
                       placeholder="Cari nama atau username pengguna..."
                       class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition">
            </div>

            {{-- Role --}}
            <div class="md:col-span-3">
                <select name="role"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition">
                    <option value="">Semua Role</option>
                    <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>
                        Mahasiswa
                    </option>
                    <option value="lecturer" {{ request('role') === 'lecturer' ? 'selected' : '' }}>
                        Dosen
                    </option>
                </select>
            </div>

            {{-- Button --}}
            <div class="md:col-span-2 flex gap-2">
                <button type="submit"
                        class="flex-1 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium rounded-xl px-4 py-3 transition-all">
                    Filter
                </button>

                @if(request('search') || request('role'))
                    <a href="{{ route('admin.users.index') }}"
                       class="px-4 py-3 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all text-sm">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Users Table --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden"
         x-data="{ confirmId: null, confirmName: '' }">

        {{-- Modal --}}
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
                            Hapus Pengguna
                        </h3>

                        <p class="text-sm text-slate-500">
                            Data tidak dapat dikembalikan.
                        </p>
                    </div>
                </div>

                <p class="text-sm text-slate-600 mb-6">
                    Yakin ingin menghapus pengguna
                    <strong x-text="confirmName"></strong> ?
                </p>

                <div class="flex justify-end gap-3">
                    <button @click="confirmId = null; confirmName = ''"
                            class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                        Batal
                    </button>

                    <form :action="'/admin/users/' + confirmId"
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
                            Pengguna
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Username
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Role
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Informasi
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50 transition-all duration-200">

                            {{-- User --}}
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">

                                    <div class="w-11 h-11 rounded-2xl flex items-center justify-center font-bold text-sm shadow-sm
                                        {{ $user->role === 'student'
                                            ? 'bg-blue-100 text-blue-700'
                                            : 'bg-violet-100 text-violet-700' }}">

                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>

                                    <div>
                                        <div class="font-semibold text-slate-800">
                                            {{ $user->name }}
                                        </div>

                                        <div class="text-xs text-slate-400">
                                            ID #{{ $user->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Username --}}
                            <td class="px-6 py-5">
                                <span class="font-mono text-xs bg-slate-100 text-slate-700 px-3 py-1 rounded-lg">
                                    {{ $user->username }}
                                </span>
                            </td>

                            {{-- Role --}}
                            <td class="px-6 py-5">
                                @if($user->role === 'student')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                        Mahasiswa
                                    </span>
                                @elseif($user->role === 'lecturer')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-violet-100 text-violet-700">
                                        <span class="w-2 h-2 rounded-full bg-violet-500"></span>
                                        Dosen
                                    </span>
                                @endif
                            </td>

                            {{-- Info --}}
                            <td class="px-6 py-5">
                                @if($user->role === 'student' && $user->student)
                                    <div class="text-sm font-medium text-slate-700">
                                        {{ $user->student->study_program }}
                                    </div>

                                    <div class="text-xs text-slate-400 mt-1">
                                        Angkatan {{ $user->student->cohort_year }}
                                    </div>

                                @elseif($user->role === 'lecturer' && $user->lecturer)

                                    <div class="text-sm font-medium text-slate-700">
                                        {{ $user->lecturer->phone_number ?? '-' }}
                                    </div>

                                    <div class="text-xs text-slate-400 mt-1">
                                        Dosen Pembimbing
                                    </div>
                                @endif
                            </td>

                            {{-- Action --}}
                            <td class="px-6 py-5">
                                <div class="flex items-center justify-end gap-2">

                                    <a href="{{ route('admin.users.edit', $user) }}"
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
                                        @click="confirmId = {{ $user->id }}; confirmName = '{{ addslashes($user->name) }}'"
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
                                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>

                                    <h3 class="text-lg font-semibold text-slate-700">
                                        Belum Ada Pengguna
                                    </h3>

                                    <p class="text-sm text-slate-400 mt-1 mb-5">
                                        Tambahkan pengguna baru untuk mulai mengelola sistem.
                                    </p>

                                    <a href="{{ route('admin.users.create') }}"
                                       class="inline-flex items-center gap-2 bg-primary text-white px-5 py-3 rounded-xl text-sm font-medium hover:bg-primary/90 transition">
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
                                        Tambah Pengguna
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                {{ $users->links('pagination::tailwind') }}
            </div>
        @endif

    </div>
</div>
@endsection