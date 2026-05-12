{{-- resources/views/admin/companies/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Perusahaan - Simagang')
@section('header_title', 'Edit Perusahaan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.companies.index') }}"
           class="h-8 w-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Edit Perusahaan Mitra</h2>
            <p class="text-sm text-slate-500">Perbarui data <span class="font-medium text-slate-700">{{ $company->name }}</span></p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <form action="{{ route('admin.companies.update', $company) }}" method="POST" id="form-edit-company">
            @csrf
            @method('PUT')

            {{-- Informasi Perusahaan --}}
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100">
                    Informasi Perusahaan
                </h3>
                <div class="space-y-4">

                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-1">
                            Nama Perusahaan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name', $company->name) }}"
                               class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                      {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="industry" class="block text-sm font-medium text-slate-700 mb-1">
                            Bidang Industri <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="industry" id="industry"
                               value="{{ old('industry', $company->industry) }}"
                               class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                      {{ $errors->has('industry') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                        @error('industry')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-slate-700 mb-1">
                            Alamat <span class="text-red-500">*</span>
                        </label>
                        <textarea name="address" id="address" rows="3"
                                  class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary resize-none
                                         {{ $errors->has('address') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">{{ old('address', $company->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Informasi Kontak --}}
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100">
                    Informasi Kontak
                </h3>
                <div class="space-y-4">

                    <div>
                        <label for="contact_person" class="block text-sm font-medium text-slate-700 mb-1">
                            Nama Kontak Person <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="contact_person" id="contact_person"
                               value="{{ old('contact_person', $company->contact_person) }}"
                               class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                      {{ $errors->has('contact_person') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                        @error('contact_person')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-slate-700 mb-1">
                                Email Kontak
                            </label>
                            <input type="email" name="contact_email" id="contact_email"
                                   value="{{ old('contact_email', $company->contact_email) }}"
                                   class="w-full px-3 py-2 border rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                                          {{ $errors->has('contact_email') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                            @error('contact_email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="contact_phone" class="block text-sm font-medium text-slate-700 mb-1">
                                Telepon Kontak
                            </label>
                            <input type="text" name="contact_phone" id="contact_phone"
                                   value="{{ old('contact_phone', $company->contact_phone) }}"
                                   class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            @error('contact_phone')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit" id="btn-update-perusahaan"
                        class="px-6 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors shadow-sm">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.companies.index') }}"
                   class="px-6 py-2 border border-slate-200 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>
@endsection
