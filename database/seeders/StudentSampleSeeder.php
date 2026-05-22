<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentSampleSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'Etudiant Test',
            'email' => 'student@example.test',
            'password' => Hash::make('password'),
        ]);

        Student::create([
            'user_id' => $user->id,
            'filiere_id' => 1,
            'first_name' => 'Etudiant',
            'last_name' => 'Test',
            'email' => 'student@example.test',
            'student_id_number' => 'S-1001',
        ]);
    }
}
