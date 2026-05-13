<?php

namespace App\Http\Requests\Lecturer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWeeklyReportStatusRequest extends FormRequest
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
            'status' => ['required', 'in:submitted,validated'],
        ];
    }

    public function attributes(): array
    {
        return [
            'status' => 'Status Laporan',
        ];
    }
}
