<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\InternshipPeriod;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function activities(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id'
        ]);

        $studentUser = User::with('student')->findOrFail($request->student_id);
        $studentId = $studentUser->student->id;

        $internships = Internship::with(['company', 'internshipPeriod', 'lecturer.user', 'weeklyReports', 'mentorshipSessions'])
            ->where('student_id', $studentId)
            ->whereIn('status', ['approved', 'completed'])
            ->orderByDesc('created_at')
            ->get();

        $pdf = Pdf::loadView('admin.reports.activities_pdf', compact('studentUser', 'internships'));
        
        return $pdf->download('laporan-kegiatan-' . str($studentUser->name)->slug() . '.pdf');
    }

    public function grades(Request $request)
    {
        $request->validate([
            'period_id' => 'required|exists:internship_periods,id'
        ]);

        $period = InternshipPeriod::findOrFail($request->period_id);

        $internships = Internship::with(['student.user', 'company', 'lecturer.user', 'finalGrade'])
            ->where('internship_period_id', $period->id)
            ->whereIn('status', ['approved', 'completed'])
            ->get();

        $pdf = Pdf::loadView('admin.reports.grades_pdf', compact('period', 'internships'));
        
        return $pdf->download('rekap-nilai-periode-' . str($period->name)->slug() . '.pdf');
    }
}
