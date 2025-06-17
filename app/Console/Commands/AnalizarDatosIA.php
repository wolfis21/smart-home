<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Alert;
use App\Models\Consume;
use App\Models\Record;
use App\Models\Device;
use App\Services\OpenAIService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AnalizarDatosIA extends Command
{
    protected $signature = 'ai:analizar-datos';
    protected $description = 'Analiza los datos con OpenAI y guarda sugerencias o errores';

    public function handle(OpenAIService $openAI)
    {
        $alerts = Alert::latest()->take(50)->get()->toArray();
        $consumes = Consume::latest()->take(100)->get()->toArray();
        $devices = Device::all();

        $datos = [
            'alerts' => $alerts,
            'consumes' => $consumes,
            'devices' => $devices,
        ];

        $respuesta = $openAI->analizarDatos($datos);


        if ($respuesta) {
            $this->info("Respuesta de IA:");

            // Intentar parsear como JSON
            $parsed = json_decode($respuesta, true);

            if (isset($parsed['records']) && is_array($parsed['records'])) {
                foreach ($parsed['records'] as $registro) {
                    Record::create([
                        'event' =>Str::limit($registro['event'], 45) ?? 'Evento AI',
                        'description' => $registro['description'] ?? '',
                        'date_event' => Carbon::parse($registro['date_event'] ?? now()),
                        'users_id' => 1, // Cambiar por auth()->id() si aplica
                    ]);
                }

                $this->info("Registros insertados correctamente.");
            } else {
                $this->warn("La respuesta no contenía la clave 'records' o no era válida.");
            }
        } else {
            $this->error('Error al recibir respuesta de OpenAI.');
        }
    }
}

