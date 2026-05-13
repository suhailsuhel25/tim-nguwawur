<?php

// app/Http/Requests/Lecturer/UpdateInternshipStatusRequest.php

namespace App\Http\Requests\Lecturer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInternshipStatusRequest extends FormRequest
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
            'status'         => ['required', 'in:approved,rejected'],
            'rejection_note' => ['required_if:status,rejected', 'nullable', 'string', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'status'         => 'Status Persetujuan',
            'rejection_note' => 'Catatan Penolakan',
        ];
    }
}
