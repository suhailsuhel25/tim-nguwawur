{{-- resources/views/admin/users/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Pengguna - Simagang')
@section('header_title', 'Tambah Pengguna')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.users.index') }}"
           class="h-8 w-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Tambah Pengguna Baru</h2>
            <p class="text-sm text-slate-500">Isi formulir berikut untuk menambah mahasiswa atau dosen.</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6"
         x-data="{ role: '{{ old('role', 'student') }}' }">

        <form action="{{ route('admin.users.store') }}" method="POST" id="form-create-user">
            @csrf

            {{-- Informasi Akun --}}
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100">
                    Informasi Akun
                </h3>
                <div class="space-y-4">

                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-1">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name') }}"
                               placeholder="Masukkan nama lengkap"
                               class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                      {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Username / NIM / NIP --}}
                    <div>
                        <label for="username" class="block text-sm font-medium text-slate-700 mb-1">
                            Username / NIM / NIP <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="username" id="username"
                               value="{{ old('username') }}"
                               placeholder="Contoh: 2023001 atau 198501012010011001"
                               class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                      {{ $errors->has('username') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                        @error('username')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password" id="password"
                                   placeholder="Minimal 8 karakter"
                                   class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                          {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">
                                Konfirmasi Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   placeholder="Ulangi password"
                                   class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        </div>
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-3">
                            <label class="flex-1 flex items-center gap-3 p-3 border rounded-lg cursor-pointer transition-all"
                                   :class="role === 'student' ? 'border-primary bg-primary/5' : 'border-slate-200 hover:border-slate-300'">
                                <input type="radio" name="role" value="student" x-model="role" class="text-primary">
                                <div>
                                    <p class="text-sm font-medium text-slate-800">Mahasiswa</p>
                                    <p class="text-xs text-slate-500">Perlu data NIM & prodi</p>
                                </div>
                            </label>
                            <label class="flex-1 flex items-center gap-3 p-3 border rounded-lg cursor-pointer transition-all"
                                   :class="role === 'lecturer' ? 'border-primary bg-primary/5' : 'border-slate-200 hover:border-slate-300'">
                                <input type="radio" name="role" value="lecturer" x-model="role" class="text-primary">
                                <div>
                                    <p class="text-sm font-medium text-slate-800">Dosen</p>
                                    <p class="text-xs text-slate-500">Perlu data NIP</p>
                                </div>
                            </label>
                        </div>
                        @error('role')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Data Tambahan (conditional) --}}
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100">
                    Data Tambahan
                </h3>
                <div class="space-y-4">

                    {{-- Fields khusus Mahasiswa --}}
                    <div x-show="role === 'student'" x-transition class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="study_program" class="block text-sm font-medium text-slate-700 mb-1">
                                    Program Studi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="study_program" id="study_program"
                                       value="{{ old('study_program') }}"
                                       placeholder="Contoh: Teknik Informatika"
                                       class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                              {{ $errors->has('study_program') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                                @error('study_program')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="cohort_year" class="block text-sm font-medium text-slate-700 mb-1">
                                    Angkatan <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="cohort_year" id="cohort_year"
                                       value="{{ old('cohort_year') }}"
                                       placeholder="Contoh: 2023"
                                       min="2000" max="2099"
                                       class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                              {{ $errors->has('cohort_year') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                                @error('cohort_year')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Nomor HP (untuk semua role) --}}
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-slate-700 mb-1">
                            Nomor HP
                        </label>
                        <input type="text" name="phone_number" id="phone_number"
                               value="{{ old('phone_number') }}"
                               placeholder="Contoh: 081234567890"
                               class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        @error('phone_number')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit" id="btn-simpan-pengguna"
                        class="px-6 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors shadow-sm">
                    Simpan Pengguna
                </button>
                <a href="{{ route('admin.users.index') }}"
                   class="px-6 py-2 border border-slate-200 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>
@endsection
