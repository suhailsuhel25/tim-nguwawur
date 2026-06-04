{{-- resources/views/student/setprofilestudent.blade.php --}}
@extends('layouts.app')

@section('title', 'Ubah Password - Simagang')
@section('header_title', 'Ubah Password')

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

        <div class="flex items-center gap-5">

            <div class="w-20 h-20 rounded-3xl bg-white/10 flex items-center justify-center">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-10 h-10 text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 15v2m-6 4h12a2 2 0
                          002-2v-6a2 2 0 00-2-2H6a2
                          2 0 00-2 2v6a2 2 0 002
                          2zm10-10V7a4 4 0 00-8
                          0v4h8z"/>
                </svg>

            </div>

            <div>

                <h1 class="text-2xl font-bold text-white">
                    Ubah Password
                </h1>

                <p class="text-slate-300 mt-1 text-sm">
                    Pastikan password baru Anda aman dan mudah diingat.
                </p>

            </div>

        </div>

    </div>

    {{-- Form --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-200">

            <h2 class="text-lg font-bold text-slate-800">
                Form Ubah Password
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Gunakan kombinasi huruf, angka, dan simbol.
            </p>

        </div>

        <form action="{{ route('student.setprofilestudent.update') }}"
              method="POST"
              class="p-6 space-y-6">

            @csrf
            @method('PUT')

            {{-- Password Lama --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Password Lama
                </label>

                <input type="password"
                       name="current_password"
                       class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-300">

                @error('current_password')
                    <p class="text-sm text-red-500 mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Password Baru --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Password Baru
                </label>

                <input type="password"
                       name="password"
                       class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-300">

                @error('password')
                    <p class="text-sm text-red-500 mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Konfirmasi Password --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Konfirmasi Password Baru
                </label>

                <input type="password"
                       name="password_confirmation"
                       class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-300">

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

                    Simpan Password

                </button>

            </div>

        </form>

    </div>

</div>
@endsection