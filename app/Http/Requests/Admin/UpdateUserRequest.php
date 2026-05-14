<?php

// app/Http/Requests/Admin/UpdateUserRequest.php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = $this->user();

        return $user !== null && $user->role === 'admin';
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'name'          => ['required', 'string', 'max:255'],
            'username'      => ['required', 'string', 'max:50', Rule::unique('users', 'username')->ignore($userId)],
            'password'      => ['nullable', 'string', 'min:8', 'confirmed'],
            'study_program' => ['required', 'string', Rule::in(\App\Models\Student::STUDY_PROGRAMS)],
            'cohort_year'   => ['nullable', 'digits:4', 'integer'],
            'phone_number'  => ['nullable', 'string', 'max:20'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'          => 'Nama Lengkap',
            'username'      => 'Username / NIM / NIP',
            'password'      => 'Password',
            'study_program' => 'Program Studi',
            'cohort_year'   => 'Angkatan',
            'phone_number'  => 'Nomor HP',
        ];
    }
}
