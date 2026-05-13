<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\MentorshipSession;
use App\Models\WeeklyReport;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $lecturerId = Auth::user()->lecturer->id;

        $stats = [
            'active_students' => Internship::where('lecturer_id', $lecturerId)->where('status', 'approved')->count(),
            'pending_reports' => WeeklyReport::whereHas('internship', function ($query) use ($lecturerId) {
                $query->where('lecturer_id', $lecturerId);
            })->where('status', 'submitted')->count(),
            'completed_sessions' => MentorshipSession::whereHas('internship', function ($query) use ($lecturerId) {
                $query->where('lecturer_id', $lecturerId);
            })->where('status', 'completed')->count(),
            'ungraded_students' => Internship::where('lecturer_id', $lecturerId)
                ->where('status', 'approved')
                ->whereDoesntHave('finalGrade')
                ->count(),
        ];

        $upcomingSessions = MentorshipSession::with('internship.student.user')
            ->whereHas('internship', function ($query) use ($lecturerId) {
                $query->where('lecturer_id', $lecturerId);
            })
            ->where('status', 'scheduled')
            ->where('date', '>=', now())
            ->orderBy('date')
            ->take(5)
            ->get();

        $recentReports = WeeklyReport::with('internship.student.user')
            ->whereHas('internship', function ($query) use ($lecturerId) {
                $query->where('lecturer_id', $lecturerId);
            })
            ->where('status', 'submitted')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('lecturer.dashboard', compact('stats', 'upcomingSessions', 'recentReports'));
    }
}
