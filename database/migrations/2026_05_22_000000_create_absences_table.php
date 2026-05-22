<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('schedule_id')->nullable()->constrained('schedules')->nullOnDelete();
            $table->date('date');
            $table->string('reason')->nullable();
            $table->boolean('excused')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('absences');
    }
};
