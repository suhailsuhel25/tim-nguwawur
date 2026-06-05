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

        // 2. Buat Akun Dosen (Fixed)
        $dosenFixed = User::create([
            'name' => 'Dr. Budi Santoso, M.Kom.',
            'username' => '198001012005011001', // NIP Dosen
            'password' => Hash::make('password'),
            'role' => 'lecturer',
        ]);

        Lecturer::create([
            'user_id' => $dosenFixed->id,
        ]);

    }
}
