<?php

// app/Http/Controllers/Lecturer/MentorshipSessionController.php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lecturer\StoreMentorshipSessionRequest;
use App\Http\Requests\Lecturer\UpdateMentorshipSessionRequest;
use App\Models\Internship;
use App\Models\MentorshipSession;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorshipSessionController extends Controller
{
    /**
     * Get current lecturer's ID.
     */
    private function lecturerId(): int
    {
        return Auth::user()->lecturer->id;
    }

    /**
     * Display a listing of mentorship sessions.
     */
    public function index(Request $request)
    {
        $lecturerId = $this->lecturerId();

        $query = MentorshipSession::with(['internship.student.user', 'internship.company'])
            ->whereHas('internship', fn ($q) => $q->where('lecturer_id', $lecturerId));

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('internship.student.user', fn ($q) =>
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
            );
        }

        $sessions = $query->orderByDesc('date')->paginate(10)->withQueryString();

        return view('lecturer.mentorship_sessions.index', compact('sessions'));
    }

    /**
     * Show the form for creating a new mentorship session.
     */
    public function create()
    {
        $internships = Internship::with(['student.user', 'company'])
            ->where('lecturer_id', $this->lecturerId())
            ->where('status', 'approved')
            ->get();

        return view('lecturer.mentorship_sessions.create', compact('internships'));
    }

    /**
     * Store a newly created mentorship session.
     */
    public function store(StoreMentorshipSessionRequest $request)
    {
        // Verify ownership
        $internship = Internship::where('lecturer_id', $this->lecturerId())
            ->where('status', 'approved')
            ->findOrFail($request->internship_id);

        $session = MentorshipSession::create([
            'internship_id' => $internship->id,
            'date'          => $request->date,
            'topic'         => $request->topic,
            'status'        => 'scheduled',
        ]);

        \App\Services\ActivityLogService::log(
            "create_mentorship_session",
            "mentorship_sessions",
            "Scheduled mentorship session on {$session->date} for {$internship->student->user->name}"
        );

        // Notify Student
        NotificationService::send(
            $internship->student->user_id,
            'Jadwal Bimbingan Baru',
            'Dosen pembimbing Anda telah menjadwalkan sesi bimbingan pada ' . \Carbon\Carbon::parse($session->date)->translatedFormat('d M Y, H:i') . ' dengan topik: ' . $session->topic,
            'info',
            'mentorship_sessions',
            $session->id
        );

        return redirect()->route('lecturer.mentorship_sessions.index')
            ->with('success', 'Sesi bimbingan berhasil dijadwalkan.');
    }

    /**
     * Display the specified mentorship session.
     */
    public function show(MentorshipSession $mentorshipSession)
    {
        $this->authorize('view', $mentorshipSession);

        $mentorshipSession->load(['internship.student.user', 'internship.company']);

        return view('lecturer.mentorship_sessions.show', compact('mentorshipSession'));
    }

    /**
     * Show the form for editing the specified mentorship session.
     */
    public function edit(MentorshipSession $mentorshipSession)
    {
        $this->authorize('view', $mentorshipSession);

        $mentorshipSession->load(['internship.student.user', 'internship.company']);

        return view('lecturer.mentorship_sessions.edit', compact('mentorshipSession'));
    }

    /**
     * Update the specified mentorship session.
     */
    public function update(UpdateMentorshipSessionRequest $request, MentorshipSession $mentorshipSession)
    {
        $this->authorize('view', $mentorshipSession);

        $oldDate = $mentorshipSession->date;

        $mentorshipSession->update($request->validated());

        \App\Services\ActivityLogService::log(
            "update_mentorship_session",
            "mentorship_sessions",
            "Updated mentorship session {$mentorshipSession->id}"
        );

        // Notify student if schedule changed
        if ($oldDate != $mentorshipSession->date) {
            NotificationService::send(
                $mentorshipSession->internship->student->user_id,
                'Jadwal Bimbingan Diubah',
                'Jadwal sesi bimbingan telah diubah ke ' . \Carbon\Carbon::parse($mentorshipSession->date)->translatedFormat('d M Y, H:i') . '.',
                'warning',
                'mentorship_sessions',
                $mentorshipSession->id
            );
        }

        return redirect()->route('lecturer.mentorship_sessions.show', $mentorshipSession)
            ->with('success', 'Data sesi bimbingan berhasil diperbarui.');
    }

    /**
     * Mark session as completed — with notes and feedback.
     */
    public function complete(Request $request, MentorshipSession $mentorshipSession)
    {
        $this->authorize('view', $mentorshipSession);

        $request->validate([
            'lecturer_notes' => ['nullable', 'string', 'max:2000'],
            'feedback'       => ['nullable', 'string', 'max:2000'],
        ]);

        $mentorshipSession->update([
            'status'         => 'completed',
            'lecturer_notes' => $request->lecturer_notes,
            'feedback'       => $request->feedback,
        ]);

        \App\Services\ActivityLogService::log(
            "complete_mentorship_session",
            "mentorship_sessions",
            "Completed mentorship session {$mentorshipSession->id}"
        );

        NotificationService::send(
            $mentorshipSession->internship->student->user_id,
            'Sesi Bimbingan Selesai',
            'Sesi bimbingan pada ' . \Carbon\Carbon::parse($mentorshipSession->date)->translatedFormat('d M Y') . ' telah ditandai selesai oleh dosen pembimbing.',
            'status_update',
            'mentorship_sessions',
            $mentorshipSession->id
        );

        return redirect()->route('lecturer.mentorship_sessions.show', $mentorshipSession)
            ->with('success', 'Sesi bimbingan ditandai selesai.');
    }

    /**
     * Cancel a scheduled session.
     */
    public function cancel(MentorshipSession $mentorshipSession)
    {
        $this->authorize('view', $mentorshipSession);

        $mentorshipSession->update(['status' => 'canceled']);

        \App\Services\ActivityLogService::log(
            "cancel_mentorship_session",
            "mentorship_sessions",
            "Canceled mentorship session {$mentorshipSession->id}"
        );

        NotificationService::send(
            $mentorshipSession->internship->student->user_id,
            'Sesi Bimbingan Dibatalkan',
            'Sesi bimbingan pada ' . \Carbon\Carbon::parse($mentorshipSession->date)->translatedFormat('d M Y, H:i') . ' telah dibatalkan.',
            'warning',
            'mentorship_sessions',
            $mentorshipSession->id
        );

        return redirect()->route('lecturer.mentorship_sessions.index')
            ->with('success', 'Sesi bimbingan berhasil dibatalkan.');
    }
}
