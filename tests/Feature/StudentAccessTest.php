<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Student;
use App\Models\Module;
use App\Models\Grade;
use App\Models\ModuleElement;
use App\Models\Schedule;
use App\Models\Room;
use App\Models\Professor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentAccessTest extends TestCase
{
    use RefreshDatabase;

    protected $studentUser;
    protected $studentProfile;

    protected function setUp(): void
    {
        parent::setUp();
        $this->studentUser = User::factory()->create(['role' => 'etudiant']);
        $this->studentProfile = Student::factory()->create(['user_id' => $this->studentUser->id]);
    }

    public function test_student_can_see_their_grades()
    {
        $module = Module::factory()->create();
        $element = ModuleElement::factory()->create(['module_id' => $module->id]);
        
        $grade = Grade::factory()->create([
            'student_id' => $this->studentProfile->id,
            'module_element_id' => $element->id,
            'score' => 18.5
        ]);

        $response = $this->actingAs($this->studentUser)->get(route('etudiant.grades'));

        $response->assertStatus(200);
        $response->assertSee($module->name);
        $response->assertSee('18.5');
    }

    public function test_student_can_see_their_schedule()
    {
        $room = Room::factory()->create();
        $module = Module::factory()->create(['filiere_id' => $this->studentProfile->filiere_id]);
        $professor = Professor::factory()->create();
        
        $schedule = Schedule::create([
            'professor_id' => $professor->id,
            'module_id' => $module->id,
            'room_id' => $room->id,
            'day' => 'Mardi',
            'start_time' => '10:45:00',
            'end_time' => '12:45:00',
            'date' => now()->format('Y-m-d'),
            'academic_year' => '2024-2025'
        ]);

        $response = $this->actingAs($this->studentUser)->get(route('etudiant.schedule'));

        $response->assertStatus(200);
        $response->assertSee($module->name);
        $response->assertSee('10:45');
    }

    public function test_student_dashboard_shows_welcome_message()
    {
        $response = $this->actingAs($this->studentUser)->get(route('etudiant.dashboard'));

        $response->assertStatus(200);
        $response->assertSee("Bonjour,");
        $response->assertSee($this->studentProfile->first_name);
    }

    public function test_student_chatbot_handles_different_queries()
    {
        // 1. Unrecognized query (xyz instead of bonjour)
        $response = $this->actingAs($this->studentUser)->postJson(route('etudiant.chatbot.query'), [
            'query' => 'xyz'
        ]);
        $response->assertStatus(200);
        $response->assertJsonPath('reply', function($reply) {
            return str_contains($reply, 'pas compris');
        });

        // 2. GPA/Moyenne query
        $module = Module::factory()->create();
        $element = ModuleElement::factory()->create(['module_id' => $module->id]);
        Grade::factory()->create([
            'student_id' => $this->studentProfile->id,
            'module_element_id' => $element->id,
            'score' => 15.0
        ]);

        $response = $this->actingAs($this->studentUser)->postJson(route('etudiant.chatbot.query'), [
            'query' => 'quelle est ma moyenne ?'
        ]);
        $response->assertStatus(200);
        $response->assertJsonPath('reply', function($reply) {
            return str_contains($reply, '15.00') && str_contains($reply, '/ 20');
        });

        // 3. Absences query
        \App\Models\Absence::create([
            'student_id' => $this->studentProfile->id,
            'date' => now(),
            'reason' => 'Maladie',
            'excused' => true
        ]);

        $response = $this->actingAs($this->studentUser)->postJson(route('etudiant.chatbot.query'), [
            'query' => 'ai-je des absences ?'
        ]);
        $response->assertStatus(200);
        $response->assertJsonPath('reply', function($reply) {
            return str_contains($reply, 'Absences') && str_contains($reply, 'Maladie') && str_contains($reply, 'Justifiée');
        });

        // 4. Emploi du temps / planning query
        $today = \Carbon\Carbon::now()->locale('fr')->dayName;
        $room = Room::factory()->create();
        $module2 = Module::factory()->create(['filiere_id' => $this->studentProfile->filiere_id]);
        $professor = Professor::factory()->create();
        Schedule::create([
            'professor_id' => $professor->id,
            'module_id' => $module2->id,
            'room_id' => $room->id,
            'day' => ucfirst($today),
            'start_time' => '08:30:00',
            'end_time' => '10:30:00',
            'date' => now()->format('Y-m-d'),
            'academic_year' => '2024-2025'
        ]);

        $response = $this->actingAs($this->studentUser)->postJson(route('etudiant.chatbot.query'), [
            'query' => 'quel est mon planning ?'
        ]);
        $response->assertStatus(200);
        $response->assertJsonPath('reply', function($reply) use ($module2, $room, $professor) {
            return (str_contains($reply, "Planning") || str_contains($reply, "planning")) &&
                   str_contains($reply, $module2->name) &&
                   str_contains($reply, $room->name) &&
                   str_contains($reply, $professor->last_name);
        });

        // 5. Notes query
        $response = $this->actingAs($this->studentUser)->postJson(route('etudiant.chatbot.query'), [
            'query' => 'mes notes'
        ]);
        $response->assertStatus(200);
        $response->assertJsonPath('reply', function($reply) use ($module) {
            return str_contains($reply, 'Notes récentes') && str_contains($reply, $module->name) && str_contains($reply, '15.0');
        });
    }
}

