<?php

// app/Http/Requests/Admin/StoreUserRequest.php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'          => ['required', 'string', 'max:255'],
            'username'      => ['required', 'string', 'max:50', 'unique:users,username'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
            'role'          => ['required', 'in:student,lecturer'],
            'study_program' => ['required_if:role,student', 'nullable', 'string', 'max:100'],
            'cohort_year'   => ['required_if:role,student', 'nullable', 'digits:4', 'integer'],
            'phone_number'  => ['nullable', 'string', 'max:20'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'          => 'Nama Lengkap',
            'username'      => 'Username / NIM / NIP',
            'password'      => 'Password',
            'role'          => 'Role',
            'study_program' => 'Program Studi',
            'cohort_year'   => 'Angkatan',
            'phone_number'  => 'Nomor HP',
        ];
    }

    public function messages(): array
    {
        return [
            'study_program.required_if' => 'Program Studi wajib diisi untuk mahasiswa.',
            'cohort_year.required_if'   => 'Angkatan wajib diisi untuk mahasiswa.',
        ];
    }
}
