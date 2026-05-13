{{-- resources/views/student/internships/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Form Pengajuan Magang - Simagang')
@section('header_title', 'Form Pengajuan Magang')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('student.internships.index') }}"
           class="h-8 w-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Form Pengajuan Magang</h2>
            <p class="text-sm text-slate-500">Isi data dan unggah dokumen persyaratan dengan lengkap.</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <form action="{{ route('student.internships.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                
                {{-- Data Magang --}}
                <div>
                    <h3 class="text-sm font-bold text-slate-800 border-b border-slate-200 pb-2 mb-4">Informasi Magang</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label for="company_id" class="block text-sm font-medium text-slate-700 mb-1">
                                Perusahaan <span class="text-red-500">*</span>
                            </label>
                            <select name="company_id" id="company_id"
                                    class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                           {{ $errors->has('company_id') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                                <option value="">-- Pilih Perusahaan --</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }} ({{ $company->industry }})
                                    </option>
                                @endforeach
                            </select>
                            @error('company_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="internship_period_id" class="block text-sm font-medium text-slate-700 mb-1">
                                Periode Magang <span class="text-red-500">*</span>
                            </label>
                            <select name="internship_period_id" id="internship_period_id"
                                    class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                           {{ $errors->has('internship_period_id') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                                <option value="">-- Pilih Periode Aktif --</option>
                                @foreach($activePeriods as $period)
                                    <option value="{{ $period->id }}" {{ old('internship_period_id') == $period->id ? 'selected' : '' }}>
                                        {{ $period->name }} ({{ \Carbon\Carbon::parse($period->start_date)->format('M Y') }} - {{ \Carbon\Carbon::parse($period->end_date)->format('M Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('internship_period_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="start_date" class="block text-sm font-medium text-slate-700 mb-1">
                                Tanggal Mulai <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                   class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                          {{ $errors->has('start_date') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                            @error('start_date')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-slate-700 mb-1">
                                Tanggal Selesai <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                   class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                          {{ $errors->has('end_date') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                            @error('end_date')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Dokumen --}}
                <div>
                    <h3 class="text-sm font-bold text-slate-800 border-b border-slate-200 pb-2 mb-4">Dokumen Persyaratan (PDF, Maks 2MB)</h3>
                    <div class="space-y-4">
                        
                        <div>
                            <label for="cover_letter" class="block text-sm font-medium text-slate-700 mb-1">
                                Surat Pengantar (Cover Letter) <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="cover_letter" id="cover_letter" accept="application/pdf"
                                   class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-primary/10 file:text-primary hover:file:bg-primary/20
                                          {{ $errors->has('cover_letter') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                            @error('cover_letter')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="cv" class="block text-sm font-medium text-slate-700 mb-1">
                                Curriculum Vitae <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="cv" id="cv" accept="application/pdf"
                                   class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-primary/10 file:text-primary hover:file:bg-primary/20
                                          {{ $errors->has('cv') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                            @error('cv')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="proposal" class="block text-sm font-medium text-slate-700 mb-1">
                                Proposal Magang <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="proposal" id="proposal" accept="application/pdf"
                                   class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-primary/10 file:text-primary hover:file:bg-primary/20
                                          {{ $errors->has('proposal') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                            @error('proposal')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-3 mt-8 pt-4 border-t border-slate-100">
                <button type="submit" 
                        class="px-6 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors shadow-sm">
                    Kirim Pengajuan
                </button>
                <a href="{{ route('student.internships.index') }}"
                   class="px-6 py-2 border border-slate-200 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection