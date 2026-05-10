<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Company;
use App\Models\InternshipPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('password'), // standard password
            'role' => 'admin',
        ]);

        // 2. Buat Akun Dosen
        $dosen = User::create([
            'name' => 'Dr. Budi Santoso',
            'username' => '198001012005011001', // NIP Dosen
            'password' => Hash::make('password'),
            'role' => 'lecturer',
        ]);
        
        Lecturer::create([
            'user_id' => $dosen->id,
            'phone_number' => '081234567890',
        ]);

        // 3. Buat Akun Mahasiswa
        $mahasiswa = User::create([
            'name' => 'Andi Pratama',
            'username' => '230010012', // NIM Mahasiswa
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
        
        Student::create([
            'user_id' => $mahasiswa->id,
            'study_program' => 'Teknik Informatika',
            'cohort_year' => '2023',
            'phone_number' => '089876543210',
        ]);

        // 4. Buat Data Dummy Perusahaan
        Company::create([
            'name' => 'PT Semesta Teknologi',
            'address' => 'Jl. Jendral Sudirman No. 123, Jakarta',
            'industry' => 'Software Development',
            'contact_person' => 'Sari Wijaya (HRD)',
            'contact_email' => 'hr@semestatekno.com',
            'contact_phone' => '021-5551234',
        ]);

        // 5. Buat Data Dummy Periode Magang
        InternshipPeriod::create([
            'name' => 'Ganjil 2026/2027',
            'start_date' => Carbon::now()->addDays(7),
            'end_date' => Carbon::now()->addMonths(4),
            'is_active' => true,
        ]);
    }
}
