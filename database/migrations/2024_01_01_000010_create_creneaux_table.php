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
        Schema::create('creneaux', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professeur_id');
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('salle_id');
            $table->string('jour');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->enum('type_seance', ['cours', 'tp', 'td'])->default('cours');
            $table->string('groupe')->nullable();
            $table->string('annee_universitaire');
            $table->timestamps();

            $table->foreign('professeur_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->foreign('salle_id')->references('id')->on('salles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creneaux');
    }
};
