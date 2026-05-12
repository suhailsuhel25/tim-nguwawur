{{-- resources/views/lecturer/internships/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Pengajuan Magang - Simagang')
@section('header_title', 'Detail Pengajuan Magang')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('lecturer.internships.index') }}"
           class="h-8 w-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Detail Pengajuan Magang</h2>
            <p class="text-sm text-slate-500">Informasi pengajuan magang dari <span class="font-medium text-slate-700">{{ $internship->student->user->name }}</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Kolom Kiri: Info Utama --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Informasi Mahasiswa & Magang</h3>
                
                <div class="space-y-4 text-sm">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                        <div class="font-medium text-slate-500">Nama Mahasiswa</div>
                        <div class="sm:col-span-2 font-medium text-slate-800">{{ $internship->student->user->name }} ({{ $internship->student->user->username }})</div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                        <div class="font-medium text-slate-500">Program Studi</div>
                        <div class="sm:col-span-2 text-slate-800">{{ $internship->student->study_program }} - Angkatan {{ $internship->student->cohort_year }}</div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                        <div class="font-medium text-slate-500">No. HP Mahasiswa</div>
                        <div class="sm:col-span-2 text-slate-800">{{ $internship->student->phone_number ?? '-' }}</div>
                    </div>
                    
                    <hr class="border-slate-100">

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                        <div class="font-medium text-slate-500">Perusahaan Mitra</div>
                        <div class="sm:col-span-2 font-medium text-slate-800">
                            {{ $internship->company->name }}<br>
                            <span class="text-xs text-slate-500 font-normal">{{ $internship->company->address }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                        <div class="font-medium text-slate-500">Waktu Pelaksanaan</div>
                        <div class="sm:col-span-2 text-slate-800">
                            {{ \Carbon\Carbon::parse($internship->start_date)->translatedFormat('d M Y') }} s/d {{ \Carbon\Carbon::parse($internship->end_date)->translatedFormat('d M Y') }}
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                        <div class="font-medium text-slate-500">Status Saat Ini</div>
                        <div class="sm:col-span-2">
                            @if($internship->status === 'submitted')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800"> Menunggu Persetujuan </span>
                            @elseif($internship->status === 'approved')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"> Disetujui </span>
                            @elseif($internship->status === 'rejected')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800"> Ditolak </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dokumen --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Dokumen Lampiran</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @forelse($internship->documents as $document)
                        <a href="{{ Storage::url($document->file_path) }}" target="_blank"
                           class="flex flex-col items-center justify-center p-4 border border-slate-200 rounded-lg hover:bg-slate-50 hover:border-primary transition-colors text-center group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400 group-hover:text-primary mb-2 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <span class="text-xs font-medium text-slate-700 capitalize group-hover:text-primary transition-colors">
                                {{ str_replace('_', ' ', $document->document_type) }}
                            </span>
                            <span class="text-[10px] text-slate-400 mt-1 line-clamp-1 w-full" title="{{ $document->file_name }}">{{ $document->file_name }}</span>
                        </a>
                    @empty
                        <div class="col-span-3 text-center text-sm text-slate-500 py-4">Belum ada dokumen yang diunggah.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Action Form --}}
        <div>
            @if($internship->status === 'submitted')
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sticky top-6"
                     x-data="{ status: 'approved' }">
                    <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Tinjau Pengajuan</h3>
                    
                    <form action="{{ route('lecturer.internships.update_status', $internship) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Keputusan Review</label>
                            <div class="flex flex-col gap-2">
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer transition-colors"
                                       :class="status === 'approved' ? 'bg-green-50 border-green-200' : 'bg-white border-slate-200 hover:bg-slate-50'">
                                    <input type="radio" name="status" value="approved" x-model="status" class="w-4 h-4 text-green-600 focus:ring-green-500">
                                    <span class="ml-3 text-sm font-medium" :class="status === 'approved' ? 'text-green-800' : 'text-slate-700'">Setujui & Bimbing</span>
                                </label>
                                
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer transition-colors"
                                       :class="status === 'rejected' ? 'bg-red-50 border-red-200' : 'bg-white border-slate-200 hover:bg-slate-50'">
                                    <input type="radio" name="status" value="rejected" x-model="status" class="w-4 h-4 text-red-600 focus:ring-red-500">
                                    <span class="ml-3 text-sm font-medium" :class="status === 'rejected' ? 'text-red-800' : 'text-slate-700'">Tolak Pengajuan</span>
                                </label>
                            </div>
                            @error('status')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div x-show="status === 'rejected'" x-transition>
                            <label for="rejection_note" class="block text-sm font-medium text-slate-700 mb-1">
                                Catatan Penolakan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="rejection_note" id="rejection_note" rows="3"
                                      placeholder="Berikan alasan mengapa pengajuan ini ditolak..."
                                      class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-500">{{ old('rejection_note') }}</textarea>
                            @error('rejection_note')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" 
                                class="w-full py-2.5 rounded-lg text-sm font-medium text-white transition-colors shadow-sm"
                                :class="status === 'approved' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700'">
                            Simpan Keputusan Review
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Status Review</h3>
                    
                    @if($internship->status === 'approved')
                        <div class="flex items-center gap-3 mb-3">
                            <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-green-800">Disetujui</p>
                                <p class="text-xs text-slate-500">Anda adalah dosen pembimbing untuk magang ini.</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-start gap-3 mb-3">
                            <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-red-800 mb-1">Ditolak</p>
                                <div class="bg-red-50 border border-red-100 rounded p-3 text-xs text-red-700">
                                    <span class="font-semibold block mb-1">Catatan:</span>
                                    {{ $internship->rejection_note }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>

    </div>
</div>
@endsection