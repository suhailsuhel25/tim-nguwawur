<?php

// app/Http/Controllers/Lecturer/InternshipController.php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lecturer\UpdateInternshipStatusRequest;
use App\Models\Internship;
use App\Models\FinalGrade;
use App\Services\NotificationService;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InternshipController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = request()->user();
        $lecturer = $user->lecturer;

        // Show applications from the same study_program
        $query = Internship::with(['student.user', 'company', 'internshipPeriod'])
            ->whereHas('student', function ($q) use ($lecturer) {
                $q->where('study_program', $lecturer->study_program);
            });

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'submitted');
        }

        $internships = $query->latest()->paginate(10)->withQueryString();

        return view('lecturer.internships.index', compact('internships'));
    }

    /**
     * Display a listing of students assigned to the lecturer.
     */
    public function myStudents(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = request()->user();
        $lecturer = $user->lecturer;

        $query = Internship::with(['student.user', 'company', 'internshipPeriod', 'finalGrade'])
            ->where('lecturer_id', $lecturer->id)
            ->whereIn('status', ['approved', 'finished']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $students = $query->latest()->paginate(10)->withQueryString();

        return view('lecturer.students.index', compact('students'));
    }

    /**
     * Show the detailed application to approve / reject.
     */
    public function show(Internship $internship)
    {
        $lecturer = request()->user()->lecturer;
        $internship->load('student');

        if ($internship->status === 'submitted') {
            if ($internship->student->study_program !== $lecturer->study_program) {
                abort(403, 'Anda tidak berhak melihat pengajuan dari prodi lain.');
            }
        } else {
            if ($internship->lecturer_id !== $lecturer->id) {
                abort(403, 'Anda tidak berhak melihat data mahasiswa ini.');
            }
        }

        $internship->load(['student.user', 'company', 'internshipPeriod', 'documents']);
        return view('lecturer.internships.show', compact('internship'));
    }

    /**
     * Update the status (Approve / Reject) and set lecturer_id if approved.
     */
    public function updateStatus(UpdateInternshipStatusRequest $request, Internship $internship)
    {
        /** @var \App\Models\User $user */
        $user = request()->user();
        $lecturer = $user->lecturer;

        if ($internship->status !== 'submitted') {
            abort(403, 'Pengajuan ini sudah diproses.');
        }
        
        $internship->load('student');
        if ($internship->student->study_program !== $lecturer->study_program) {
            abort(403, 'Anda tidak berhak memproses pengajuan dari prodi lain.');
        }

        $internship->update([
            'status'         => $request->status,
            'rejection_note' => $request->status === 'rejected' ? $request->rejection_note : null,
            'lecturer_id'    => $request->status === 'approved' ? $lecturer->id : null,
        ]);

        $statusText = $request->status === 'approved' ? 'disetujui' : 'ditolak';
        
        // Kirim Notifikasi via NotificationService
        NotificationService::send(
            $internship->student->user_id,
            "Pengajuan Magang {$statusText}",
            "Pengajuan magang Anda di {$internship->company->name} telah {$statusText}.",
            'status_update',
            'internships',
            $internship->id
        );

        // Log Activity
        ActivityLogger::log(
            "internship_{$request->status}",
            "Pengajuan magang {$internship->student->user->name} di {$internship->company->name} {$statusText}",
            $internship
        );

        return redirect()->route('lecturer.internships.index')
            ->with('success', "Pengajuan magang berhasil {$statusText}.");
    }

    /**
     * Submit final grade for the student.
     */
    public function grade(Request $request, Internship $internship)
    {
        /** @var \App\Models\User $user */
        $user = request()->user();
        $lecturer = $user->lecturer;

        // Security check
        if ($internship->lecturer_id !== $lecturer->id || $internship->status !== 'approved') {
            abort(403, 'Anda tidak berhak memberikan nilai untuk magang ini.');
        }

        $validated = $request->validate([
            'report_grade'       => 'required|numeric|min:0|max:100',
            'presentation_grade' => 'required|numeric|min:0|max:100',
            'attitude_grade'     => 'required|numeric|min:0|max:100',
            'notes'              => 'nullable|string|max:1000',
        ]);

        // Calculate final grade (40/30/30)
        $finalGrade = ($validated['report_grade'] * 0.4) + 
                      ($validated['presentation_grade'] * 0.3) + 
                      ($validated['attitude_grade'] * 0.3);

        DB::transaction(function () use ($internship, $lecturer, $validated, $finalGrade) {
            FinalGrade::updateOrCreate(
                ['internship_id' => $internship->id],
                [
                    'lecturer_id'        => $lecturer->id,
                    'report_grade'       => $validated['report_grade'],
                    'presentation_grade' => $validated['presentation_grade'],
                    'attitude_grade'     => $validated['attitude_grade'],
                    'final_grade'        => $finalGrade,
                    'notes'              => $validated['notes'],
                    'grading_date'       => now(),
                ]
            );

            $internship->update(['status' => 'finished']);
        });

        // Notify student
        NotificationService::send(
            $internship->student->user_id,
            'Penilaian Akhir Selesai',
            "Dosen pembimbing telah memberikan nilai akhir untuk magang Anda di {$internship->company->name}.",
            'status_update',
            'internships',
            $internship->id
        );

        ActivityLogger::log(
            "internship_graded",
            "Memberikan nilai akhir untuk mahasiswa {$internship->student->user->name}",
            $internship
        );

        return redirect()->back()->with('success', 'Nilai akhir berhasil disimpan.');
    }
}
