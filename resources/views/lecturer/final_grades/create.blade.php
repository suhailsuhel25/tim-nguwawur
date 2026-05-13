{{-- resources/views/lecturer/final_grades/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Input Nilai Akhir - Simagang')
@section('header_title', 'Input Nilai Akhir')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('lecturer.final_grades.index') }}"
           class="h-8 w-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Input Nilai Akhir</h2>
            <p class="text-sm text-slate-500">Berikan penilaian akhir untuk mahasiswa bimbingan Anda.</p>
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
                <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan:</h3>
                <ul class="mt-2 text-sm text-red-700 list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    {{-- Form --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6"
         x-data="{
            report: {{ old('report_grade', 0) }},
            presentation: {{ old('presentation_grade', 0) }},
            attitude: {{ old('attitude_grade', 0) }},
            get finalGrade() {
                return ((parseFloat(this.report) || 0) * 0.4 + (parseFloat(this.presentation) || 0) * 0.3 + (parseFloat(this.attitude) || 0) * 0.3).toFixed(1);
            },
            get letterGrade() {
                let g = parseFloat(this.finalGrade);
                if (g >= 85) return 'A';
                if (g >= 80) return 'A-';
                if (g >= 75) return 'B+';
                if (g >= 70) return 'B';
                if (g >= 65) return 'B-';
                if (g >= 60) return 'C+';
                if (g >= 55) return 'C';
                if (g >= 50) return 'D';
                return 'E';
            },
            get gradeColor() {
                let g = parseFloat(this.finalGrade);
                if (g >= 75) return 'text-emerald-600';
                if (g >= 55) return 'text-amber-600';
                return 'text-red-600';
            }
         }">
        <form action="{{ route('lecturer.final_grades.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                {{-- Pilih Mahasiswa --}}
                <div>
                    <label for="internship_id" class="block text-sm font-medium text-slate-700 mb-1">
                        Mahasiswa <span class="text-red-500">*</span>
                    </label>
                    <select name="internship_id" id="internship_id"
                            class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary {{ $errors->has('internship_id') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
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
                            <strong>Info:</strong> Semua mahasiswa bimbingan sudah memiliki penilaian akhir.
                        </p>
                    @endif
                </div>

                {{-- Grade Inputs --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="report_grade" class="block text-sm font-medium text-slate-700 mb-1">
                            Nilai Laporan (40%) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="report_grade" id="report_grade" min="0" max="100" step="0.1"
                               x-model="report" value="{{ old('report_grade') }}"
                               class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary {{ $errors->has('report_grade') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}"
                               placeholder="0 - 100">
                        @error('report_grade')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="presentation_grade" class="block text-sm font-medium text-slate-700 mb-1">
                            Nilai Presentasi (30%) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="presentation_grade" id="presentation_grade" min="0" max="100" step="0.1"
                               x-model="presentation" value="{{ old('presentation_grade') }}"
                               class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary {{ $errors->has('presentation_grade') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}"
                               placeholder="0 - 100">
                        @error('presentation_grade')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="attitude_grade" class="block text-sm font-medium text-slate-700 mb-1">
                            Nilai Sikap (30%) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="attitude_grade" id="attitude_grade" min="0" max="100" step="0.1"
                               x-model="attitude" value="{{ old('attitude_grade') }}"
                               class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary {{ $errors->has('attitude_grade') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}"
                               placeholder="0 - 100">
                        @error('attitude_grade')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Live Preview --}}
                <div class="bg-slate-50 rounded-xl border border-slate-200 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Nilai Akhir (Preview)</span>
                            <p class="text-sm text-slate-500 mt-0.5">Laporan 40% + Presentasi 30% + Sikap 30%</p>
                        </div>
                        <div class="text-right">
                            <span class="text-3xl font-bold tabular-nums" :class="gradeColor" x-text="finalGrade"></span>
                            <span class="block text-lg font-bold" :class="gradeColor" x-text="letterGrade"></span>
                        </div>
                    </div>
                </div>

                {{-- Notes --}}
                <div>
                    <label for="notes" class="block text-sm font-medium text-slate-700 mb-1">Catatan</label>
                    <textarea name="notes" id="notes" rows="3"
                              placeholder="Catatan tambahan mengenai penilaian (opsional)..."
                              class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">{{ old('notes') }}</textarea>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 mt-8 pt-4 border-t border-slate-100">
                <button type="submit"
                        class="px-6 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors shadow-sm">
                    Simpan Nilai
                </button>
                <a href="{{ route('lecturer.final_grades.index') }}"
                   class="px-6 py-2 border border-slate-200 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
