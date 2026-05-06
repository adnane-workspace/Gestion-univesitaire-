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
        $response->assertSee("Bonjour, {$this->studentProfile->first_name}");
    }
}
