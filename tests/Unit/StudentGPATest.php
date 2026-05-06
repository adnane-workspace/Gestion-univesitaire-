<?php

namespace Tests\Unit;

use App\Models\Student;
use App\Models\Grade;
use App\Models\ModuleElement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentGPATest extends TestCase
{
    use RefreshDatabase;

    public function test_it_calculates_the_correct_weighted_gpa()
    {
        $student = Student::factory()->create();

        // Element 1: Coeff 2, Score 15 => weighted = 30
        $element1 = ModuleElement::factory()->create(['coefficient' => 2.0]);
        Grade::factory()->create([
            'student_id' => $student->id,
            'module_element_id' => $element1->id,
            'score' => 15.0
        ]);

        // Element 2: Coeff 1, Score 12 => weighted = 12
        $element2 = ModuleElement::factory()->create(['coefficient' => 1.0]);
        Grade::factory()->create([
            'student_id' => $student->id,
            'module_element_id' => $element2->id,
            'score' => 12.0
        ]);

        // Total weighted = 30 + 12 = 42
        // Total coefficients = 2 + 1 = 3
        // GPA = 42 / 3 = 14.0

        $this->assertEquals(14.0, $student->calculateGPA());
    }

    public function test_it_returns_zero_if_no_grades_exist()
    {
        $student = Student::factory()->create();
        $this->assertEquals(0.0, $student->calculateGPA());
    }
}
