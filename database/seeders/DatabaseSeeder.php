<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pengguna untuk Login
        User::create([
            'name' => 'Admin HRD',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        // 2. Data Departemen
        $ti = Department::create(['name' => 'Teknologi Informasi']);
        $hrd = Department::create(['name' => 'Sumber Daya Manusia']);
        $keuangan = Department::create(['name' => 'Keuangan']);

        // 3. Data Pegawai
        Employee::create([
            'department_id' => $ti->id,
            'name' => 'Andi Saputra',
            'position' => 'Backend Developer',
            'salary' => 8000000,
            'joined_at' => '2022-03-01',
        ]);

        Employee::create([
            'department_id' => $ti->id,
            'name' => 'Budi Santoso',
            'position' => 'Frontend Developer',
            'salary' => 7500000,
            'joined_at' => '2023-01-15',
        ]);

        Employee::create([
            'department_id' => $hrd->id,
            'name' => 'Citra Lestari',
            'position' => 'HR Specialist',
            'salary' => 6500000,
            'joined_at' => '2021-07-10',
        ]);

        Employee::create([
            'department_id' => $keuangan->id,
            'name' => 'Dian Permata',
            'position' => 'Akuntan',
            'salary' => 7000000,
            'joined_at' => '2020-11-20',
        ]);

        Employee::create([
            'department_id' => $hrd->id,
            'name' => 'Eko Prasetyo',
            'position' => 'Recruiter',
            'salary' => 6000000,
            'joined_at' => '2024-02-05',
        ]);
    }
}