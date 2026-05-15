{{-- resources/views/student/internships/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Pendaftaran Magang - Simagang')
@section('header_title', 'Sistem Monitoring Magang')

@section('content')
<div x-data="internshipForm()" class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Left Column: Main Form Area --}}
    <div class="lg:col-span-2 space-y-6">
        
        {{-- Header Area --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 mb-2">Halaman Pendaftaran Magang</h1>
                <p class="text-sm text-slate-500 max-w-lg leading-relaxed">
                    Lengkapi data diri dan unggah dokumen persyaratan untuk memulai program magang/PKL.
                </p>
            </div>
            
            <div class="shrink-0 bg-blue-50 border border-blue-100 rounded-xl p-3 flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-xs text-blue-600 font-medium">Informasi</p>
                    <p class="text-sm text-blue-800 font-bold mt-0.5">Pengajuan Magang Baru</p>
                </div>
            </div>
        </div>

        {{-- Stepper & Form Container --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            
            {{-- Horizontal Stepper --}}
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <div class="flex items-center justify-between relative">
                    <!-- Line connecting steps -->
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-slate-200 z-0 hidden sm:block rounded-full"></div>
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-blue-600 z-0 hidden sm:block rounded-full transition-all duration-300"
                         :style="'width: ' + ((step - 1) / 2 * 100) + '%'"></div>

                    <!-- Step 1 -->
                    <div class="relative z-10 flex flex-col items-center gap-2">
                        <div class="h-10 w-10 rounded-full flex items-center justify-center font-bold text-sm transition-colors border-2"
                             :class="step >= 1 ? 'bg-blue-600 border-blue-600 text-white shadow-md shadow-blue-200' : 'bg-white border-slate-300 text-slate-500'">
                            <span x-show="step === 1">1</span>
                            <svg x-show="step > 1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" style="display: none;"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span class="text-xs font-semibold" :class="step >= 1 ? 'text-blue-700' : 'text-slate-500'">Data Magang</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative z-10 flex flex-col items-center gap-2">
                        <div class="h-10 w-10 rounded-full flex items-center justify-center font-bold text-sm transition-colors border-2"
                             :class="step >= 2 ? 'bg-blue-600 border-blue-600 text-white shadow-md shadow-blue-200' : 'bg-white border-slate-300 text-slate-500'">
                            <span x-show="step <= 2">2</span>
                            <svg x-show="step > 2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" style="display: none;"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span class="text-xs font-semibold" :class="step >= 2 ? 'text-blue-700' : 'text-slate-500'">Unggah Dokumen</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative z-10 flex flex-col items-center gap-2">
                        <div class="h-10 w-10 rounded-full flex items-center justify-center font-bold text-sm transition-colors border-2"
                             :class="step >= 3 ? 'bg-blue-600 border-blue-600 text-white shadow-md shadow-blue-200' : 'bg-white border-slate-300 text-slate-500'">
                            <span>3</span>
                        </div>
                        <span class="text-xs font-semibold" :class="step >= 3 ? 'text-blue-700' : 'text-slate-500'">Konfirmasi</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('student.internships.store') }}" method="POST" enctype="multipart/form-data" id="registrationForm">
                @csrf
                <div class="p-8">
                    
                    {{-- Step 1: Data Magang --}}
                    <div x-show="step === 1" x-transition.opacity.duration.300ms>
                        <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" /></svg>
                            Informasi Pemilihan Mitra
                        </h3>
                        
                        <div class="space-y-5">
                            <div>
                                <label for="company_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Mitra Perusahaan <span class="text-red-500">*</span>
                                </label>
                                <select name="company_id" id="company_id" required
                                        class="w-full px-4 py-3 border rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 {{ $errors->has('company_id') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                                    <option value="">-- Pilih Perusahaan Tempat Magang --</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }} ({{ $company->industry }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="internship_period_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Periode Magang <span class="text-red-500">*</span>
                                </label>
                                <select name="internship_period_id" id="internship_period_id" required
                                        class="w-full px-4 py-3 border rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 {{ $errors->has('internship_period_id') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                                    <option value="">-- Pilih Periode Akademik --</option>
                                    @foreach($activePeriods as $period)
                                        <option value="{{ $period->id }}" {{ old('internship_period_id') == $period->id ? 'selected' : '' }}>
                                            {{ $period->name }} ({{ \Carbon\Carbon::parse($period->start_date)->format('M Y') }} - {{ \Carbon\Carbon::parse($period->end_date)->format('M Y') }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('internship_period_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="start_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                        Tanggal Mulai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                                           class="w-full px-4 py-3 border rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 {{ $errors->has('start_date') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                                    @error('start_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="end_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                        Tanggal Selesai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                                           class="w-full px-4 py-3 border rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 {{ $errors->has('end_date') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                                    @error('end_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Step 2: Dokumen Persyaratan --}}
                    <div x-show="step === 2" style="display: none;" x-transition.opacity.duration.300ms>
                        <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                            Dokumen Persyaratan
                        </h3>

                        <div class="space-y-6">
                            
                            {{-- CV Upload (Drag & Drop UI) --}}
                            <div class="border-b border-slate-100 pb-6">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Curriculum Vitae (CV) <span class="text-red-500">*</span></label>
                                
                                <input type="file" name="cv" id="cv" accept="application/pdf" class="hidden" @change="handleFileChange($event, 'cv')">
                                
                                <template x-if="!files.cv">
                                    <div class="border-2 border-dashed border-blue-200 bg-blue-50/30 rounded-xl p-8 text-center hover:bg-blue-50 transition-colors cursor-pointer"
                                         @click="document.getElementById('cv').click()"
                                         @dragover.prevent="$el.classList.add('bg-blue-100')"
                                         @dragleave.prevent="$el.classList.remove('bg-blue-100')"
                                         @drop.prevent="$el.classList.remove('bg-blue-100'); handleFileDrop($event, 'cv')">
                                        <div class="mx-auto w-12 h-12 bg-white rounded-lg border border-blue-100 flex items-center justify-center text-blue-500 mb-3 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                                        </div>
                                        <p class="text-sm font-semibold text-slate-700">Klik untuk mengunggah atau drag and drop</p>
                                        <p class="text-xs text-slate-500 mt-1">PDF (Max. 2MB)</p>
                                        @error('cv') <p class="mt-2 text-xs text-red-600 bg-red-100 p-2 rounded">{{ $message }}</p> @enderror
                                    </div>
                                </template>

                                <template x-if="files.cv">
                                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="h-10 w-10 bg-white rounded shadow-sm flex items-center justify-center text-blue-600 border border-blue-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-800" x-text="files.cv.name"></p>
                                                <p class="text-xs text-slate-500 mt-0.5"><span x-text="files.cv.size"></span> &bull; <span class="text-emerald-600">Terpilih</span></p>
                                            </div>
                                        </div>
                                        <button type="button" @click="removeFile('cv')" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>

                            {{-- Cover Letter Upload --}}
                            <div class="border-b border-slate-100 pb-6">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Surat Pengantar (Cover Letter) <span class="text-red-500">*</span></label>
                                
                                <input type="file" name="cover_letter" id="cover_letter" accept="application/pdf" class="hidden" @change="handleFileChange($event, 'cover_letter')">
                                
                                <template x-if="!files.cover_letter">
                                    <div class="border border-slate-200 bg-white rounded-xl p-4 flex items-center justify-between hover:border-blue-400 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                            <span class="text-sm text-slate-500">Pilih file PDF...</span>
                                        </div>
                                        <button type="button" @click="document.getElementById('cover_letter').click()" class="px-4 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors">
                                            Pilih File
                                        </button>
                                    </div>
                                </template>
                                @error('cover_letter') <p x-show="!files.cover_letter" class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror

                                <template x-if="files.cover_letter">
                                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="h-10 w-10 bg-white rounded shadow-sm flex items-center justify-center text-blue-600 border border-blue-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-800" x-text="files.cover_letter.name"></p>
                                                <p class="text-xs text-slate-500 mt-0.5"><span x-text="files.cover_letter.size"></span> &bull; <span class="text-emerald-600">Terpilih</span></p>
                                            </div>
                                        </div>
                                        <button type="button" @click="removeFile('cover_letter')" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>

                            {{-- Proposal Upload --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Proposal Magang <span class="text-red-500">*</span></label>
                                
                                <input type="file" name="proposal" id="proposal" accept="application/pdf" class="hidden" @change="handleFileChange($event, 'proposal')">
                                
                                <template x-if="!files.proposal">
                                    <div class="border border-slate-200 bg-white rounded-xl p-4 flex items-center justify-between hover:border-blue-400 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                            <span class="text-sm text-slate-500">Pilih file PDF...</span>
                                        </div>
                                        <button type="button" @click="document.getElementById('proposal').click()" class="px-4 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors">
                                            Pilih File
                                        </button>
                                    </div>
                                </template>
                                @error('proposal') <p x-show="!files.proposal" class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror

                                <template x-if="files.proposal">
                                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="h-10 w-10 bg-white rounded shadow-sm flex items-center justify-center text-blue-600 border border-blue-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-800" x-text="files.proposal.name"></p>
                                                <p class="text-xs text-slate-500 mt-0.5"><span x-text="files.proposal.size"></span> &bull; <span class="text-emerald-600">Terpilih</span></p>
                                            </div>
                                        </div>
                                        <button type="button" @click="removeFile('proposal')" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>

                        </div>
                    </div>

                    {{-- Step 3: Konfirmasi --}}
                    <div x-show="step === 3" style="display: none;" x-transition.opacity.duration.300ms>
                        <div class="text-center py-8">
                            <div class="h-20 w-20 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 mb-2">Konfirmasi Pengajuan</h3>
                            <p class="text-slate-500 max-w-md mx-auto mb-8">Pastikan semua data dan dokumen telah sesuai. Setelah dikirim, pengajuan akan direview oleh Koordinator PKL/Dosen.</p>
                            
                            <div class="bg-slate-50 rounded-xl p-4 text-left border border-slate-200 max-w-md mx-auto space-y-2 mb-8">
                                <div class="flex items-center gap-2 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                    <span class="text-slate-700">Data Mitra Terisi</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                    <span class="text-slate-700">Periode Terpilih</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                    <span class="text-slate-700">3 Dokumen Persyaratan Siap Diunggah</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons Navigation --}}
                    <div class="flex items-center justify-between pt-6 mt-6 border-t border-slate-100">
                        <div>
                            <button type="button" x-show="step > 1" @click="prevStep()" class="flex items-center gap-2 px-6 py-2.5 border border-slate-300 text-slate-700 font-medium rounded-xl hover:bg-slate-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                                Kembali
                            </button>
                            <a href="{{ route('student.internships.index') }}" x-show="step === 1" class="flex items-center gap-2 px-6 py-2.5 border border-slate-300 text-slate-700 font-medium rounded-xl hover:bg-slate-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                                Kembali ke Daftar
                            </a>
                        </div>
                        
                        <div>
                            <button type="button" x-show="step < 3" @click="nextStep()" class="flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl font-medium transition-colors shadow-sm">
                                Simpan & Lanjutkan
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </button>
                            
                            <button type="submit" x-show="step === 3" style="display: none;" class="flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white px-8 py-2.5 rounded-xl font-bold transition-colors shadow-sm shadow-blue-200">
                                Kirim Pengajuan
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Right Column: Sidebars --}}
    <div class="space-y-6">
        
        {{-- Checklist Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Checklist Pendaftaran</h3>
            
            <div class="space-y-5">
                {{-- Step 1 Indicator --}}
                <div class="flex gap-4">
                    <div class="shrink-0 mt-0.5">
                        <!-- Done State -->
                        <div x-show="step > 1" class="h-5 w-5 rounded-full bg-emerald-500 text-white flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <!-- Active State -->
                        <div x-show="step === 1" class="h-5 w-5 rounded-full border-4 border-blue-100 flex items-center justify-center relative">
                            <div class="h-2.5 w-2.5 rounded-full bg-blue-600"></div>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800">Informasi Magang</h4>
                        <p class="text-xs text-slate-500 mt-1" x-text="step > 1 ? 'Data mitra telah diisi' : 'Sedang dikerjakan (Step 1)'"></p>
                    </div>
                </div>

                {{-- Step 2 Indicator --}}
                <div class="flex gap-4">
                    <div class="shrink-0 mt-0.5">
                        <div x-show="step > 2" style="display: none;" class="h-5 w-5 rounded-full bg-emerald-500 text-white flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <div x-show="step === 2" style="display: none;" class="h-5 w-5 rounded-full border-4 border-blue-100 flex items-center justify-center relative">
                            <div class="h-2.5 w-2.5 rounded-full bg-blue-600"></div>
                        </div>
                        <div x-show="step < 2" class="h-5 w-5 rounded-full border-2 border-slate-200"></div>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold" :class="step >= 2 ? 'text-slate-800' : 'text-slate-400'">Dokumen Persyaratan</h4>
                        <p class="text-xs mt-1" :class="step >= 2 ? 'text-slate-500' : 'text-slate-400'" 
                           x-text="step > 2 ? '3 Dokumen siap' : (step === 2 ? 'Sedang dikerjakan (Step 2)' : 'Belum dimulai')"></p>
                    </div>
                </div>

                {{-- Step 3 Indicator --}}
                <div class="flex gap-4">
                    <div class="shrink-0 mt-0.5">
                        <div x-show="step === 3" style="display: none;" class="h-5 w-5 rounded-full border-4 border-blue-100 flex items-center justify-center relative">
                            <div class="h-2.5 w-2.5 rounded-full bg-blue-600"></div>
                        </div>
                        <div x-show="step < 3" class="h-5 w-5 rounded-full border-2 border-slate-200"></div>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold" :class="step === 3 ? 'text-slate-800' : 'text-slate-400'">Konfirmasi Akhir</h4>
                        <p class="text-xs mt-1" :class="step === 3 ? 'text-slate-500' : 'text-slate-400'" 
                           x-text="step === 3 ? 'Sedang dikerjakan (Step 3)' : 'Belum dimulai'"></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Butuh Bantuan Card --}}
        <div class="bg-slate-50 rounded-2xl border border-slate-200 shadow-sm p-6 relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-3">
                    <div class="h-8 w-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="font-bold text-slate-800">Butuh Bantuan?</h3>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed mb-4">
                    Jika Anda mengalami kendala saat mengisi form atau mengunggah dokumen, silakan hubungi Helpdesk IT atau Koordinator PKL.
                </p>
                <div class="space-y-3">
                    <a href="mailto:helpdesk@universitas.ac.id" class="flex items-center gap-2 text-sm text-blue-600 font-medium hover:underline">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        helpdesk@universitas.ac.id
                    </a>
                    <div class="flex items-center gap-2 text-sm text-blue-600 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        (021) 123-4567-89
                    </div>
                </div>
            </div>
            {{-- Decorative pattern --}}
            <svg class="absolute right-0 bottom-0 text-slate-200/50 w-32 h-32 -mb-10 -mr-10 transform -rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-11v6h2v-6h-2zm0-4v2h2V7h-2z"/></svg>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('internshipForm', () => ({
        step: 1,
        files: {
            cv: null,
            cover_letter: null,
            proposal: null
        },
        
        handleFileChange(event, type) {
            const file = event.target.files[0];
            if (file) {
                this.files[type] = {
                    name: file.name,
                    size: (file.size / (1024 * 1024)).toFixed(2) + ' MB'
                };
            } else {
                this.files[type] = null;
            }
        },
        
        handleFileDrop(event, type) {
            const file = event.dataTransfer.files[0];
            if (file && file.type === 'application/pdf') {
                // Update Alpine state
                this.files[type] = {
                    name: file.name,
                    size: (file.size / (1024 * 1024)).toFixed(2) + ' MB'
                };
                
                // Update file input element via DataTransfer object
                const input = document.getElementById(type);
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
            } else {
                alert('Hanya file PDF yang diperbolehkan.');
            }
        },
        
        removeFile(type) {
            this.files[type] = null;
            document.getElementById(type).value = '';
        },
        
        nextStep() {
            // Basic client side validation before moving next step
            if (this.step === 1) {
                const form = document.getElementById('registrationForm');
                const requiredFields = ['company_id', 'internship_period_id', 'start_date', 'end_date'];
                let isValid = true;
                
                for (const fieldId of requiredFields) {
                    if (!document.getElementById(fieldId).value) {
                        isValid = false;
                        document.getElementById(fieldId).classList.add('border-red-400', 'bg-red-50');
                    } else {
                        document.getElementById(fieldId).classList.remove('border-red-400', 'bg-red-50');
                    }
                }
                
                if (!isValid) {
                    alert('Harap lengkapi semua field yang wajib diisi pada step ini.');
                    return;
                }
            }
            
            if (this.step === 2) {
                if (!this.files.cv || !this.files.cover_letter || !this.files.proposal) {
                    alert('Harap unggah ketiga dokumen persyaratan terlebih dahulu.');
                    return;
                }
            }

            if (this.step < 3) {
                this.step++;
                window.scrollTo({top: 0, behavior: 'smooth'});
            }
        },
        
        prevStep() {
            if (this.step > 1) {
                this.step--;
                window.scrollTo({top: 0, behavior: 'smooth'});
            }
        }
    }))
})
</script>
@endsection