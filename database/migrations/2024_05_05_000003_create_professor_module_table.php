<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('professor_module', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')->constrained()->onDelete('cascade');
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->string('academic_year');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('professor_module');
    }
};
