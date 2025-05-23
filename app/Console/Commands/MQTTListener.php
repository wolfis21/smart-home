<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MQTTService;

class MQTTListener extends Command
{
    protected $signature = 'mqtt:listen';
    protected $description = 'Escucha mensajes MQTT desde Mosquitto';

    public function handle(): void
    {
        $mqttService = new MQTTService();
        $mqttService->connect();

        // Lista de tópicos a suscribirse
        $topics = [
            'iot/temperature/humedad',
            'iot/energy1',
            'iot/energy2',
            'iot/energy3',
            'iot/energy4',
            'iot/energy5',
            'iot/fridge',
            'iot/airconditioner',
            'iot/airconditioner2',
            'iot/washer_dryer',
            'iot/water_heater',
            'iot/sensor',
        ];

        foreach ($topics as $topic) {
            $mqttService->subscribe($topic);
            $this->info("Suscrito al tópico: $topic");
        }

        $this->info('Escuchando mensajes MQTT...');

        // Mover el bucle aquí para que escuche todos los tópicos
        while (true) {
            $mqttService->listen();
        }
    }
}
