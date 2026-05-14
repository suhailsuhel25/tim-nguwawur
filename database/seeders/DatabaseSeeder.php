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

        // 1. Buat Akun Admin (1)
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Buat Akun Dosen (3)
        for ($i = 1; $i <= 3; $i++) {
            $dosen = User::create([
                'name' => $faker->name . ', M.Kom.',
                'username' => $faker->unique()->numerify('198#######200#######'),
                'password' => Hash::make('password'),
                'role' => 'lecturer',
            ]);
            
            Lecturer::create([
                'user_id' => $dosen->id,
                'study_program' => $faker->randomElement(Student::STUDY_PROGRAMS),
                'phone_number' => $faker->phoneNumber,
            ]);
        }

        // 3. Buat Akun Mahasiswa (10)
        for ($i = 1; $i <= 10; $i++) {
            $mahasiswa = User::create([
                'name' => $faker->name,
                'username' => $faker->unique()->numerify('2300#####'),
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);
            
            Student::create([
                'user_id' => $mahasiswa->id,
                'study_program' => $faker->randomElement(Student::STUDY_PROGRAMS),
                'cohort_year' => $faker->randomElement(['2022', '2023']),
                'phone_number' => $faker->phoneNumber,
            ]);
        }

        // 4. Buat Data Dummy Perusahaan (5)
        for ($i = 1; $i <= 5; $i++) {
            Company::create([
                'name' => $faker->company,
                'address' => $faker->address,
                'industry' => $faker->randomElement(['Software Development', 'IT Consultant', 'Digital Agency', 'E-Commerce', 'Fintech']),
                'contact_person' => $faker->name,
                'contact_email' => $faker->companyEmail,
                'contact_phone' => $faker->phoneNumber,
            ]);
        }

        // 5. Buat Data Dummy Periode Magang (2)
        InternshipPeriod::create([
            'name' => 'Ganjil 2026/2027',
            'start_date' => Carbon::now()->addDays(7),
            'end_date' => Carbon::now()->addMonths(4),
            'is_active' => true,
        ]);

        InternshipPeriod::create([
            'name' => 'Genap 2025/2026',
            'start_date' => Carbon::now()->subMonths(6),
            'end_date' => Carbon::now()->subMonths(2),
            'is_active' => false,
        ]);
    }
}
