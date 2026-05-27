{{-- resources/views/student/weekly_reports/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Laporan Mingguan - Simagang')
@section('header_title', 'Sistem Monitoring Magang')

@section('content')
<div x-data="weeklyReportForm()" class="max-w-7xl mx-auto space-y-6">

    {{-- Top Banner --}}
    <div class="flex flex-col md:flex-row gap-6">
        <div class="flex-1 bg-gradient-to-r from-blue-700 to-blue-500 rounded-2xl p-8 text-white relative overflow-hidden shadow-sm">
            <div class="relative z-10">
                <h2 class="text-3xl font-bold mb-2">Minggu ke-{{ $nextWeekNumber }}</h2>
                <p class="text-blue-100 max-w-lg leading-relaxed text-sm">
                    Waktunya melaporkan perkembangan magangmu di {{ $internship->company->name }}. 
                    Pastikan dokumentasi lengkap untuk persetujuan cepat.
                </p>
            </div>
            {{-- Decorative Stars --}}
            <svg class="absolute right-0 top-0 text-white/10 w-48 h-48 transform translate-x-12 -translate-y-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l2.4 7.6H22l-6.2 4.5 2.4 7.6L12 17.2l-6.2 4.5 2.4-7.6L2 9.6h7.6z"/></svg>
            <svg class="absolute right-24 top-12 text-white/20 w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l1.6 5.4H19l-4.2 3.2 1.6 5.4L12 12.8l-4.2 3.2 1.6-5.4L5 7.4h5.4z"/></svg>
        </div>
        
        <div class="shrink-0 flex gap-4">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col justify-center items-center min-w-[140px]">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Laporan</p>
                <p class="text-2xl font-bold text-blue-700">{{ $nextWeekNumber - 1 }}<span class="text-lg text-slate-400">/16</span></p>
                <p class="text-xs text-slate-500 mt-1">Selesai</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col justify-center items-center min-w-[140px]">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Rata Nilai</p>
                <p class="text-2xl font-bold text-amber-500">-</p>
                <p class="text-xs text-slate-500 mt-1">Dari Dosen</p>
            </div>
        </div>
    </div>

    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl shadow-sm">
        <ul class="list-disc pl-5 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('student.weekly_reports.store') }}" method="POST" enctype="multipart/form-data" id="reportForm">
        @csrf
        <input type="hidden" name="internship_id" value="{{ $internship->id }}">
        <input type="hidden" name="week_number" value="{{ $nextWeekNumber }}">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Left Column: Form Input --}}
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        <h3 class="font-bold text-slate-800">Input Aktivitas Mingguan</h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        
                        {{-- Deskripsi Pekerjaan --}}
                        <div>
                            <label for="activity_description" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Deskripsi Pekerjaan <span class="text-red-500">*</span></label>
                            <textarea name="activity_description" id="activity_description" rows="4" required
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 bg-slate-50/50"
                                placeholder="Tuliskan detail aktivitas, tantangan, dan solusi yang Anda temukan minggu ini...">{{ old('activity_description') }}</textarea>
                        </div>

                        {{-- Optional Fields: Challenges & Next Week Plan --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="challenges" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Tantangan/Kendala</label>
                                <textarea name="challenges" id="challenges" rows="2"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 bg-slate-50/50"
                                    placeholder="Kendala (opsional)...">{{ old('challenges') }}</textarea>
                            </div>
                            <div>
                                <label for="next_week_plan" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Rencana Minggu Depan</label>
                                <textarea name="next_week_plan" id="next_week_plan" rows="2"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 bg-slate-50/50"
                                    placeholder="Rencana (opsional)...">{{ old('next_week_plan') }}</textarea>
                            </div>
                        </div>

                        {{-- Rentang Tanggal (Otomatis) --}}
                        <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-4 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Rentang Tanggal Laporan</p>
                                <p class="text-sm font-medium text-slate-800">
                                    {{ \Carbon\Carbon::parse($weekStartDate)->translatedFormat('d M Y') }} 
                                    <span class="text-slate-400 mx-2">s/d</span> 
                                    {{ \Carbon\Carbon::parse($weekEndDate)->translatedFormat('d M Y') }}
                                </p>
                            </div>
                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                        </div>

                        {{-- Dokumentasi Upload --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Dokumentasi (File/Image)</label>
                            
                            <input type="file" name="documentation" id="documentation" accept=".pdf,.jpg,.jpeg,.png" class="hidden" @change="handleFileChange($event)">
                            
                            <template x-if="!file">
                                <div class="border-2 border-dashed border-slate-300 bg-slate-50/50 rounded-xl p-8 text-center hover:bg-blue-50 hover:border-blue-300 transition-colors cursor-pointer"
                                     @click="document.getElementById('documentation').click()"
                                     @dragover.prevent="$el.classList.add('bg-blue-50', 'border-blue-300')"
                                     @dragleave.prevent="$el.classList.remove('bg-blue-50', 'border-blue-300')"
                                     @drop.prevent="$el.classList.remove('bg-blue-50', 'border-blue-300'); handleFileDrop($event)">
                                    <div class="mx-auto w-12 h-12 text-slate-400 mb-3 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-700">Tarik file ke sini atau klik untuk upload</p>
                                    <p class="text-xs text-slate-500 mt-1">PDF, JPG, PNG (Maks. 5MB)</p>
                                </div>
                            </template>

                            <template x-if="file">
                                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 bg-white rounded shadow-sm flex items-center justify-center text-blue-600 border border-blue-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800" x-text="file.name"></p>
                                            <p class="text-xs text-slate-500 mt-0.5" x-text="file.size"></p>
                                        </div>
                                    </div>
                                    <button type="button" @click="removeFile()" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </template>
                        </div>

                    </div>

                    {{-- Daily Activities Integration --}}
                    <div class="px-6 pb-6 border-t border-slate-100 pt-6 bg-slate-50/50">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-bold text-slate-800">Aktivitas Harian <span class="text-red-500">*</span></h4>
                            <button type="button" @click="addActivity()" class="text-xs font-medium text-blue-600 bg-blue-100 px-3 py-1.5 rounded-lg hover:bg-blue-200 transition-colors">
                                + Tambah Hari
                            </button>
                        </div>
                        
                        <div class="space-y-3">
                            <template x-for="(activity, index) in activities" :key="index">
                                <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center bg-white p-3 border border-slate-200 rounded-xl shadow-sm">
                                    <input type="date" :name="'daily_activities['+index+'][date]'" x-model="activity.date" required
                                           class="w-full sm:w-36 px-3 py-2 border border-slate-200 rounded-lg text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                    <input type="text" :name="'daily_activities['+index+'][activity_description]'" x-model="activity.description" required placeholder="Detail Aktivitas (opsional bisa disamakan dengan atas)"
                                           class="flex-1 w-full px-3 py-2 border border-slate-200 rounded-lg text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                    <div class="flex gap-2 w-full sm:w-auto">
                                        <input type="number" step="0.5" min="0.5" max="24" :name="'daily_activities['+index+'][duration_hours]'" x-model="activity.hours" required placeholder="Jam"
                                               class="w-20 px-3 py-2 border border-slate-200 rounded-lg text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                        <button type="button" @click="removeActivity(index)" x-show="activities.length > 1" class="p-2 text-red-500 hover:bg-red-50 rounded-lg border border-transparent hover:border-red-100 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="px-6 py-5 border-t border-slate-100 flex items-center justify-end gap-3 bg-white">
                        <a href="{{ route('student.weekly_reports.index') }}" class="px-6 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-2.5 text-sm font-bold text-white bg-blue-700 hover:bg-blue-800 shadow-sm shadow-blue-200 rounded-xl transition-colors">
                            SUBMIT LAPORAN
                        </button>
                    </div>
                </div>

            </div>

            {{-- Right Column: Sidebars --}}
            <div class="space-y-6">
                
                {{-- Timeline Progres Card --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="text-sm font-bold text-slate-800 mb-6">Timeline Progres</h3>
                    
                    <div class="relative border-l-2 border-slate-100 ml-3 space-y-8">
                        {{-- Mendatang --}}
                        <div class="relative">
                            <div class="absolute w-3 h-3 bg-slate-200 rounded-full -left-[7px] top-1"></div>
                            <div class="pl-6">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">MINGGU {{ $nextWeekNumber + 1 }}-16</p>
                                <p class="text-sm text-slate-800 font-bold mt-1">Mendatang</p>
                                <p class="text-xs text-slate-500 mt-1">Fokus pada penyelesaian tugas magang.</p>
                            </div>
                        </div>

                        {{-- Sekarang (Draft) --}}
                        <div class="relative">
                            <div class="absolute w-4 h-4 bg-blue-600 border-4 border-blue-100 rounded-full -left-[9px] top-1"></div>
                            <div class="pl-6">
                                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-xs font-bold text-blue-800 uppercase tracking-wider">MINGGU {{ $nextWeekNumber }} (NOW)</p>
                                        <span class="text-[10px] font-bold text-blue-700 bg-blue-200 px-2 py-0.5 rounded uppercase">DRAFT</span>
                                    </div>
                                    <p class="text-sm text-blue-900 font-bold">Laporan Saat Ini</p>
                                    <p class="text-xs text-blue-600 mt-1">Deadline: {{ \Carbon\Carbon::now()->endOfWeek()->translatedFormat('d M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Minggu Sebelumnya (Disetujui) --}}
                        @if($nextWeekNumber > 1)
                        <div class="relative">
                            <div class="absolute w-3 h-3 bg-emerald-500 rounded-full -left-[7px] top-1"></div>
                            <div class="pl-6">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">MINGGU {{ $nextWeekNumber - 1 }}</p>
                                <p class="text-sm text-slate-800 font-bold mt-1">Laporan Terakhir</p>
                                <p class="text-xs text-emerald-600 mt-1 flex items-center gap-1 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                    Telah Disubmit
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Butuh bantuan teknis Card --}}
                <div class="bg-slate-50 rounded-2xl border border-slate-200 shadow-sm p-5 flex items-start gap-4">
                    <div class="h-10 w-10 bg-white rounded-full flex items-center justify-center text-blue-600 shadow-sm shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800">Butuh bantuan teknis?</h4>
                        <p class="text-xs text-slate-500 mt-1">Hubungi admin akademik via Telegram atau kunjungi helpdesk kampus.</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('weeklyReportForm', () => ({
            activities: [
                { date: '{{ $weekStartDate->toDateString() }}', description: '', hours: 8 }
            ],
            file: null,

            handleFileChange(event) {
                const file = event.target.files[0];
                if (file) {
                    this.file = {
                        name: file.name,
                        size: (file.size / (1024 * 1024)).toFixed(2) + ' MB'
                    };
                } else {
                    this.file = null;
                }
            },
            
            handleFileDrop(event) {
                const file = event.dataTransfer.files[0];
                const validTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];
                
                if (file && validTypes.includes(file.type)) {
                    this.file = {
                        name: file.name,
                        size: (file.size / (1024 * 1024)).toFixed(2) + ' MB'
                    };
                    
                    const input = document.getElementById('documentation');
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    input.files = dt.files;
                } else {
                    alert('Hanya file PDF, JPG, atau PNG yang diperbolehkan.');
                }
            },
            
            removeFile() {
                this.file = null;
                document.getElementById('documentation').value = '';
            },
            
            addActivity() {
                let lastDate = new Date('{{ $weekStartDate->toDateString() }}');
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
            }
        }))
    })
</script>
@endsection
