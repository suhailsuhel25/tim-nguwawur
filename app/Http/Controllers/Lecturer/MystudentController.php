<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Internship;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class MyStudentController extends Controller
{
    public function index()
    {
        $internships = Internship::with(['student', 'company'])
            ->where('lecturer_id', Auth::id())
            ->latest()
            ->get();

        $students = User::where('role', 'student')->get();

        $companies = Company::all();

        return view('lecturer.my-student.index', compact(
            'internships',
            'students',
            'companies'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'company_id' => 'required',
        ]);

        Internship::create([
            'student_id' => $request->student_id,
            'lecturer_id' => Auth::id(),
            'company_id' => $request->company_id,
            'status' => 'pending',
        ]);

        return redirect()->back()
            ->with('success', 'Mahasiswa berhasil ditambahkan');
    }
}