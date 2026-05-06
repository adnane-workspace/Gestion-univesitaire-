<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Filiere;
use App\Models\Module;
use App\Models\Room;
use App\Models\Professor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_manage_filieres()
    {
        // Create
        $response = $this->actingAs($this->admin)->post(route('admin.filieres.store'), [
            'name' => 'Génie Civil',
            'code' => 'GC01',
            'duration_years' => 3
        ]);
        $response->assertRedirect(route('admin.filieres.index'));
        $this->assertDatabaseHas('filieres', ['code' => 'GC01']);

        // Update
        $filiere = Filiere::where('code', 'GC01')->first();
        $this->actingAs($this->admin)->put(route('admin.filieres.update', $filiere), [
            'name' => 'Génie Civil Updated',
            'code' => 'GC-UPD',
            'duration_years' => 5
        ]);
        $this->assertDatabaseHas('filieres', ['code' => 'GC-UPD']);

        // Delete
        $this->actingAs($this->admin)->delete(route('admin.filieres.destroy', $filiere));
        $this->assertDatabaseMissing('filieres', ['id' => $filiere->id]);
    }

    public function test_admin_can_manage_rooms()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.rooms.store'), [
            'name' => 'Salle B12',
            'code' => 'B12',
            'type' => 'classroom',
            'capacity' => 30,
            'floor' => 1,
            'building' => 'Bloc B'
        ]);
        $response->assertRedirect(route('admin.rooms.index'));
        $this->assertDatabaseHas('rooms', ['code' => 'B12']);
    }

    public function test_admin_can_manage_modules()
    {
        $filiere = Filiere::factory()->create();
        
        $response = $this->actingAs($this->admin)->post(route('admin.modules.store'), [
            'name' => 'Mathématiques',
            'code' => 'MATH01',
            'credits' => 6,
            'hours' => 40,
            'semester' => 1,
            'filiere_id' => $filiere->id,
            'is_active' => true
        ]);
        
        $response->assertRedirect(route('admin.modules.index'));
        $this->assertDatabaseHas('modules', ['code' => 'MATH01']);
    }

    public function test_admin_can_manage_professors()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.professors.store'), [
            'first_name' => 'Alice',
            'last_name' => 'Smith',
            'email' => 'alice@upf.com',
            'speciality' => 'Computer Science',
            'hire_date' => '2023-01-01',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertRedirect(route('admin.professors.index'));
        $this->assertDatabaseHas('professors', ['email' => 'alice@upf.com']);
        $this->assertDatabaseHas('users', ['email' => 'alice@upf.com', 'role' => 'professeur']);
    }
}
