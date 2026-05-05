<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        // Admin bisa melihat semua, jadi tidak ada filter tambahan

        $internships = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $internships
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        // Hanya mahasiswa yang bisa mendaftar magang
        // Walau harusnya validasi ini taruh di Request class/Policy, untuk simpel bisa cek di sini:
        if ($user->role !== 'student') {
            return response()->json(['success' => false, 'message' => 'Hanya mahasiswa yang bisa mendaftar.'], 403);
        }

        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'internship_period_id' => 'required|exists:internship_periods,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            // Dokumen divalidasi nanti via InternshipDocumentController / di handle terpisah atau disini juga bisa
        ]);

        // Simpan pendaftaran dengan status otomatis 'draft' atau 'submitted'
        $internship = Internship::create([
            'student_id' => $user->student->id,
            'company_id' => $validated['company_id'],
            'internship_period_id' => $validated['internship_period_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => 'submitted', // Langsung diajukan setelah store
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran magang berhasil diajukan',
            'data' => $internship
        ], 201);
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

        return response()->json([
            'success' => true,
            'data' => $internship
        ]);
    }

    /**
     * Update the specified resource in storage. (Approval/Rejection by Lecturer / Edit by Student)
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

            return response()->json([
                'success' => true,
                'message' => 'Status pendaftaran berhasil diperbarui',
                'data' => $internship
            ]);
        }

        // Kalau butuh flow mahasiswa update tanggal sebelum diapprove, bisa ditambahkan logic di sini
        return response()->json(['success' => false, 'message' => 'Unauthorized action'], 403);
    }
}