<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer les utilisateurs de test avec les 3 rôles
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@universite.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Professeur Dupont',
            'email' => 'professeur@universite.com',
            'password' => bcrypt('password'),
            'role' => 'professeur',
        ]);

        User::create([
            'name' => 'Étudiant Martin',
            'email' => 'etudiant@universite.com',
            'password' => bcrypt('password'),
            'role' => 'etudiant',
        ]);
    }
}
