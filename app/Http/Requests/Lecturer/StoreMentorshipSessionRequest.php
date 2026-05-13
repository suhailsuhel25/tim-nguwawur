<?php

namespace App\Http\Requests\Lecturer;

use Illuminate\Foundation\Http\FormRequest;

class StoreMentorshipSessionRequest extends FormRequest
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
            'internship_id' => ['required', 'exists:internships,id'],
            'date'          => ['required', 'date', 'after:now'],
            'topic'         => ['required', 'string', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'internship_id' => 'Mahasiswa Bimbingan',
            'date'          => 'Tanggal & Jam',
            'topic'         => 'Topik Bimbingan',
        ];
    }

    public function messages(): array
    {
        return [
            'date.after' => 'Jadwal sesi harus di masa depan.',
        ];
    }
}
