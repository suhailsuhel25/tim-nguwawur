<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\WeeklyReport;
use App\Models\Internship;
use App\Http\Requests\Student\StoreWeeklyReportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WeeklyReportController extends Controller
{
    public function index()
    {
        $studentId = Auth::user()->student->id;
        
        $internships = Internship::where('student_id', $studentId)
            ->where('status', 'approved')
            ->with(['company', 'internshipPeriod'])
            ->get();

        $reports = WeeklyReport::whereIn('internship_id', $internships->pluck('id'))
            ->with(['internship.company'])
            ->orderByDesc('start_date')
            ->paginate(10);

        return view('student.weekly_reports.index', compact('internships', 'reports'));
    }

    public function create(Request $request)
    {
        $internshipId = $request->query('internship_id');
        
        $internship = Internship::where('student_id', Auth::user()->student->id)
            ->where('status', 'approved')
            ->findOrFail($internshipId);

        // Calculate next week number
        $lastReport = $internship->weeklyReports()->orderByDesc('week_number')->first();
        $nextWeekNumber = $lastReport ? $lastReport->week_number + 1 : 1;

        $internshipStartDate = \Carbon\Carbon::parse($internship->start_date);
        $weekStartDate = $internshipStartDate->copy()->addWeeks($nextWeekNumber - 1);
        $weekEndDate = $weekStartDate->copy()->addDays(6);

        return view('student.weekly_reports.create', compact('internship', 'nextWeekNumber', 'weekStartDate', 'weekEndDate'));
    }

    public function store(StoreWeeklyReportRequest $request)
    {
        // Ensure the internship belongs to the student and is approved
        $internship = Internship::where('student_id', Auth::user()->student->id)
            ->where('status', 'approved')
            ->findOrFail($request->internship_id);

        // Calculate start_date and end_date dynamically
        $internshipStartDate = \Carbon\Carbon::parse($internship->start_date);
        $startDate = $internshipStartDate->copy()->addWeeks($request->week_number - 1);
        $endDate = $startDate->copy()->addDays(6);

        $now = \Carbon\Carbon::now();

        // Validation: Cannot submit early
        if ($now->lt($startDate->startOfDay())) {
            return back()->with('error', 'Gagal! Anda tidak bisa mengirim laporan sebelum minggu pelaksanaannya dimulai (' . $startDate->translatedFormat('d M Y') . ').')->withInput();
        }

        // Check if late
        $isLate = $now->gt($endDate->endOfDay());

        // Validate daily activities dates
        foreach ($request->daily_activities as $activity) {
            $activityDate = \Carbon\Carbon::parse($activity['date']);
            if ($activityDate->lt($startDate->startOfDay()) || $activityDate->gt($endDate->endOfDay())) {
                return back()->with('error', 'Gagal! Tanggal aktivitas harian (' . $activityDate->translatedFormat('d M Y') . ') harus berada dalam rentang minggu laporan (' . $startDate->translatedFormat('d M Y') . ' s/d ' . $endDate->translatedFormat('d M Y') . ').')->withInput();
            }
        }

        try {
            DB::beginTransaction();

            $report = WeeklyReport::create([
                'internship_id' => $internship->id,
                'week_number' => $request->week_number,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'activity_description' => $request->activity_description,
                'challenges' => $request->challenges,
                'next_week_plan' => $request->next_week_plan,
                'status' => 'submitted', // Auto submitted
                'is_late' => $isLate,
            ]);

            if ($request->hasFile('documentation')) {
                $file = $request->file('documentation');
                $fileName = time() . '_' . $report->id . '_doc.' . $file->extension();
                $filePath = $file->storeAs('private/weekly_reports/' . $report->id, $fileName);
                
                $report->update([
                    'document_path' => $filePath
                ]);
            }

            foreach ($request->daily_activities as $activity) {
                $report->dailyActivities()->create([
                    'date' => $activity['date'],
                    'activity_description' => $activity['activity_description'],
                    'duration_hours' => $activity['duration_hours'],
                ]);
            }

            // Create notification for Lecturer
            if ($internship->lecturer_id) {
                $lecturer = \App\Models\Lecturer::with('user')->find($internship->lecturer_id);
                if ($lecturer && $lecturer->user) {
                    \App\Services\NotificationService::send(
                        $lecturer->user->id,
                        'Laporan Mingguan Baru',
                        Auth::user()->name . ' telah mengirim laporan mingguan ke-' . $report->week_number . '.',
                        'info',
                        'weekly_reports',
                        $report->id
                    );
                }
            }

            DB::commit();

            return redirect()->route('student.weekly_reports.index')
                ->with('success', 'Laporan mingguan berhasil disimpan dan dikirim.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan laporan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(WeeklyReport $weeklyReport)
    {
        // Check authorization
        if ($weeklyReport->internship->student_id !== Auth::user()->student->id) {
            abort(403);
        }

        $weeklyReport->load('dailyActivities', 'internship.company');

        return view('student.weekly_reports.show', compact('weeklyReport'));
    }

    public function downloadDocument(WeeklyReport $weeklyReport)
    {
        // Check authorization
        if ($weeklyReport->internship->student_id !== Auth::user()->student->id) {
            abort(403);
        }

        if (!$weeklyReport->document_path || !\Illuminate\Support\Facades\Storage::exists($weeklyReport->document_path)) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        return \Illuminate\Support\Facades\Storage::response($weeklyReport->document_path);
    }
}
