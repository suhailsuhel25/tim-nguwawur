<?php

// app/Http/Requests/Admin/UpdateInternshipPeriodRequest.php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInternshipPeriodRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = $this->user();

        return $user !== null && $user->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:100'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after:start_date'],
            'is_active'  => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'       => 'Nama Periode',
            'start_date' => 'Tanggal Mulai',
            'end_date'   => 'Tanggal Selesai',
            'is_active'  => 'Status Aktif',
        ];
    }

    public function messages(): array
    {
        return [
            'end_date.after' => 'Tanggal Selesai harus setelah Tanggal Mulai.',
        ];
    }
}
