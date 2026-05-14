{{-- resources/views/lecturer/students/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Profil Mahasiswa Bimbingan - Simagang')
@section('header_title', 'Profil Mahasiswa Bimbingan')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('lecturer.students.index') }}"
           class="h-8 w-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Profil Mahasiswa Bimbingan</h2>
            <p class="text-sm text-slate-500">Manajemen progres dan penilaian mahasiswa bimbingan.</p>
        </div>
    </div>

    {{-- Card 1: Informasi Mahasiswa (Full Width) --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col md:flex-row gap-8">
                {{-- Foto / Inisial --}}
                <div class="flex-shrink-0 flex flex-col items-center">
                    <div class="h-24 w-24 rounded-full bg-primary/10 text-primary flex items-center justify-center text-3xl font-bold border-4 border-white shadow-sm">
                        {{ substr($internship->student->user->name, 0, 1) }}
                    </div>
                    <div class="mt-4 text-center">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold {{ $internship->status === 'finished' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }} uppercase tracking-wider">
                            {{ $internship->status === 'finished' ? 'Selesai' : 'Aktif' }}
                        </span>
                    </div>
                </div>

                {{-- Detail Info --}}
                <div class="flex-grow grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-12 text-sm">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Informasi Personal</p>
                        <div class="space-y-3">
                            <div>
                                <p class="text-slate-500 text-xs">Nama Lengkap</p>
                                <p class="font-bold text-slate-800 text-base">{{ $internship->student->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs">NIM / Username</p>
                                <p class="font-medium text-slate-700">{{ $internship->student->user->username }}</p>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs">Program Studi</p>
                                <p class="font-medium text-slate-700">{{ $internship->student->study_program }} (Angkatan {{ $internship->student->cohort_year }})</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Informasi Magang</p>
                        <div class="space-y-3">
                            <div>
                                <p class="text-slate-500 text-xs">Perusahaan Mitra</p>
                                <p class="font-bold text-slate-800">{{ $internship->company->name }}</p>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs">Periode Magang</p>
                                <p class="font-medium text-slate-700">{{ $internship->internshipPeriod->name }}</p>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs">Durasi Pelaksanaan</p>
                                <p class="font-medium text-slate-700">
                                    {{ \Carbon\Carbon::parse($internship->start_date)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($internship->end_date)->translatedFormat('d M Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions / Grades --}}
                <div class="flex-shrink-0 w-full md:w-48 bg-slate-50 rounded-xl p-4 border border-slate-100 flex flex-col items-center justify-center">
                    @if($internship->status === 'finished')
                        <p class="text-[10px] font-bold text-slate-400 uppercase mb-2">Nilai Akhir</p>
                        <div class="text-4xl font-black text-primary">{{ number_format($internship->finalGrade->final_grade, 2) }}</div>
                        <p class="text-[10px] text-slate-500 mt-2 font-medium">Status: Lulus</p>
                    @else
                        <button type="button" @click="$dispatch('open-modal', 'modal-grading')"
                                class="w-full py-3 bg-primary text-white rounded-lg text-sm font-bold hover:bg-primary/90 transition-colors shadow-sm text-center">
                            Input Nilai Akhir
                        </button>
                        <p class="text-[10px] text-slate-500 mt-3 text-center">Silakan input nilai jika mahasiswa telah selesai magang.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Grid Bawah: Laporan Mingguan --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/30">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Riwayat Laporan Mingguan
            </h3>
            <span class="text-xs font-medium bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full">{{ $internship->weeklyReports->count() }} Laporan</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Minggu</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Rentang Tanggal</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Ketepatan Waktu</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Catatan Ringkas</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($internship->weeklyReports as $report)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-4 font-bold text-slate-700">Minggu Ke-{{ $report->week_number }}</td>
                            <td class="px-5 py-4 text-slate-600 text-xs tabular-nums">
                                {{ \Carbon\Carbon::parse($report->start_date)->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($report->end_date)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-5 py-4">
                                @if($report->is_late)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black bg-red-100 text-red-700 uppercase tracking-tighter">Terlambat</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black bg-emerald-100 text-emerald-700 uppercase tracking-tighter">Tepat Waktu</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-slate-500 text-xs italic">
                                {{ Str::limit($report->notes ?? '-', 50) }}
                            </td>
                            <td class="px-5 py-4">
                                <a href="{{ route('lecturer.weekly_reports.show', $report) }}"
                                   class="text-primary font-bold hover:underline">Lihat Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-400 italic">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-200 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p>Mahasiswa belum mengirimkan laporan mingguan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Modal Penilaian Akhir --}}
@if($internship->status === 'approved')
<div x-data="{ open: false }" 
     @open-modal.window="if ($event.detail === 'modal-grading') open = true"
     @close-modal.window="open = false"
     x-show="open" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-slate-900 bg-opacity-50" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('lecturer.internships.grade', $internship) }}" method="POST">
                @csrf
                <div class="px-6 py-5 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800">Input Nilai Akhir Magang</h3>
                    <p class="text-xs text-slate-500 mt-1">Berikan penilaian objektif berdasarkan kinerja mahasiswa selama magang.</p>
                </div>
                
                <div class="px-6 py-6 space-y-4">
                    <div>
                        <label for="report_grade" class="block text-sm font-semibold text-slate-700 mb-1">Nilai Laporan (Bobot 40%)</label>
                        <input type="number" name="report_grade" id="report_grade" min="0" max="100" step="0.01" required
                               class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary" placeholder="0-100">
                    </div>
                    <div>
                        <label for="presentation_grade" class="block text-sm font-semibold text-slate-700 mb-1">Nilai Presentasi (Bobot 30%)</label>
                        <input type="number" name="presentation_grade" id="presentation_grade" min="0" max="100" step="0.01" required
                               class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary" placeholder="0-100">
                    </div>
                    <div>
                        <label for="attitude_grade" class="block text-sm font-semibold text-slate-700 mb-1">Nilai Sikap/Perilaku (Bobot 30%)</label>
                        <input type="number" name="attitude_grade" id="attitude_grade" min="0" max="100" step="0.01" required
                               class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary" placeholder="0-100">
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-semibold text-slate-700 mb-1">Catatan Tambahan (Opsional)</label>
                        <textarea name="notes" id="notes" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary" placeholder="Masukkan saran atau evaluasi tambahan..."></textarea>
                    </div>

                    <div class="bg-amber-50 border border-amber-100 rounded-lg p-3">
                        <p class="text-[10px] text-amber-800 leading-relaxed">
                            <strong>Perhatian:</strong> Setelah nilai disimpan, status magang mahasiswa akan otomatis berubah menjadi <strong>SELESAI</strong> dan tidak dapat diubah kembali.
                        </p>
                    </div>
                </div>

                <div class="px-6 py-4 bg-slate-50 flex flex-col sm:flex-row-reverse gap-2">
                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-primary text-white rounded-lg text-sm font-bold hover:bg-primary/90 shadow-sm transition-colors">
                        Simpan & Selesaikan
                    </button>
                    <button type="button" @click="open = false" class="w-full sm:w-auto px-6 py-2.5 border border-slate-200 text-slate-600 rounded-lg text-sm font-medium hover:bg-white transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
