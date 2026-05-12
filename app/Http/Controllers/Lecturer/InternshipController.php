<?php

// app/Http/Controllers/Lecturer/InternshipController.php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lecturer\UpdateInternshipStatusRequest;
use App\Models\Internship;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    /**
     * Display a listing of upcoming applications.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = request()->user();
        $lecturer = $user->lecturer;

        $query = Internship::with(['student.user', 'company', 'internshipPeriod'])
            ->where(function ($q) use ($lecturer) {
                // Show submitted (pending) to all lecturers, or show their own assigned
                $q->where('status', 'submitted')
                  ->orWhere('lecturer_id', $lecturer->id);
            });

        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'pending') {
                $query->where('status', 'submitted');
            } else {
                $query->where('status', $status);
            }
        }

        $internships = $query->latest()->paginate(10)->withQueryString();

        return view('lecturer.internships.index', compact('internships'));
    }

    /**
     * Show the detailed application to approve / reject.
     */
    public function show(Internship $internship)
    {
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
            route('student.internships.index') // Note: need to make sure this route is correct
        );

        return redirect()->route('lecturer.internships.index')
            ->with('success', "Pengajuan magang berhasil {$statusText}.");
    }
}
