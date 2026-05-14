<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreWeeklyReportRequest extends FormRequest
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
            'internship_id' => ['required', 'exists:internships,id'],
            'week_number' => ['required', 'integer', 'min:1'],
            'activity_description' => ['required', 'string'],
            'challenges' => ['nullable', 'string'],
            'next_week_plan' => ['nullable', 'string'],
            'documentation' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],

            
            // Daily Activities validation
            'daily_activities' => ['required', 'array', 'min:1'],
            'daily_activities.*.date' => ['required', 'date'],
            'daily_activities.*.activity_description' => ['required', 'string'],
            'daily_activities.*.duration_hours' => ['required', 'numeric', 'min:0.5', 'max:24'],
        ];
    }
}
