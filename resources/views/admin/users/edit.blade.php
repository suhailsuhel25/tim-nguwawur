{{-- resources/views/admin/users/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Pengguna - Simagang')
@section('header_title', 'Edit Pengguna')

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
            <h2 class="text-xl font-bold text-slate-800">Edit Pengguna</h2>
            <p class="text-sm text-slate-500">Perbarui data <span class="font-medium text-slate-700">{{ $user->name }}</span></p>
        </div>
    </div>

    {{-- Role Badge Info --}}
    <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
        <div class="h-10 w-10 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0
            {{ $user->role === 'student' ? 'bg-blue-100 text-blue-700' : 'bg-violet-100 text-violet-700' }}">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-800">{{ $user->name }}</p>
            <p class="text-xs text-slate-500">
                @if($user->role === 'student') Mahasiswa @else Dosen @endif
                &bull; {{ $user->username }}
            </p>
        </div>
        <div class="ml-auto">
            @if($user->role === 'student')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Mahasiswa</span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-violet-100 text-violet-800">Dosen</span>
            @endif
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">

        <form action="{{ route('admin.users.update', $user) }}" method="POST" id="form-edit-user">
            @csrf
            @method('PUT')

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
                               value="{{ old('name', $user->name) }}"
                               class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                      {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Username --}}
                    <div>
                        <label for="username" class="block text-sm font-medium text-slate-700 mb-1">
                            Username / NIM / NIP <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="username" id="username"
                               value="{{ old('username', $user->username) }}"
                               class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                      {{ $errors->has('username') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                        @error('username')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password (opsional saat edit) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">
                                Password Baru
                                <span class="text-slate-400 font-normal">(kosongkan jika tidak diubah)</span>
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
                                Konfirmasi Password Baru
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   placeholder="Ulangi password baru"
                                   class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        </div>
                    </div>

                </div>
            </div>

            {{-- Data Tambahan --}}
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100">
                    Data Tambahan
                </h3>
                <div class="space-y-4">

                    @if($user->role === 'student')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="study_program" class="block text-sm font-medium text-slate-700 mb-1">
                                    Program Studi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="study_program" id="study_program"
                                       value="{{ old('study_program', $user->student?->study_program) }}"
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
                                       value="{{ old('cohort_year', $user->student?->cohort_year) }}"
                                       min="2000" max="2099"
                                       class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                              {{ $errors->has('cohort_year') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                                @error('cohort_year')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endif

                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-slate-700 mb-1">
                            Nomor HP
                        </label>
                        <input type="text" name="phone_number" id="phone_number"
                               value="{{ old('phone_number', $user->role === 'student' ? $user->student?->phone_number : $user->lecturer?->phone_number) }}"
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
                <button type="submit" id="btn-update-pengguna"
                        class="px-6 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors shadow-sm">
                    Simpan Perubahan
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
