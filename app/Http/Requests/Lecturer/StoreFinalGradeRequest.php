<?php

namespace App\Http\Requests\Lecturer;

use Illuminate\Foundation\Http\FormRequest;

class StoreFinalGradeRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = $this->user();

        return $user !== null && $user->role === 'lecturer';
    }

    public function rules(): array
    {
        return [
            'internship_id'      => ['required', 'exists:internships,id', 'unique:final_grades,internship_id'],
            'report_grade'       => ['required', 'numeric', 'min:0', 'max:100'],
            'presentation_grade' => ['required', 'numeric', 'min:0', 'max:100'],
            'attitude_grade'     => ['required', 'numeric', 'min:0', 'max:100'],
            'notes'              => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'internship_id'      => 'Mahasiswa',
            'report_grade'       => 'Nilai Laporan',
            'presentation_grade' => 'Nilai Presentasi',
            'attitude_grade'     => 'Nilai Sikap',
            'notes'              => 'Catatan',
        ];
    }

    public function messages(): array
    {
        return [
            'internship_id.unique' => 'Mahasiswa ini sudah memiliki penilaian akhir.',
            'report_grade.max'     => 'Nilai maksimal adalah 100.',
            'presentation_grade.max' => 'Nilai maksimal adalah 100.',
            'attitude_grade.max'   => 'Nilai maksimal adalah 100.',
        ];
    }
}
