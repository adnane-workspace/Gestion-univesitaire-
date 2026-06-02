<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qcm_attempt_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qcm_attempt_id')->constrained('qcm_attempts')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->foreignId('selected_choice_id')->nullable()->constrained('choices')->nullOnDelete();
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qcm_attempt_answers');
    }
};
