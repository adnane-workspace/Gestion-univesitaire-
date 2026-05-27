<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Professor;
use App\Models\Filiere;
use App\Models\Module;
use App\Models\Room;
use App\Models\ModuleElement;
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\Absence;
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
        User::firstOrCreate([
            'email' => 'admin@universite.com',
        ], [
            'name' => 'Administrateur',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Création des Filières
        $filiereGinf = Filiere::firstOrCreate(['code' => 'GINF'], ['name' => 'Génie Informatique', 'duration_years' => 3]);
        $filiereMe = Filiere::firstOrCreate(['code' => 'ME'], ['name' => 'Management des Entreprises', 'duration_years' => 3]);

        // 3. Création des Salles
        $roomA37 = Room::firstOrCreate(['code' => 'A37'], ['name' => 'Salle A37', 'type' => 'classroom', 'capacity' => 40, 'building' => 'Bloc A', 'floor' => 3]);
        $roomE2 = Room::firstOrCreate(['code' => 'E2'], ['name' => 'Amphi E2', 'type' => 'amphi', 'capacity' => 150, 'building' => 'Bloc E', 'floor' => 0]);

        // 4. Création des Professeurs
        $profData = [
            'mejdoub' => ['first_name' => 'Soufyane', 'last_name' => 'MEJDOUB', 'speciality' => 'Base de données'],
            'hajji' => ['first_name' => 'Tarik', 'last_name' => 'HAJJI', 'speciality' => 'Programmation/Gaming'],
            'riffi' => ['first_name' => 'Jamal', 'last_name' => 'RIFFI', 'speciality' => 'Intelligence Artificielle'],
            'belghini' => ['first_name' => 'Naouar', 'last_name' => 'BELGHINI', 'speciality' => 'Développement Mobile'],
            'kzadri' => ['first_name' => 'Marwan', 'last_name' => 'KZADRI', 'speciality' => 'Technologies Web'],
            'salim' => ['first_name' => 'Bouasria', 'last_name' => 'SALIM', 'speciality' => 'Anglais'],
            'ouazzani' => ['first_name' => 'Lhoucine', 'last_name' => 'OUAZZANI', 'speciality' => 'Anglais/Patrimoine'],
        ];

        $profs = [];
        foreach ($profData as $key => $p) {
            $fullName = $p['first_name'] . ' ' . $p['last_name'];
            $email = Str::slug($fullName, '.') . '@universite.com';
            $user = User::firstOrCreate(['email' => $email], [
                'name' => $fullName,
                'password' => Hash::make('password'),
                'role' => 'professeur',
            ]);

            $profs[$key] = Professor::firstOrCreate(['email' => $user->email], [
                'user_id' => $user->id,
                'first_name' => $p['first_name'],
                'last_name' => $p['last_name'],
                'speciality' => $p['speciality'],
                'hire_date' => now()->subYears(rand(1, 10)),
            ]);
        }

        // 5. Création des Modules et Liaison avec Professeurs
        $modules = [
            'sql' => ['name' => 'Base de données SQL server', 'code' => 'SQL01', 'prof' => $profs['mejdoub']],
            'gaming' => ['name' => 'Projet (Gaming)', 'code' => 'PROJ01', 'prof' => $profs['hajji']],
            'ia' => ['name' => 'Intelligence Artificielle 1', 'code' => 'IA01', 'prof' => $profs['riffi']],
            'mobile' => ['name' => 'Développement mobile', 'code' => 'MOB01', 'prof' => $profs['belghini']],
            'java' => ['name' => 'Programmation orientée objet JAVA 2', 'code' => 'JAVA02', 'prof' => $profs['hajji']],
            'web' => ['name' => 'Technologies web 2 (php & MySQL/Framework)', 'code' => 'WEB02', 'prof' => $profs['kzadri']],
            'anglais' => ['name' => 'Anglais / Patrimoine artistique', 'code' => 'ANG01', 'prof' => $profs['salim']],
        ];

        foreach ($modules as $key => $data) {
            $module = Module::firstOrCreate(['code' => $data['code']], [
                'name' => $data['name'],
                'credits' => rand(4, 8),
                'hours' => rand(30, 50),
                'semester' => 6,
                'filiere_id' => $filiereGinf->id,
                'is_active' => true,
            ]);

            // Liaison pivot (éviter doublons)
            $module->professors()->syncWithoutDetaching([$data['prof']->id => ['academic_year' => '2024-2025']]);

            // Création d'un élément de module pour pouvoir saisir des notes
            ModuleElement::firstOrCreate(['code' => 'EX-' . $data['code']], [
                'name' => 'Examen Final',
                'coefficient' => 1.0,
                'module_id' => $module->id,
                'professor_id' => $data['prof']->id,
            ]);

            // Création d'un créneau d'emploi du temps (exemple avec créneaux variés)
            $slots = [
                ['08:30:00', '10:30:00'],
                ['10:45:00', '12:45:00'],
                ['14:00:00', '16:00:00'],
                ['16:15:00', '18:15:00']
            ];
            $selectedSlot = $slots[rand(0, 3)];

            Schedule::firstOrCreate([
                'module_id' => $module->id,
                'start_time' => $selectedSlot[0],
                'end_time' => $selectedSlot[1],
            ], [
                'professor_id' => $data['prof']->id,
                'room_id' => ($key === 'anglais' ? $roomE2->id : $roomA37->id),
                'day' => ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'][rand(0, 4)],
                'type' => 'Cours',
                'date' => now()->addDays(rand(1, 7)),
                'academic_year' => '2024-2025',
            ]);
        }

        // 6. Étudiants
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
        
        $moduleElements = ModuleElement::all();
        $schedules = Schedule::all();

        foreach ($names as $fullName) {
            $parts = explode(' ', $fullName);
            $firstName = $parts[0];
            $lastName = isset($parts[1]) ? implode(' ', array_slice($parts, 1)) : 'Student';
            $email = Str::slug($fullName, '.') . '@student.com';

            $user = User::firstOrCreate(['email' => $email], [
                'name' => $fullName,
                'password' => Hash::make('password'),
                'role' => 'etudiant',
            ]);

            $student = Student::firstOrCreate(['user_id' => $user->id], [
                'filiere_id' => $filiereGinf->id,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'student_id_number' => 'STU-' . strtoupper(Str::random(6)),
                'birth_date' => now()->subYears(rand(18, 25)),
                'address' => 'Adresse Ville ' . rand(1, 10),
            ]);

            // Data for student: grades + absences
            $gradesCount = rand(3, 6);
            $usedElementIds = [];
            for ($g = 0; $g < $gradesCount; $g++) {
                $available = $moduleElements->whereNotIn('id', $usedElementIds);
                $element = $available->isEmpty() ? $moduleElements->random() : $available->random();
                $usedElementIds[] = $element->id;

                Grade::firstOrCreate([
                    'student_id' => $student->id,
                    'module_element_id' => $element->id,
                    'session' => 'normal',
                    'academic_year' => '2024-2025',
                ], [
                    'score' => round(rand(0, 200) / 10, 2),
                ]);
            }

            if ($schedules->isNotEmpty() && rand(0, 3) === 0) {
                $schedule = $schedules->random();
                Absence::firstOrCreate([
                    'student_id' => $student->id,
                    'schedule_id' => $schedule->id,
                    'date' => now()->subDays(rand(1, 40)),
                ], [
                    'reason' => 'Absence non justifiée',
                    'excused' => false,
                ]);
            }
        }
    }
}
