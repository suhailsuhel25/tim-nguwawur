{{-- resources/views/mahasiswa/weekly_reports/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Buat Laporan Mingguan - Simagang')
@section('header_title', 'Buat Laporan Mingguan')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Buat Laporan Minggu Ke-{{ $nextWeekNumber }}</h2>
        <p class="text-slate-600 mt-1">Perusahaan: {{ $internship->company->name }}</p>
    </div>
    <a href="{{ route('student.weekly_reports.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-4 py-2 rounded-lg transition-colors">
        Kembali
    </a>
</div>

@if ($errors->any())
<div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg mb-6 shadow-sm">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada input Anda:</h3>
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

<form action="{{ route('student.weekly_reports.store') }}" method="POST" x-data="weeklyReportForm()">
    @csrf
    <input type="hidden" name="internship_id" value="{{ $internship->id }}">
    <input type="hidden" name="week_number" value="{{ $nextWeekNumber }}">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informasi Umum -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Informasi Periode</h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-slate-700 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" id="start_date" x-model="startDate" required
                            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 text-sm">
                    </div>
                    
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-slate-700 mb-1">Tanggal Selesai <span class="text-red-500">*</span></label>
                        <input type="date" name="end_date" id="end_date" x-model="endDate" required
                            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 text-sm">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Rangkuman Mingguan</h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="activity_description" class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Umum <span class="text-red-500">*</span></label>
                        <textarea name="activity_description" id="activity_description" rows="4" required
                            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 text-sm"
                            placeholder="Jelaskan secara garis besar apa yang Anda kerjakan minggu ini...">{{ old('activity_description') }}</textarea>
                    </div>

                    <div>
                        <label for="challenges" class="block text-sm font-medium text-slate-700 mb-1">Tantangan/Kendala</label>
                        <textarea name="challenges" id="challenges" rows="3"
                            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 text-sm"
                            placeholder="Kendala yang dihadapi (jika ada)...">{{ old('challenges') }}</textarea>
                    </div>

                    <div>
                        <label for="next_week_plan" class="block text-sm font-medium text-slate-700 mb-1">Rencana Minggu Depan</label>
                        <textarea name="next_week_plan" id="next_week_plan" rows="3"
                            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 text-sm"
                            placeholder="Apa yang akan Anda kerjakan di minggu selanjutnya?">{{ old('next_week_plan') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daily Activities (Alpine.js) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-2">
                    <h3 class="font-bold text-slate-800">Aktivitas Harian <span class="text-red-500">*</span></h3>
                    <button type="button" @click="addActivity()" class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-primary hover:bg-blue-100 text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Hari
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-for="(activity, index) in activities" :key="index">
                        <div class="p-4 border border-slate-200 rounded-lg bg-slate-50 relative group">
                            <button type="button" @click="removeActivity(index)" x-show="activities.length > 1" class="absolute top-3 right-3 text-red-400 hover:text-red-600 bg-white rounded-full p-1 shadow-sm opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                            
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="md:col-span-1">
                                    <label :for="'date_'+index" class="block text-xs font-medium text-slate-500 mb-1">Tanggal</label>
                                    <input type="date" :name="'daily_activities['+index+'][date]'" :id="'date_'+index" x-model="activity.date" required
                                        class="w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 text-sm">
                                </div>
                                <div class="md:col-span-2">
                                    <label :for="'desc_'+index" class="block text-xs font-medium text-slate-500 mb-1">Detail Aktivitas</label>
                                    <input type="text" :name="'daily_activities['+index+'][activity_description]'" :id="'desc_'+index" x-model="activity.description" required
                                        class="w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 text-sm"
                                        placeholder="Contoh: Membuat desain UI/UX untuk modul A">
                                </div>
                                <div class="md:col-span-1">
                                    <label :for="'hours_'+index" class="block text-xs font-medium text-slate-500 mb-1">Durasi (Jam)</label>
                                    <input type="number" step="0.5" min="0.5" max="24" :name="'daily_activities['+index+'][duration_hours]'" :id="'hours_'+index" x-model="activity.hours" required
                                        class="w-full rounded-md border-slate-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 text-sm"
                                        placeholder="Misal: 8">
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <div x-show="activities.length === 0" class="text-center p-6 border-2 border-dashed border-slate-300 rounded-lg text-slate-500">
                        Klik tombol "Tambah Hari" untuk menambahkan log aktivitas harian Anda.
                    </div>
                </div>

                <div class="mt-8 pt-4 border-t border-slate-200 flex items-center justify-between">
                    <div class="text-sm text-slate-600">
                        Total Durasi: <strong x-text="totalHours + ' Jam'" class="text-slate-800"></strong>
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition-colors shadow-sm focus:ring-4 focus:ring-primary/30">
                        Simpan & Kirim Laporan
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('weeklyReportForm', () => ({
            startDate: '{{ old('start_date', date('Y-m-d')) }}',
            endDate: '{{ old('end_date', date('Y-m-d', strtotime('+4 days'))) }}',
            activities: [
                { date: '{{ date('Y-m-d') }}', description: '', hours: 8 }
            ],
            
            init() {
                // If there are old inputs, we could populate them here, 
                // but for simplicity we start with 1 row
            },
            
            addActivity() {
                let lastDate = new Date(this.startDate);
                if (this.activities.length > 0) {
                    lastDate = new Date(this.activities[this.activities.length - 1].date);
                    lastDate.setDate(lastDate.getDate() + 1);
                }
                
                this.activities.push({
                    date: lastDate.toISOString().split('T')[0],
                    description: '',
                    hours: 8
                });
            },
            
            removeActivity(index) {
                this.activities.splice(index, 1);
            },
            
            get totalHours() {
                return this.activities.reduce((sum, activity) => {
                    let val = parseFloat(activity.hours);
                    return sum + (isNaN(val) ? 0 : val);
                }, 0);
            }
        }))
    })
</script>
@endsection
