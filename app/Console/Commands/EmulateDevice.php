<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class EmulateDevice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'device:emulate 
                            {device_id=sensor_001 : ID del dispositivo} 
                            {sensor=temperatura : Tipo de sensor} 
                            {frequency=5 : Frecuencia de envío en segundos}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Emula un dispositivo enviando datos periódicamente a la API de Laravel';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deviceId = $this->argument('device_id');
        $sensorType = $this->argument('sensor');
        $frequency = (int) $this->argument('frequency');

        $apiUrl = config('app.url') . '/api/device/data';

        $this->info("Emulando dispositivo: $deviceId ($sensorType) cada $frequency segundos...");
        
        while (true) {
            $value = round(mt_rand(2000, 3500) / 100, 2); // Genera un valor aleatorio entre 20.00 y 35.00
            $timestamp = Carbon::now()->format('Y-m-d H:i:s');

            $data = [
                'device_id' => $deviceId,
                'sensor' => $sensorType,
                'value' => strval($value),
                'timestamp' => $timestamp,
            ];

            try {
                $response = Http::post($apiUrl, $data);

                if ($response->successful()) {
                    $this->info("[OK] Datos enviados: " . json_encode($data));
                } else {
                    $this->error("[ERROR] Código {$response->status()}: {$response->body()}");
                }
            } catch (\Exception $e) {
                $this->error("[ERROR] No se pudo enviar la solicitud: " . $e->getMessage());
            }

            sleep($frequency);
        }
    }
}
