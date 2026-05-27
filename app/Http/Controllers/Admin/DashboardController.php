<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Internship;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Total perusahaan
        $totalCompanies = Company::count();

        // Total mahasiswa
        $totalStudents = User::where('role', 'student')->count();

        // Total dosen
        $totalLecturers = User::where('role', 'lecturer')->count();

        // Total pengajuan magang
        $totalInternships = Internship::count();

        return view('admin.dashboard', compact(
            'totalCompanies',
            'totalStudents',
            'totalLecturers',
            'totalInternships'
        ));
    }
}