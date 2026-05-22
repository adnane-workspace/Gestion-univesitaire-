<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_login_and_fetch_schedule()
    {
        // seed minimal data
        $user = User::factory()->create([
            'email' => 'apitest@student.test',
            'password' => Hash::make('password'),
        ]);

        Student::factory()->create(['user_id' => $user->id]);

        $response = $this->postJson('/auth/login', [
            'email' => 'apitest@student.test',
            'password' => 'password',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['access_token']);
        $token = $response->json('access_token');

        $schedule = $this->withHeader('Authorization', 'Bearer ' . $token)
                 ->getJson('/student/schedule');

        $schedule->assertStatus(200);
    }
}
