<?php

// app/Http/Requests/Admin/StoreCompanyRequest.php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
            'name'           => ['required', 'string', 'max:255'],
            'address'        => ['required', 'string', 'max:500'],
            'industry'       => ['required', 'string', 'max:100'],
            'contact_person' => ['required', 'string', 'max:100'],
            'contact_email'  => ['nullable', 'email', 'max:100'],
            'contact_phone'  => ['nullable', 'string', 'max:20'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'           => 'Nama Perusahaan',
            'address'        => 'Alamat',
            'industry'       => 'Bidang Industri',
            'contact_person' => 'Nama Kontak',
            'contact_email'  => 'Email Kontak',
            'contact_phone'  => 'Telepon Kontak',
        ];
    }
}
