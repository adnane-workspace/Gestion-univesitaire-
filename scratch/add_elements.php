<?php

use App\Models\Module;
use App\Models\ModuleElement;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$modules = Module::all();

foreach ($modules as $module) {
    $prof = $module->professors()->first();
    if (!$prof) continue;

    // Check if they already exist
    $exists1 = ModuleElement::where('module_id', $module->id)->where('name', 'Contrôle 1')->exists();
    if (!$exists1) {
        ModuleElement::create([
            'name' => 'Contrôle 1',
            'code' => 'C1-' . $module->code,
            'coefficient' => 0.25,
            'module_id' => $module->id,
            'professor_id' => $prof->id,
        ]);
    }

    $exists2 = ModuleElement::where('module_id', $module->id)->where('name', 'Contrôle 2')->exists();
    if (!$exists2) {
        ModuleElement::create([
            'name' => 'Contrôle 2',
            'code' => 'C2-' . $module->code,
            'coefficient' => 0.25,
            'module_id' => $module->id,
            'professor_id' => $prof->id,
        ]);
    }
}

echo "Elements added successfully.\n";
