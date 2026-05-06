<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $modules = DB::table('modules')->get();
        foreach ($modules as $module) {
            $professorId = DB::table('professor_module')
                ->where('module_id', $module->id)
                ->value('professor_id');

            if ($professorId) {
                DB::table('module_elements')->insert([
                    [
                        'name' => 'Contrôle 1',
                        'code' => 'C1-' . $module->code,
                        'coefficient' => 0.25,
                        'module_id' => $module->id,
                        'professor_id' => $professorId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'Contrôle 2',
                        'code' => 'C2-' . $module->code,
                        'coefficient' => 0.25,
                        'module_id' => $module->id,
                        'professor_id' => $professorId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('module_elements')
            ->whereIn('name', ['Contrôle 1', 'Contrôle 2'])
            ->delete();
    }
};
