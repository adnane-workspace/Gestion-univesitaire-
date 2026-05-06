<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Student;
use App\Models\Professor;
use App\Models\Module;
use App\Models\ModuleElement;
use App\Models\Filiere;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcademicManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_new_student()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $filiere = Filiere::factory()->create();

        $studentData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'student_id_number' => 'STU-123456',
            'birth_date' => '2000-01-01',
            'address' => '123 Main St',
            'filiere_id' => $filiere->id,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->actingAs($admin)
            ->post(route('admin.students.store'), $studentData);

        $response->assertRedirect(route('admin.students.index'));
        $this->assertDatabaseHas('students', [
            'email' => 'john.doe@example.com',
            'first_name' => 'John'
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@example.com',
            'role' => 'etudiant'
        ]);
    }

    public function test_professor_can_store_grades_for_students()
    {
        $user = User::factory()->create(['role' => 'professeur']);
        $professor = Professor::factory()->create(['user_id' => $user->id]);
        
        $module = Module::factory()->create();
        $element = ModuleElement::factory()->create([
            'module_id' => $module->id,
            'professor_id' => $professor->id
        ]);
        
        $student = Student::factory()->create();

        $gradeData = [
            'element_id' => $element->id,
            'grades' => [
                $student->id => 15.5
            ]
        ];

        $response = $this->actingAs($user)
            ->post(route('professeur.grades.store'), $gradeData);

        $response->assertRedirect();
        $this->assertDatabaseHas('grades', [
            'student_id' => $student->id,
            'module_element_id' => $element->id,
            'score' => 15.5
        ]);
    }
}
