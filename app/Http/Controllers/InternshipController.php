<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        
        $query = Internship::with(['student', 'company', 'lecturer', 'internshipPeriod']);

        // Filter berdasarkan role
        if ($user->role === 'student') {
            $query->where('student_id', $user->student->id);
        } elseif ($user->role === 'lecturer') {
            $query->where('lecturer_id', $user->lecturer->id);
        }
        // Admin bisa melihat semua

        $internships = $query->latest()->get();

        return view('internships.index', compact('internships'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        // Hanya mahasiswa yang bisa mendaftar magang
        if ($user->role !== 'student') {
            return redirect()->back()->with('error', 'Hanya mahasiswa yang bisa mendaftar.');
        }

        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'internship_period_id' => 'required|exists:internship_periods,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $internship = Internship::create([
            'student_id' => $user->student->id,
            'company_id' => $validated['company_id'],
            'internship_period_id' => $validated['internship_period_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => 'submitted', // Langsung diajukan setelah store
        ]);

        return redirect()->route('internships.index')->with('success', 'Pendaftaran magang berhasil diajukan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $internship = Internship::with([
            'student.user', 'company', 'lecturer.user', 'internshipPeriod', 
            'documents', 'weeklyReports', 'mentorshipSessions', 'finalGrade'
        ])->findOrFail($id);

        return view('internships.show', compact('internship'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $internship = Internship::findOrFail($id);
        
        /** @var \App\Models\User $user */
        $user = $request->user();

        // Contoh: Dosen menyetujui atau menolak
        if ($user->role === 'lecturer') {
            $validated = $request->validate([
                'status' => 'required|in:approved,rejected',
                'rejection_note' => 'nullable|string|required_if:status,rejected',
            ]);

            $internship->update([
                'status' => $validated['status'],
                'rejection_note' => $validated['rejection_note'] ?? null,
                'lecturer_id' => $user->lecturer->id, // Assign dosen yang mengapprove
            ]);

            return redirect()->route('internships.show', $internship->id)->with('success', 'Status pendaftaran berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Unauthorized action');
    }
}
