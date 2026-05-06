<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Professor;
use App\Models\Module;
use App\Models\Schedule;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfessorAccessTest extends TestCase
{
    use RefreshDatabase;

    protected $professorUser;
    protected $professorProfile;

    protected function setUp(): void
    {
        parent::setUp();
        $this->professorUser = User::factory()->create(['role' => 'professeur']);
        $this->professorProfile = Professor::factory()->create(['user_id' => $this->professorUser->id]);
    }

    public function test_professor_can_see_assigned_modules()
    {
        $module = Module::factory()->create();
        $module->professors()->attach($this->professorProfile->id, ['academic_year' => '2024-2025']);

        $response = $this->actingAs($this->professorUser)->get(route('professeur.modules'));

        $response->assertStatus(200);
        $response->assertSee($module->name);
    }

    public function test_professor_can_see_their_schedule()
    {
        $room = Room::factory()->create();
        $module = Module::factory()->create();
        
        $schedule = Schedule::create([
            'professor_id' => $this->professorProfile->id,
            'module_id' => $module->id,
            'room_id' => $room->id,
            'day' => 'Lundi',
            'start_time' => '08:30:00',
            'end_time' => '10:30:00',
            'date' => now()->format('Y-m-d'),
            'academic_year' => '2024-2025'
        ]);

        $response = $this->actingAs($this->professorUser)->get(route('professeur.schedule'));

        $response->assertStatus(200);
        $response->assertSee($module->name);
        $response->assertSee('08:30');
    }

    public function test_professor_dashboard_shows_correct_statistics()
    {
        $response = $this->actingAs($this->professorUser)->get(route('professeur.dashboard'));

        $response->assertStatus(200);
        $response->assertSee("Bonjour, Prof. {$this->professorProfile->last_name}");
    }
}
