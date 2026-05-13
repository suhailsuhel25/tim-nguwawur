{{-- resources/views/lecturer/mentorship_sessions/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Sesi Bimbingan - Simagang')
@section('header_title', 'Detail Sesi Bimbingan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{ showCancelModal: false, showCompleteModal: false }">

    {{-- Page Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('lecturer.mentorship_sessions.index') }}"
           class="h-8 w-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Detail Sesi Bimbingan</h2>
            <p class="text-sm text-slate-500">Sesi dengan <span class="font-medium text-slate-700">{{ $mentorshipSession->internship->student->user->name }}</span></p>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-lg shadow-sm">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Column: Main Info --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Session Info --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Informasi Sesi</h3>
                <div class="space-y-4 text-sm">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                        <div class="font-medium text-slate-500">Mahasiswa</div>
                        <div class="sm:col-span-2 font-medium text-slate-800">
                            {{ $mentorshipSession->internship->student->user->name }}
                            <span class="text-xs text-slate-500 font-normal">({{ $mentorshipSession->internship->student->user->username }})</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                        <div class="font-medium text-slate-500">Perusahaan</div>
                        <div class="sm:col-span-2 text-slate-800">{{ $mentorshipSession->internship->company->name }}</div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                        <div class="font-medium text-slate-500">Jadwal</div>
                        <div class="sm:col-span-2 text-slate-800 font-medium">
                            {{ \Carbon\Carbon::parse($mentorshipSession->date)->translatedFormat('l, d F Y — H:i') }} WIB
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                        <div class="font-medium text-slate-500">Status</div>
                        <div class="sm:col-span-2">
                            @if($mentorshipSession->status === 'scheduled')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Terjadwal
                                </span>
                            @elseif($mentorshipSession->status === 'completed')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai
                                </span>
                            @elseif($mentorshipSession->status === 'canceled')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Dibatalkan
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Topic & Notes --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Topik & Catatan</h3>
                <div class="space-y-5 text-sm">
                    <div>
                        <span class="block font-semibold text-slate-800 mb-1">Topik Bimbingan</span>
                        <div class="bg-slate-50 p-4 rounded-lg border border-slate-100 whitespace-pre-wrap text-slate-700">{{ $mentorshipSession->topic }}</div>
                    </div>

                    @if($mentorshipSession->lecturer_notes)
                    <div>
                        <span class="block font-semibold text-slate-800 mb-1">Catatan Dosen</span>
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 whitespace-pre-wrap text-slate-700">{{ $mentorshipSession->lecturer_notes }}</div>
                    </div>
                    @endif

                    @if($mentorshipSession->feedback)
                    <div>
                        <span class="block font-semibold text-slate-800 mb-1">Feedback untuk Mahasiswa</span>
                        <div class="bg-emerald-50 p-4 rounded-lg border border-emerald-100 whitespace-pre-wrap text-slate-700">{{ $mentorshipSession->feedback }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column: Actions --}}
        <div class="space-y-6">
            {{-- Quick Actions --}}
            @if($mentorshipSession->status === 'scheduled')
            <div class="bg-white rounded-xl border border-primary/20 shadow-sm p-6 shadow-primary/5">
                <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Aksi</h3>
                <div class="space-y-3">
                    <a href="{{ route('lecturer.mentorship_sessions.edit', $mentorshipSession) }}"
                       class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-slate-800 text-white rounded-lg text-sm font-medium hover:bg-slate-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Sesi
                    </a>
                    <button @click="showCompleteModal = true"
                            class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Tandai Selesai
                    </button>
                    <button @click="showCancelModal = true"
                            class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 border border-red-200 text-red-600 rounded-lg text-sm font-medium hover:bg-red-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batalkan Sesi
                    </button>
                </div>
            </div>
            @elseif($mentorshipSession->status === 'completed')
            <div class="bg-white rounded-xl border border-emerald-200 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-emerald-800">Sesi Selesai</p>
                        <p class="text-xs text-slate-500">Sesi bimbingan ini telah selesai dilaksanakan.</p>
                    </div>
                </div>
                <a href="{{ route('lecturer.mentorship_sessions.edit', $mentorshipSession) }}"
                   class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 border border-slate-200 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors mt-2">
                    Edit Catatan & Feedback
                </a>
            </div>
            @else
            <div class="bg-white rounded-xl border border-red-200 shadow-sm p-6">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-red-800">Sesi Dibatalkan</p>
                        <p class="text-xs text-slate-500">Sesi ini telah dibatalkan.</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Complete Modal --}}
    <div x-show="showCompleteModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm" style="display:none;">
        <div x-show="showCompleteModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             class="bg-white rounded-xl shadow-xl p-6 max-w-lg w-full mx-4" @click.outside="showCompleteModal = false">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-slate-800">Tandai Sesi Selesai</h3>
                    <p class="text-sm text-slate-500">Isi catatan dan feedback untuk mahasiswa.</p>
                </div>
            </div>

            <form action="{{ route('lecturer.mentorship_sessions.complete', $mentorshipSession) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="lecturer_notes" class="block text-sm font-medium text-slate-700 mb-1">Catatan Dosen</label>
                    <textarea name="lecturer_notes" id="lecturer_notes" rows="3" placeholder="Catatan internal mengenai sesi ini..."
                              class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">{{ $mentorshipSession->lecturer_notes }}</textarea>
                </div>
                <div>
                    <label for="feedback" class="block text-sm font-medium text-slate-700 mb-1">Feedback untuk Mahasiswa</label>
                    <textarea name="feedback" id="feedback" rows="3" placeholder="Feedback, saran, atau tugas untuk mahasiswa..."
                              class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">{{ $mentorshipSession->feedback }}</textarea>
                </div>
                <div class="flex gap-3 justify-end pt-2">
                    <button type="button" @click="showCompleteModal = false"
                            class="px-4 py-2 border border-slate-200 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Batal</button>
                    <button type="submit"
                            class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors">Tandai Selesai</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Cancel Modal --}}
    <div x-show="showCancelModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm" style="display:none;">
        <div x-show="showCancelModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             class="bg-white rounded-xl shadow-xl p-6 max-w-sm w-full mx-4" @click.outside="showCancelModal = false">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-slate-800">Batalkan Sesi</h3>
                    <p class="text-sm text-slate-500">Mahasiswa akan menerima notifikasi pembatalan.</p>
                </div>
            </div>
            <p class="text-sm text-slate-600 mb-5">Apakah Anda yakin ingin membatalkan sesi bimbingan ini?</p>
            <div class="flex gap-3 justify-end">
                <button @click="showCancelModal = false"
                        class="px-4 py-2 border border-slate-200 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Kembali</button>
                <form action="{{ route('lecturer.mentorship_sessions.cancel', $mentorshipSession) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">Ya, Batalkan</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
