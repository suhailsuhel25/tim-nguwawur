<?php

// app/Http/Controllers/Student/MentorshipSessionController.php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\MentorshipSession;
use Illuminate\Support\Facades\Auth;

class MentorshipSessionController extends Controller
{
    /**
     * Display a listing of mentorship sessions for the student.
     */
    public function index()
    {
        $studentId = Auth::user()->student->id;

        $internshipIds = Internship::where('student_id', $studentId)
            ->where('status', 'approved')
            ->pluck('id');

        $sessions = MentorshipSession::with(['internship.lecturer.user', 'internship.company'])
            ->whereIn('internship_id', $internshipIds)
            ->orderByDesc('date')
            ->paginate(10);

        return view('student.mentorship_sessions.index', compact('sessions'));
    }

    /**
     * Display the specified mentorship session.
     */
    public function show(MentorshipSession $mentorshipSession)
    {
        // Auth check — session must belong to a student's internship
        if ($mentorshipSession->internship->student_id !== Auth::user()->student->id) {
            abort(403);
        }

        $mentorshipSession->load(['internship.lecturer.user', 'internship.company']);

        return view('student.mentorship_sessions.show', compact('mentorshipSession'));
    }
}
