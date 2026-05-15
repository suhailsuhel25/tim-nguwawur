<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lecturer\StoreFinalGradeRequest;
use App\Http\Requests\Lecturer\UpdateFinalGradeRequest;
use App\Models\FinalGrade;
use App\Models\Internship;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class FinalGradeController extends Controller
{
    private function lecturerId(): int
    {
        return Auth::user()->lecturer->id;
    }

    /**
     * Calculate weighted final grade.
     * Bobot: Laporan 40%, Presentasi 30%, Sikap 30%
     */
    private function calculateFinalGrade(float $report, float $presentation, float $attitude): float
    {
        return round(($report * 0.4) + ($presentation * 0.3) + ($attitude * 0.3), 2);
    }

    /**
     * Convert numeric grade to letter grade.
     */
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

    /**
     * Display a listing of final grades.
     */
    public function index()
    {
        $lecturerId = $this->lecturerId();

        $grades = FinalGrade::with(['internship.student.user', 'internship.company'])
            ->where('lecturer_id', $lecturerId)
            ->orderByDesc('grading_date')
            ->paginate(10);

        // Internships that are approved but have no grade yet
        $ungradedCount = Internship::where('lecturer_id', $lecturerId)
            ->where('status', 'approved')
            ->whereDoesntHave('finalGrade')
            ->count();

        return view('lecturer.final_grades.index', compact('grades', 'ungradedCount'));
    }

    /**
     * Show the form for creating a new final grade.
     */
    public function create()
    {
        $lecturerId = $this->lecturerId();

        // Only show approved internships that have NO final grade yet
        $internships = Internship::with(['student.user', 'company'])
            ->where('lecturer_id', $lecturerId)
            ->where('status', 'approved')
            ->whereDoesntHave('finalGrade')
            ->get();

        return view('lecturer.final_grades.create', compact('internships'));
    }

    /**
     * Store a newly created final grade.
     */
    public function store(StoreFinalGradeRequest $request)
    {
        $internship = Internship::where('lecturer_id', $this->lecturerId())
            ->where('status', 'approved')
            ->findOrFail($request->internship_id);

        $finalGradeValue = $this->calculateFinalGrade(
            $request->report_grade,
            $request->presentation_grade,
            $request->attitude_grade
        );

        $grade = FinalGrade::create([
            'internship_id'      => $internship->id,
            'lecturer_id'        => $this->lecturerId(),
            'report_grade'       => $request->report_grade,
            'presentation_grade' => $request->presentation_grade,
            'attitude_grade'     => $request->attitude_grade,
            'final_grade'        => $finalGradeValue,
            'notes'              => $request->notes,
            'grading_date'       => now(),
        ]);

        // Notify student
        NotificationService::send(
            $internship->student->user_id,
            'Nilai Akhir Magang Diterbitkan',
            'Dosen pembimbing telah menerbitkan nilai akhir magang Anda. Nilai Akhir: ' . $finalGradeValue . ' (' . $this->letterGrade($finalGradeValue) . ').',
            'status_update',
            'final_grades',
            $grade->id
        );

        return redirect()->route('lecturer.final_grades.show', $grade)
            ->with('success', 'Nilai akhir berhasil disimpan.');
    }

    /**
     * Display the specified final grade.
     */
    public function show(FinalGrade $finalGrade)
    {
        if ($finalGrade->lecturer_id !== $this->lecturerId()) {
            abort(403);
        }

        $finalGrade->load(['internship.student.user', 'internship.company', 'internship.weeklyReports', 'internship.mentorshipSessions']);

        $letterGrade = $this->letterGrade($finalGrade->final_grade);

        return view('lecturer.final_grades.show', compact('finalGrade', 'letterGrade'));
    }

    /**
     * Show the form for editing the final grade.
     */
    public function edit(FinalGrade $finalGrade)
    {
        if ($finalGrade->lecturer_id !== $this->lecturerId()) {
            abort(403);
        }

        $finalGrade->load(['internship.student.user', 'internship.company']);

        return view('lecturer.final_grades.edit', compact('finalGrade'));
    }

    /**
     * Update the specified final grade.
     */
    public function update(UpdateFinalGradeRequest $request, FinalGrade $finalGrade)
    {
        if ($finalGrade->lecturer_id !== $this->lecturerId()) {
            abort(403);
        }

        $finalGradeValue = $this->calculateFinalGrade(
            $request->report_grade,
            $request->presentation_grade,
            $request->attitude_grade
        );

        $finalGrade->update([
            'report_grade'       => $request->report_grade,
            'presentation_grade' => $request->presentation_grade,
            'attitude_grade'     => $request->attitude_grade,
            'final_grade'        => $finalGradeValue,
            'notes'              => $request->notes,
        ]);

        // Notify student about grade update
        NotificationService::send(
            $finalGrade->internship->student->user_id,
            'Nilai Akhir Diperbarui',
            'Nilai akhir magang Anda telah diperbarui. Nilai Akhir: ' . $finalGradeValue . ' (' . $this->letterGrade($finalGradeValue) . ').',
            'status_update',
            'final_grades',
            $finalGrade->id
        );

        return redirect()->route('lecturer.final_grades.show', $finalGrade)
            ->with('success', 'Nilai akhir berhasil diperbarui.');
    }
}
