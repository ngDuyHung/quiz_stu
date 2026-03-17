<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar admin
        User::firstOrCreate(
            ['email' => 'admin@quizapp.com'],
            [
                'student_code' => 'ADMIN001',
                'password' => Hash::make('admin123'),
                'first_name' => 'Admin',
                'last_name' => 'User',
                'role' => 1, // Admin
                'status' => 'active',
            ]
        );

        // Criar usuário cliente de teste
        User::firstOrCreate(
            ['email' => 'student@quizapp.com'],
            [
                'student_code' => 'STU001',
                'password' => Hash::make('student123'),
                'first_name' => 'Student',
                'last_name' => 'User',
                'role' => 0, // Client/Student
                'status' => 'active',
            ]
        );
    }
}
