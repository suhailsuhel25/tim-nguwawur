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
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $password = Hash::make('password');

        // 1. Buat Akun Admin (1)
        User::create([
            'name' => 'Administrator Utama',
            'username' => 'admin',
            'password' => $password,
            'role' => 'admin',
        ]);

        // 2. Buat Akun Dosen (3)
        for ($i = 1; $i <= 3; $i++) {
            $dosen = User::create([
                'name' => $faker->name('male') . ', S.Kom., M.Kom.',
                'username' => '1980' . $faker->randomNumber(8, true),
                'password' => $password,
                'role' => 'lecturer',
            ]);
            
            Lecturer::create([
                'user_id' => $dosen->id,
                'phone_number' => $faker->phoneNumber(),
            ]);
        }

        // 3. Buat Akun Mahasiswa (10)
        for ($i = 1; $i <= 10; $i++) {
            $mahasiswa = User::create([
                'name' => $faker->name(),
                'username' => '2300' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'password' => $password,
                'role' => 'student',
            ]);
            
            Student::create([
                'user_id' => $mahasiswa->id,
                'study_program' => $faker->randomElement(['Teknik Informatika', 'Sistem Informasi', 'Sains Data']),
                'cohort_year' => $faker->randomElement(['2022', '2023']),
                'phone_number' => $faker->phoneNumber(),
            ]);
        }

        // 4. Buat Data Dummy Perusahaan (5)
        for ($i = 1; $i <= 5; $i++) {
            Company::create([
                'name' => 'PT ' . $faker->company(),
                'address' => $faker->address(),
                'industry' => $faker->randomElement(['Software Development', 'IT Consultant', 'Digital Agency', 'E-Commerce']),
                'contact_person' => $faker->name(),
                'contact_email' => $faker->companyEmail(),
                'contact_phone' => $faker->phoneNumber(),
            ]);
        }

        // 5. Buat Data Dummy Periode Magang (2)
        InternshipPeriod::create([
            'name' => 'Ganjil 2026/2027',
            'start_date' => Carbon::now()->subMonths(1),
            'end_date' => Carbon::now()->addMonths(3),
            'is_active' => true,
        ]);

        InternshipPeriod::create([
            'name' => 'Genap 2026/2027',
            'start_date' => Carbon::now()->addMonths(5),
            'end_date' => Carbon::now()->addMonths(9),
            'is_active' => false,
        ]);
    }
}
