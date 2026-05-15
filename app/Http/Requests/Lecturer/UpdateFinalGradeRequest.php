<?php

namespace App\Http\Requests\Lecturer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFinalGradeRequest extends FormRequest
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
            'report_grade'       => ['required', 'numeric', 'min:0', 'max:100'],
            'presentation_grade' => ['required', 'numeric', 'min:0', 'max:100'],
            'attitude_grade'     => ['required', 'numeric', 'min:0', 'max:100'],
            'notes'              => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'report_grade'       => 'Nilai Laporan',
            'presentation_grade' => 'Nilai Presentasi',
            'attitude_grade'     => 'Nilai Sikap',
            'notes'              => 'Catatan',
        ];
    }
}
