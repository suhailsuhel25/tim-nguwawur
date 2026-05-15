<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\MentorshipSession;
use App\Models\WeeklyReport;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $studentId = Auth::user()->student->id;

        // Get the active/latest internship
        $internship = Internship::with(['company', 'internshipPeriod', 'lecturer.user', 'finalGrade'])
            ->where('student_id', $studentId)
            ->latest()
            ->first();

        $stats = [
            'weekly_reports' => 0,
            'mentorship_sessions' => 0,
            'pending_reports' => 0,
        ];

        $upcomingSessions = collect();

        if ($internship) {
            $stats['weekly_reports'] = WeeklyReport::where('internship_id', $internship->id)->count();
            $stats['pending_reports'] = WeeklyReport::where('internship_id', $internship->id)->where('status', 'submitted')->count();
            $stats['mentorship_sessions'] = MentorshipSession::where('internship_id', $internship->id)->where('status', 'completed')->count();

            $upcomingSessions = MentorshipSession::where('internship_id', $internship->id)
                ->where('status', 'scheduled')
                ->where('date', '>=', now())
                ->orderBy('date')
                ->take(3)
                ->get();
        }

        return view('student.dashboard', compact('internship', 'stats', 'upcomingSessions'));
    }
}
