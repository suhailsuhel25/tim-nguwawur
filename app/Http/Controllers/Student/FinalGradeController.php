<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\FinalGrade;
use App\Models\Internship;
use Illuminate\Support\Facades\Auth;

class FinalGradeController extends Controller
{
    /**
     * Display the student's final grade.
     */
    public function index()
    {
        $studentId = Auth::user()->student->id;

        $grades = FinalGrade::with(['internship.company', 'internship.internshipPeriod', 'lecturer.user'])
            ->whereHas('internship', fn ($q) => $q->where('student_id', $studentId))
            ->orderByDesc('grading_date')
            ->get();

        return view('student.final_grades.index', compact('grades'));
    }

    /**
     * Display detail of a specific final grade.
     */
    public function show(FinalGrade $finalGrade)
    {
        if ($finalGrade->internship->student_id !== Auth::user()->student->id) {
            abort(403);
        }

        $finalGrade->load(['internship.company', 'internship.internshipPeriod', 'lecturer.user']);

        // Letter grade
        $letterGrade = $this->letterGrade($finalGrade->final_grade);

        return view('student.final_grades.show', compact('finalGrade', 'letterGrade'));
    }

    private function letterGrade(float $grade): string
    {
        if ($grade >= 85) return 'A';
        if ($grade >= 80) return 'A-';
        if ($grade >= 75) return 'B+';
        if ($grade >= 70) return 'B';
        if ($grade >= 65) return 'B-';
        if ($grade >= 60) return 'C+';
        if ($grade >= 55) return 'C';
        if ($grade >= 50) return 'D';
        return 'E';
    }
}
