<?php

namespace App\Http\Requests\Lecturer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMentorshipSessionRequest extends FormRequest
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
            'date'           => ['required', 'date'],
            'topic'          => ['required', 'string', 'max:500'],
            'lecturer_notes' => ['nullable', 'string', 'max:2000'],
            'feedback'       => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'date'           => 'Tanggal & Jam',
            'topic'          => 'Topik Bimbingan',
            'lecturer_notes' => 'Catatan Dosen',
            'feedback'       => 'Feedback untuk Mahasiswa',
        ];
    }
}
