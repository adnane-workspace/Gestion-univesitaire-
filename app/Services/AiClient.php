<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class AiClient
{
    protected string $url;
    protected string $key;
    protected ?string $model;

    public function __construct()
    {
        $this->url = config('services.ai.url');
        $this->key = config('services.ai.key');
        $this->model = config('services.ai.model');

        if (!$this->url || !$this->key) {
            throw new RuntimeException('AI service is not configured. Add AI_API_URL and AI_API_KEY to your .env file.');
        }

        if ($this->model !== null) {
            $this->model = trim($this->model);
            if ($this->model === '') {
                $this->model = null;
            }
        }
    }

    public function generateQcm(string $prompt, int $maxTokens = 1200): array
    {
        $payload = ['max_tokens' => $maxTokens];
        if ($this->model) {
            $payload['model'] = $this->model;
        }

        if (str_contains($this->url, 'chat/completions') || str_contains($this->url, 'openai') || str_contains($this->url, 'x.ai')) {
            $payload['messages'] = [[
                'role' => 'user',
                'content' => $prompt,
            ]];
        } else {
            $payload['input'] = $prompt;
        }

        $response = Http::withoutVerifying()
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->key,
                'Content-Type' => 'application/json',
            ])
            ->timeout(30)
            ->post($this->url, $payload);

        if ($response->failed()) {
            $body = $response->body();
            throw new RuntimeException('AI request failed: ' . $body);
        }

        return $response->json();
    }

    public function parseGeneratedJson(array $response): array
    {
        if (isset($response['choices'][0]['message']['content'])) {
            $text = $response['choices'][0]['message']['content'];
        } elseif (isset($response['choices'][0]['text'])) {
            $text = $response['choices'][0]['text'];
        } elseif (isset($response['output'])) {
            $text = $response['output'];
        } elseif (isset($response['response'])) {
            $text = $response['response'];
        } else {
            throw new RuntimeException('Impossible de lire le contenu renvoyé par l’API IA.');
        }

        $text = $this->stripCodeFences($text);
        $json = $this->extractJson($text);
        if (!$json) {
            throw new RuntimeException('La réponse IA ne contient pas un JSON valide.');
        }

        $data = json_decode($json, true);
        if (!is_array($data)) {
            throw new RuntimeException('Échec du décodage JSON renvoyé par l’IA.');
        }

        $this->validateParsedQuestions($data);
        return $data;
    }

    protected function extractJson(string $text): ?string
    {
        $start = strpos($text, '{');
        $end = strrpos($text, '}');

        if ($start === false || $end === false || $end <= $start) {
            return null;
        }

        return substr($text, $start, $end - $start + 1);
    }

    protected function stripCodeFences(string $text): string
    {
        $text = preg_replace('/```(?:json)?\r?\n(.*)\r?\n```/si', '$1', $text);
        return trim($text);
    }

    protected function validateParsedQuestions(array $data): void
    {
        if (!isset($data['questions']) || !is_array($data['questions'])) {
            throw new RuntimeException('Le JSON IA ne contient pas de tableau questions valide.');
        }

        foreach ($data['questions'] as $index => $item) {
            if (!is_array($item)) {
                throw new RuntimeException("La question #$index n'est pas un objet JSON valide.");
            }
            if (empty($item['question']) || !is_string($item['question'])) {
                throw new RuntimeException("La question #$index n'a pas de texte valide.");
            }
            if (!isset($item['choices']) || !is_array($item['choices']) || count($item['choices']) !== 4) {
                throw new RuntimeException("La question #$index doit contenir exactement 4 propositions.");
            }
            foreach ($item['choices'] as $choiceIndex => $choice) {
                if (!is_string($choice) || trim($choice) === '') {
                    throw new RuntimeException("La proposition #$choiceIndex de la question #$index est invalide.");
                }
            }
            if (!isset($item['correct_index']) || !is_int($item['correct_index']) || $item['correct_index'] < 0 || $item['correct_index'] > 3) {
                throw new RuntimeException("La question #$index doit définir un correct_index entier entre 0 et 3.");
            }
        }
    }
}
