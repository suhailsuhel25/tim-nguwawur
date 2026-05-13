{{-- resources/views/lecturer/mentorship_sessions/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Jadwalkan Sesi Bimbingan - Simagang')
@section('header_title', 'Jadwalkan Sesi Bimbingan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('lecturer.mentorship_sessions.index') }}"
           class="h-8 w-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Jadwalkan Sesi Bimbingan</h2>
            <p class="text-sm text-slate-500">Buat jadwal sesi bimbingan baru dengan mahasiswa bimbingan Anda.</p>
        </div>
    </div>

    {{-- Error Messages --}}
    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada input:</h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Form Card --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <form action="{{ route('lecturer.mentorship_sessions.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                {{-- Pilih Mahasiswa --}}
                <div>
                    <label for="internship_id" class="block text-sm font-medium text-slate-700 mb-1">
                        Mahasiswa Bimbingan <span class="text-red-500">*</span>
                    </label>
                    <select name="internship_id" id="internship_id"
                            class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                   {{ $errors->has('internship_id') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                        <option value="">-- Pilih Mahasiswa --</option>
                        @foreach($internships as $internship)
                            <option value="{{ $internship->id }}" {{ old('internship_id') == $internship->id ? 'selected' : '' }}>
                                {{ $internship->student->user->name }} ({{ $internship->student->user->username }}) — {{ $internship->company->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('internship_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                    @if($internships->isEmpty())
                        <p class="mt-2 text-xs text-amber-600 bg-amber-50 border border-amber-100 rounded-lg p-3">
                            <strong>Catatan:</strong> Anda belum memiliki mahasiswa bimbingan. Setujui pengajuan magang terlebih dahulu.
                        </p>
                    @endif
                </div>

                {{-- Tanggal & Jam --}}
                <div>
                    <label for="date" class="block text-sm font-medium text-slate-700 mb-1">
                        Tanggal & Jam <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" name="date" id="date" value="{{ old('date') }}"
                           class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                  {{ $errors->has('date') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                    @error('date')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Topik --}}
                <div>
                    <label for="topic" class="block text-sm font-medium text-slate-700 mb-1">
                        Topik Bimbingan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="topic" id="topic" rows="3"
                              placeholder="Jelaskan topik atau agenda bimbingan..."
                              class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                     {{ $errors->has('topic') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">{{ old('topic') }}</textarea>
                    @error('topic')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-3 mt-8 pt-4 border-t border-slate-100">
                <button type="submit"
                        class="px-6 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors shadow-sm">
                    Jadwalkan Sesi
                </button>
                <a href="{{ route('lecturer.mentorship_sessions.index') }}"
                   class="px-6 py-2 border border-slate-200 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
