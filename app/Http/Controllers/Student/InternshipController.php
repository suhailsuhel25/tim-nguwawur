<?php

// app/Http/Controllers/Student/InternshipController.php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreInternshipRequest;
use App\Models\Company;
use App\Models\Internship;
use App\Models\InternshipPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InternshipController extends Controller
{
    /**
     * Display a listing of the internships (History for Student).
     */
    public function index()
    {
        $student = request()->user()->student;

        $internships = Internship::with(['company', 'internshipPeriod', 'lecturer.user'])
            ->where('student_id', $student->id)
            ->latest()
            ->paginate(10);

        return view('student.internships.index', compact('internships'));
    }

    /**
     * Show the form for creating a new internship.
     */
    public function create()
    {
        $activePeriods = InternshipPeriod::where('is_active', true)->get();
        $companies     = Company::orderBy('name')->get();

        return view('student.internships.create', compact('activePeriods', 'companies'));
    }

    /**
     * Store a newly created internship in storage.
     */
    public function store(StoreInternshipRequest $request)
    {
        $student = request()->user()->student;

        DB::transaction(function () use ($request, $student) {
            $internship = Internship::create([
                'student_id'           => $student->id,
                'company_id'           => $request->company_id,
                'internship_period_id' => $request->internship_period_id,
                'start_date'           => $request->start_date,
                'end_date'             => $request->end_date,
                'status'               => 'submitted',
            ]);

            $documentTypes = [
                'cover_letter' => 'recommendation_letter',
                'cv'           => 'cv',
                'proposal'     => 'proposal'
            ];

            foreach ($documentTypes as $requestKey => $dbType) {
                if ($request->hasFile($requestKey)) {
                    $file     = $request->file($requestKey);
                    $fileName = time() . '_' . $student->id . '_' . $requestKey . '.' . $file->extension();
                    $filePath = $file->storeAs('private/internships/' . $internship->id, $fileName);

                    $internship->documents()->create([
                        'document_type' => $dbType,
                        'file_name'     => $file->getClientOriginalName(),
                        'file_path'     => $filePath,
                    ]);
                }
            }
        });

        return redirect()->route('student.internships.index')
            ->with('success', 'Pengajuan magang berhasil dikirim. Menunggu persetujuan dosen.');
    }
}
