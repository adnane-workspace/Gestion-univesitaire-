<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Professor;
use App\Models\Module;
use App\Models\Question;
use App\Models\Choice;
use App\Services\AiClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class QcmGenerationTest extends TestCase
{
    use RefreshDatabase;

    protected $professorUser;
    protected $professorProfile;
    protected $module;

    protected function setUp(): void
    {
        parent::setUp();

        // Configure dummy AI service credentials for testing
        config([
            'services.ai.url' => 'https://api.x.ai/v1/chat/completions',
            'services.ai.key' => 'dummy-grok-key',
            'services.ai.model' => 'grok-1.0',
        ]);

        $this->professorUser = User::factory()->create(['role' => 'professeur']);
        $this->professorProfile = Professor::factory()->create(['user_id' => $this->professorUser->id]);

        $this->module = Module::factory()->create();
        $this->module->professors()->attach($this->professorProfile->id, ['academic_year' => '2024-2025']);
    }

    public function test_qcm_generation_success()
    {
        // Mocking the Grok API response
        Http::fake([
            'https://api.x.ai/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => json_encode([
                                'questions' => [
                                    [
                                        'question' => 'Quelle est la capitale de la France ?',
                                        'choices' => ['Paris', 'Londres', 'Berlin', 'Madrid'],
                                        'correct_index' => 0,
                                        'explanation' => 'Paris est la capitale politique et historique de la France.',
                                        'difficulty' => 'facile'
                                    ],
                                    [
                                        'question' => 'Quel est le framework backend PHP le plus populaire ?',
                                        'choices' => ['Symfony', 'Laravel', 'Zend', 'Yii'],
                                        'correct_index' => 1,
                                        'explanation' => 'Laravel est considéré comme le plus populaire.',
                                        'difficulty' => 'moyen'
                                    ]
                                ]
                            ])
                        ]
                    ]
                ]
            ], 200)
        ]);

        $response = $this->actingAs($this->professorUser)
            ->postJson(route('professeur.modules.generate-qcm', ['module' => $this->module->id]), [
                'num' => 2,
                'difficulty' => 'moyen'
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'ok' => true,
            'redirect' => route('professeur.modules.qcm', ['module' => $this->module->id])
        ]);

        // Verify the database has the new questions and choices
        $this->assertDatabaseCount('questions', 2);
        $this->assertDatabaseCount('choices', 8);

        $firstQuestion = Question::first();
        $this->assertEquals('Quelle est la capitale de la France ?', $firstQuestion->text);
        $this->assertEquals('facile', $firstQuestion->difficulty);
        $this->assertEquals('Paris est la capitale politique et historique de la France.', $firstQuestion->explanation);
        $this->assertTrue((bool)$firstQuestion->ai_generated);

        $choices = $firstQuestion->choices;
        $this->assertCount(4, $choices);
        $this->assertEquals('Paris', $choices[0]->text);
        $this->assertTrue((bool)$choices[0]->is_correct);
        $this->assertEquals('Londres', $choices[1]->text);
        $this->assertFalse((bool)$choices[1]->is_correct);
    }

    public function test_qcm_generation_deletes_previous_ai_generated_questions()
    {
        // Create an existing AI question and a manual question
        $oldAiQuestion = Question::create([
            'module_id' => $this->module->id,
            'text' => 'Ancienne question IA',
            'ai_generated' => true,
        ]);
        Choice::create([
            'question_id' => $oldAiQuestion->id,
            'text' => 'Choix ancienne',
            'is_correct' => true,
        ]);

        $manualQuestion = Question::create([
            'module_id' => $this->module->id,
            'text' => 'Question manuelle',
            'ai_generated' => false,
        ]);
        Choice::create([
            'question_id' => $manualQuestion->id,
            'text' => 'Choix manuelle',
            'is_correct' => true,
        ]);

        Http::fake([
            'https://api.x.ai/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => json_encode([
                                'questions' => [
                                    [
                                        'question' => 'Nouvelle question IA',
                                        'choices' => ['A', 'B', 'C', 'D'],
                                        'correct_index' => 2,
                                    ]
                                ]
                            ])
                        ]
                    ]
                ]
            ], 200)
        ]);

        $response = $this->actingAs($this->professorUser)
            ->postJson(route('professeur.modules.generate-qcm', ['module' => $this->module->id]));

        $response->assertStatus(200);

        // Verify the old AI question was deleted, but the manual one remains
        $this->assertDatabaseMissing('questions', ['id' => $oldAiQuestion->id]);
        $this->assertDatabaseHas('questions', ['id' => $manualQuestion->id]);
        $this->assertDatabaseCount('questions', 2); // 1 manual + 1 new AI
    }

    public function test_qcm_generation_fails_if_api_returns_invalid_json()
    {
        Http::fake([
            'https://api.x.ai/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'This is not JSON!'
                        ]
                    ]
                ]
            ], 200)
        ]);

        $response = $this->actingAs($this->professorUser)
            ->postJson(route('professeur.modules.generate-qcm', ['module' => $this->module->id]));

        $response->assertStatus(500);
        $response->assertJsonStructure(['error']);
    }

    public function test_qcm_generation_unauthorized_module()
    {
        $otherModule = Module::factory()->create();

        $response = $this->actingAs($this->professorUser)
            ->postJson(route('professeur.modules.generate-qcm', ['module' => $otherModule->id]));

        $response->assertStatus(403);
    }
}
