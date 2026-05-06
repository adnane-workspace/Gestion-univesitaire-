<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Student;
use App\Models\Professor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_is_redirected_to_admin_dashboard_after_login()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');
    }

    public function test_professor_is_redirected_to_professor_dashboard_after_login()
    {
        $user = User::factory()->create(['role' => 'professeur']);
        Professor::factory()->create(['user_id' => $user->id]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/professeur/dashboard');
    }

    public function test_student_is_redirected_to_student_dashboard_after_login()
    {
        $user = User::factory()->create(['role' => 'etudiant']);
        Student::factory()->create(['user_id' => $user->id]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/etudiant/dashboard');
    }

    public function test_student_cannot_access_admin_dashboard()
    {
        $user = User::factory()->create(['role' => 'etudiant']);
        Student::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertStatus(403);
    }
}
