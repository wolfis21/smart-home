<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIService
{
    public function analizarDatos(array $datos)
    {
        $prompt = $this->construirPrompt($datos);

        $response = Http::withToken(config('services.openai.api_key'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un analista de datos de una casa inteligente.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.4,
            ]);

        return $response->json()['choices'][0]['message']['content'] ?? null;
    }

    private function construirPrompt(array $datos): string
    {
        $jsonDatos = json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return <<<PROMPT
        Analiza los siguientes datos provenientes de sensores de una casa inteligente. Detecta patrones, errores o situaciones relevantes, y genera recomendaciones concretas para ser registradas, en español.

        Devuelve únicamente un JSON con la siguiente estructura:

        {
        "records": [
            {
            "event": "nombre del evento",
            "description": "explicación resumida del evento o recomendación",
            "date_event": "YYYY-MM-DD HH:MM:SS"
            }
        ]
        }

        Asegúrate de que las cadenas de texto estén limpias (sin saltos innecesarios) y el JSON sea válido.

        Datos de entrada:

        $jsonDatos
        PROMPT;
    }

}
