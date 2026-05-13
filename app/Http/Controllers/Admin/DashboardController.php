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

        return view('admin.dashboard', compact('stats', 'recentInternships'));
    }
}
