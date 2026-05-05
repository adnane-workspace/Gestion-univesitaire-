<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('module_element_id')->constrained('module_elements')->onDelete('cascade');
            $table->decimal('score', 5, 2);
            $table->enum('session', ['normal', 'retake'])->default('normal');
            $table->string('academic_year');
            $table->text('observation')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'module_element_id', 'session', 'academic_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
