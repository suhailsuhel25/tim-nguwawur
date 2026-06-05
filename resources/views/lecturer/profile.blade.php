{{-- resources/views/lecturer/profile.blade.php --}}
@extends('layouts.app')

@section('title', 'Profile Dosen - Simagang')
@section('header_title', 'Profile')

@section('content')
<div class="space-y-6">

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-8 shadow-lg">

        <div class="flex flex-col md:flex-row md:items-center gap-6">

            {{-- Avatar --}}
            <div class="w-24 h-24 rounded-full bg-white/10 border-4 border-white/20 flex items-center justify-center text-white text-3xl font-bold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>

            {{-- Info --}}
            <div class="flex-1">

                <h1 class="text-2xl font-bold text-white">
                    {{ Auth::user()->name }}
                </h1>

                <p class="text-slate-300 mt-1">
                    NIP: {{ Auth::user()->username }}
                </p>

                @if(Auth::user()->lecturer)
                    <p class="text-slate-400 text-sm mt-1">
                        {{ Auth::user()->lecturer->study_program ?? 'Program Studi belum diatur' }}
                    </p>
                @endif

                <div class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 text-slate-200 text-sm">
                    <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                    Akun Aktif
                </div>

            </div>

        </div>

    </div>

    {{-- Profile Form --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-200">

            <h2 class="text-lg font-bold text-slate-800">
                Informasi Profile
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Perbarui informasi akun Anda
            </p>

        </div>

        <form action="{{ route('lecturer.profile.update') }}"
              method="POST"
              class="p-6 space-y-6">

            @csrf
            @method('PUT')

            {{-- Nama (readonly) --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Nama Lengkap
                </label>

                <input type="text"
                       value="{{ Auth::user()->name }}"
                       class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-500 cursor-not-allowed"
                       readonly>

                <p class="text-xs text-slate-400 mt-1">Nama lengkap tidak dapat diubah.</p>

            </div>

            {{-- NIP (readonly) --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    NIP
                </label>

                <input type="text"
                       value="{{ Auth::user()->username }}"
                       class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-500 cursor-not-allowed"
                       readonly>

                <p class="text-xs text-slate-400 mt-1">NIP tidak dapat diubah.</p>

            </div>

            {{-- Nomor Telepon --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Nomor Telepon
                </label>

                <input type="text"
                       name="phone_number"
                       value="{{ old('phone_number', Auth::user()->lecturer?->phone_number) }}"
                       placeholder="Contoh: 081234567890"
                       class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-300">

                @error('phone_number')
                    <p class="text-sm text-red-500 mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Button --}}
            <div class="pt-2">

                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-3 bg-slate-900 text-white rounded-2xl text-sm font-semibold hover:bg-slate-800 transition">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-4 h-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5 13l4 4L19 7"/>
                    </svg>

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>
@endsection