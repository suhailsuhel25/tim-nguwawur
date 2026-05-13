<?php

// app/Http/Requests/Student/StoreInternshipRequest.php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreInternshipRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = $this->user();

        return $user !== null && $user->role === 'student' && $user->student;
    }

    public function rules(): array
    {
        return [
            'company_id'           => ['required', 'exists:companies,id'],
            'internship_period_id' => ['required', 'exists:internship_periods,id'],
            'start_date'           => ['required', 'date'],
            'end_date'             => ['required', 'date', 'after:start_date'],
            'cover_letter'         => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'cv'                   => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'proposal'             => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'company_id'           => 'Perusahaan',
            'internship_period_id' => 'Periode Magang',
            'cover_letter'         => 'Surat Pengantar (Cover Letter)',
            'cv'                   => 'Curriculum Vitae (CV)',
            'proposal'             => 'Proposal Magang',
        ];
    }
}
