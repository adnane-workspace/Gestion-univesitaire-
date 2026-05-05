<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Professor;
use App\Models\Filiere;
use App\Models\Module;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Administrateur par défaut
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@universite.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Création des Filières
        $filiereGinf = Filiere::create(['name' => 'Génie Informatique', 'code' => 'GINF', 'duration_years' => 3]);
        $filiereMe = Filiere::create(['name' => 'Management des Entreprises', 'code' => 'ME', 'duration_years' => 3]);

        // 3. Création des Modules (Basé sur l'emploi du temps GINF)
        $modulesData = [
            ['name' => 'Base de données SQL server', 'code' => 'SQL01', 'credits' => 6, 'hours' => 45, 'semester' => 6, 'filiere_id' => $filiereGinf->id],
            ['name' => 'Projet (Gaming)', 'code' => 'PROJ01', 'credits' => 4, 'hours' => 30, 'semester' => 6, 'filiere_id' => $filiereGinf->id],
            ['name' => 'Intelligence Artificielle 1', 'code' => 'IA01', 'credits' => 6, 'hours' => 40, 'semester' => 6, 'filiere_id' => $filiereGinf->id],
            ['name' => 'Développement mobile', 'code' => 'MOB01', 'credits' => 6, 'hours' => 40, 'semester' => 6, 'filiere_id' => $filiereGinf->id],
            ['name' => 'Programmation orientée objet JAVA 2', 'code' => 'JAVA02', 'credits' => 6, 'hours' => 45, 'semester' => 6, 'filiere_id' => $filiereGinf->id],
            ['name' => 'Technologies web 2 (php & MySQL/Framework)', 'code' => 'WEB02', 'credits' => 6, 'hours' => 45, 'semester' => 6, 'filiere_id' => $filiereGinf->id],
            ['name' => 'Anglais / Patrimoine artistique', 'code' => 'ANG01', 'credits' => 4, 'hours' => 30, 'semester' => 6, 'filiere_id' => $filiereGinf->id],
        ];

        foreach ($modulesData as $m) {
            Module::create($m);
        }

        // 4. Création des Salles
        Room::create(['name' => 'Salle A37', 'code' => 'A37', 'type' => 'classroom', 'capacity' => 40, 'building' => 'Bloc A', 'floor' => 3]);
        Room::create(['name' => 'Amphi E2', 'code' => 'E2', 'type' => 'amphi', 'capacity' => 150, 'building' => 'Bloc E', 'floor' => 0]);

        // 5. Professeurs de l'emploi du temps
        $professorsFromSchedule = [
            ['first_name' => 'Soufyane', 'last_name' => 'MEJDOUB', 'speciality' => 'Base de données'],
            ['first_name' => 'Tarik', 'last_name' => 'HAJJI', 'speciality' => 'Programmation/Gaming'],
            ['first_name' => 'Jamal', 'last_name' => 'RIFFI', 'speciality' => 'Intelligence Artificielle'],
            ['first_name' => 'Naouar', 'last_name' => 'BELGHINI', 'speciality' => 'Développement Mobile'],
            ['first_name' => 'Marwan', 'last_name' => 'KZADRI', 'speciality' => 'Technologies Web'],
            ['first_name' => 'Bouasria', 'last_name' => 'SALIM', 'speciality' => 'Anglais'],
            ['first_name' => 'Lhoucine', 'last_name' => 'OUAZZANI', 'speciality' => 'Anglais/Patrimoine'],
        ];

        foreach ($professorsFromSchedule as $p) {
            $fullName = $p['first_name'] . ' ' . $p['last_name'];
            $email = Str::slug($fullName, '.') . '@universite.com';

            $user = User::create([
                'name' => $fullName,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'professeur',
            ]);

            Professor::create([
                'user_id' => $user->id,
                'first_name' => $p['first_name'],
                'last_name' => $p['last_name'],
                'email' => $email,
                'speciality' => $p['speciality'],
                'hire_date' => now()->subYears(rand(1, 10)),
            ]);
        }

        // 6. Liste des noms (Étudiants)
        $names = [
            "Abdellah Bouabdli", "Ahmed El Kalai", "Er-Rajy Hanae", "Ibrahimi Hiba", "El Attar Soufi Rabie",
            "Bentaleb Chaymae", "Faridi Marwane", "Sahmoudi Aya", "Mendari Malak", "Boutarfass Kenza",
            "El Menouar Adnane", "Nahli Amine", "Mohammed Bouzidi Idrissi", "Younes Basir", "Mohamed Zoubaa",
            "Hatim Rhassik", "Wajih Beladem", "Tastaoute Mohamed", "Ilal Safia", "Seghrouchni Salma",
            "Hind Berrada", "Wiam Bokouk", "Ibtissam Gaizi", "Menai Douae", "Taouaf Mariam", "Doha Alaoui",
            "Malak Tob", "Tasnim Kharbache", "Fatima Zahra El Mahdy", "Marwa Hmyddouch", "Barassa Douae",
            "Mejber Ali", "Bouaicha Fadoua", "Ouahmane Hiba", "Yassine El Ansari", "Mohammed Sadiki",
            "Abdessamad Kaf", "El Moumen Aicha", "Medaoui Ikram"
        ];
        
        foreach ($names as $fullName) {
            $parts = explode(' ', $fullName);
            $firstName = $parts[0];
            $lastName = isset($parts[1]) ? implode(' ', array_slice($parts, 1)) : 'Student';
            $email = Str::slug($fullName, '.') . '@student.com';

            $user = User::create([
                'name' => $fullName,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'etudiant',
            ]);

            Student::create([
                'user_id' => $user->id,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'student_id_number' => 'STU-' . strtoupper(Str::random(6)),
                'birth_date' => now()->subYears(rand(18, 25)),
                'address' => 'Adresse Ville ' . rand(1, 10),
            ]);
        }
    }
}
