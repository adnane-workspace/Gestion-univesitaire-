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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('element_module_id');
            $table->decimal('note', 5, 2);
            $table->enum('session', ['normale', 'rattrapage'])->default('normale');
            $table->string('annee_universitaire');
            $table->text('observation')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('element_module_id')->references('id')->on('elements_modules')->onDelete('cascade');

            $table->unique(['student_id', 'element_module_id', 'session', 'annee_universitaire']);
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
