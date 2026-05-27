<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Internship;
use App\Models\InternshipPeriod;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students' => User::where('role', 'student')->count(),
            'total_lecturers' => User::where('role', 'lecturer')->count(),
            'total_companies' => Company::count(),
            'active_internships' => Internship::where('status', 'approved')->count(),
            'pending_internships' => Internship::where('status', 'pending')->count(),
            'active_periods' => InternshipPeriod::where('is_active', true)->count(),
        ];

        $recentInternships = Internship::with(['student.user', 'company', 'lecturer.user'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Data for chart (Internship Status Distribution)
        $chartData = [
            'labels' => ['Pending', 'Approved', 'Rejected', 'Completed'],
            'data' => [
                Internship::where('status', 'pending')->count(),
                Internship::where('status', 'approved')->count(),
                Internship::where('status', 'rejected')->count(),
                Internship::where('status', 'completed')->count(),
            ],
            'colors' => ['#f59e0b', '#10b981', '#ef4444', '#3b82f6'] // Tailwind amber, emerald, red, blue
        ];

        // Data for Report Export Dropdowns
        $periods = InternshipPeriod::orderByDesc('start_date')->get();
        $students = User::where('role', 'student')->whereHas('student.internships')->orderBy('name')->get();

        return view('admin.dashboard', compact('stats', 'recentInternships', 'chartData', 'periods', 'students'));
    }
}
