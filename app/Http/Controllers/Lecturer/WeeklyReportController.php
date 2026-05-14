<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\WeeklyReport;
use App\Models\Internship;
use App\Http\Requests\Lecturer\UpdateWeeklyReportStatusRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeeklyReportController extends Controller
{
    public function index(Request $request)
    {
        $lecturerId = Auth::user()->lecturer->id;
        $status = $request->query('status');
        
        $internships = Internship::where('lecturer_id', $lecturerId)
            ->where('status', 'approved')
            ->get();

        $query = WeeklyReport::whereIn('internship_id', $internships->pluck('id'))
            ->with(['internship.student.user', 'internship.company']);

        if ($status) {
            $query->where('status', $status);
        }

        $reports = $query->orderByDesc('created_at')->paginate(10);

        return view('lecturer.weekly_reports.index', compact('reports', 'status'));
    }

    public function show(WeeklyReport $weeklyReport)
    {
        $this->authorize('view', $weeklyReport);

        $weeklyReport->load('dailyActivities', 'internship.student.user', 'internship.company');

        return view('lecturer.weekly_reports.show', compact('weeklyReport'));
    }

    public function updateStatus(UpdateWeeklyReportStatusRequest $request, WeeklyReport $weeklyReport)
    {
        $this->authorize('view', $weeklyReport);

        $weeklyReport->update([
            'status' => $request->status
        ]);

        \App\Services\ActivityLogService::log(
            "validate_weekly_report",
            "weekly_reports",
            "Validated weekly report week {$weeklyReport->week_number} for {$weeklyReport->internship->student->user->name}"
        );

        // Kirim notifikasi ke Student saat laporan divalidasi
        if ($request->status === 'validated') {
            \App\Services\NotificationService::send(
                $weeklyReport->internship->student->user_id,
                'Laporan Mingguan Divalidasi',
                'Laporan mingguan ke-' . $weeklyReport->week_number . ' Anda telah divalidasi oleh dosen pembimbing.',
                'status_update',
                'weekly_reports',
                $weeklyReport->id
            );
        }

        return redirect()->route('lecturer.weekly_reports.show', $weeklyReport)
            ->with('success', 'Status laporan berhasil diperbarui.');
    }
}
