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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')->constrained('professors')->onDelete('cascade');
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->string('day'); // Monday, Tuesday, etc.
            $table->date('date')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->string('type')->default('Cours'); // Cours, TP, TD, etc.
            $table->string('group')->nullable();
            $table->string('academic_year')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
