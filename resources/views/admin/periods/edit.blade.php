{{-- resources/views/admin/periods/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Periode Magang - Simagang')
@section('header_title', 'Edit Periode Magang')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.periods.index') }}"
           class="h-8 w-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Edit Periode Magang</h2>
            <p class="text-sm text-slate-500">Perbarui data periode <span class="font-medium text-slate-700">{{ $period->name }}</span></p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <form action="{{ route('admin.periods.update', $period) }}" method="POST" id="form-edit-period">
            @csrf
            @method('PUT')

            <div class="space-y-4">

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">
                        Nama Periode <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', $period->name) }}"
                           class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                  {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-slate-700 mb-1">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="start_date" id="start_date"
                               value="{{ old('start_date', $period->start_date) }}"
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
                        <input type="date" name="end_date" id="end_date"
                               value="{{ old('end_date', $period->end_date) }}"
                               class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                      {{ $errors->has('end_date') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                        @error('end_date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1"
                               class="w-4 h-4 text-primary border-slate-300 rounded focus:ring-primary"
                               {{ old('is_active', $period->is_active) ? 'checked' : '' }}>
                        <div>
                            <p class="text-sm font-medium text-slate-800">Set sebagai Periode Aktif</p>
                            <p class="text-xs text-slate-500">Mahasiswa hanya dapat mendaftar pada periode yang aktif.</p>
                        </div>
                    </label>
                </div>

            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-3 mt-8 pt-4 border-t border-slate-100">
                <button type="submit" id="btn-update-periode"
                        class="px-6 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors shadow-sm">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.periods.index') }}"
                   class="px-6 py-2 border border-slate-200 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>
@endsection
