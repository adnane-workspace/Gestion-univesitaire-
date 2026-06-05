<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';

try {
    $ai = app(App\Services\AiClient::class);
    
    $module = App\Models\Module::first();
    if (!$module) {
        echo "No module found\n";
        exit(1);
    }
    
    echo "Module: " . $module->name . "\n";
    echo "Testing Grok API generation...\n\n";
    
    $controller = new App\Http\Controllers\ModuleQuestionController();
    $prompt = (function() use ($module) {
        $elements = $module->moduleElements();
        $elementsList = $elements->pluck('name')->filter()->implode(', ');
        $description = trim($module->description ?? '');
        
        $elementDetails = '';
        foreach ($elements as $element) {
            $elementDesc = trim($element->description ?? '');
            if ($elementDesc) {
                $elementDetails .= "\n- {$element->name}: {$elementDesc}";
            } else {
                $elementDetails .= "\n- {$element->name}";
            }
        }

        return "Tu es un assistant pédagogique. Génère 2 questions de révision QCM pour le module suivant. " .
            "Présente ta réponse uniquement sous forme de JSON strict. " .
            "Le format doit être : {\"questions\":[{\"question\":\"...\",\"choices\":[\"...\",...],\"correct_index\":0,\"explanation\":\"...\"}]}. " .
            "Chaque question doit avoir exactement 4 propositions. " .
            "Donne des questions claires, en français, adaptées à un niveau moyen.\n\n" .
            "Module: {$module->name}\n" .
            "Description: $description\n" .
            "Éléments du module:$elementDetails\n\n" .
            "Génère des questions pertinentes et variées basées sur le contenu du module.\n\n" .
            "Réponds uniquement par le JSON demandé, sans texte supplémentaire.";
    })();
    
    echo "Prompt:\n" . substr($prompt, 0, 500) . "...\n\n";
    echo "Sending request to Grok API...\n";
    
    $response = $ai->generateQcm($prompt, 800);
    
    echo "Response received!\n";
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "\nFull trace:\n";
    echo $e->getTraceAsString();
}
