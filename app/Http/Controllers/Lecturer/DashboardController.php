<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\WeeklyReport;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data magang dosen
        $internships = Internship::with(['student', 'company'])
            ->where('lecturer_id', Auth::id())
            ->latest()
            ->get();

        // Total laporan mingguan
        $weeklyReports = WeeklyReport::whereHas('internship', function ($query) {
            $query->where('lecturer_id', Auth::id());
        })->count();

        // Total magang aktif
        $activeInternships = Internship::where('lecturer_id', Auth::id())
            ->where('status', 'approved')
            ->count();

        // Dummy jadwal
        $meetings = 3;

        return view('lecturer.dashboard', compact(
            'internships',
            'weeklyReports',
            'activeInternships',
            'meetings'
        ));
    }
}