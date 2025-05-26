<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\Exceptions\MqttClientException;

class MQTTService
{
    protected $mqtt;

    public function __construct()
    {
        // Cambia localhost por la IP 127.0.0.1 para asegurar conexión desde Laragon
        $this->mqtt = new MqttClient('127.0.0.1', 1883, 'LaravelClient');
    }

    public function connect()
    {
        try {
            $this->mqtt->connect();
            echo "Conectado al broker MQTT\n";
        } catch (MqttClientException $e) {
            echo "Error al conectar al broker: " . $e->getMessage();
        }
    }

    public function subscribe(string $topic): void
    {
        try {
            $this->mqtt->subscribe($topic, function ($topic, $message) {
                echo "Mensaje recibido en $topic: $message\n";
                $this->saveData($topic, $message);
            }, 0);
        } catch (MqttClientException $e) {
            echo "Error al suscribirse al tema: " . $e->getMessage();
        }
    }

    public function listen(): void
    {
        try {
            $this->mqtt->loop(true); // Dejar el bucle continuo aquí
        } catch (MqttClientException $e) {
            echo "Error en el bucle MQTT: " . $e->getMessage();
        }
    }

        private function saveData($topic, $message): void
    {
        \Log::info("MQTT - Topic: $topic, Message: $message");

        $data = json_decode($message, true);
        if (!$data) {
            \Log::warning("Mensaje inválido: $message");
            return;
        }
        \Log::debug("Decoded message", ['data' => $data]);

        // Mapeo entre tópicos y nombres de dispositivos
        $topicToDeviceName = [
            'iot/temperature/humedad' => 'Termostato',
            'iot/energy1' => 'Bombillo sala',
            'iot/energy2' => 'Bombillo cuarto 1',
            'iot/energy3' => 'Bombillo cuarto 2',
            'iot/energy4' => 'Bombillo cocina',
            'iot/energy5' => 'Bombillo baño',
            'iot/fridge' => 'Smart Breaker de nevera de la cocina',
            'iot/airconditioner' => 'Smart Breaker de aire acondicionado cuarto principal',
            'iot/airconditioner2' => 'Smart Breaker de aire acondicionado cuarto secundario',
            'iot/washer_dryer' => 'Smart Breaker de lavadora-Secadora',
            'iot/kitchen' => 'Smart Breaker de cocina electrica',
            'iot/water_heater' => 'Smart Breaker del calentador de agua',
            'iot/sensor' => 'Sensor de humo',
        ];

        $deviceName = $topicToDeviceName[$topic] ?? null;

        if (!$deviceName) {
            \Log::warning("Tópico no reconocido: $topic");
            return;
        }

        $device = \DB::table('devices')->where('name', $deviceName)->first();
        if (!$device) {
            \Log::warning("Dispositivo no encontrado en DB: $deviceName");
            return;
        }

        $deviceId = $device->id;

        \Log::debug("Mensaje original recibido en Laravel:", ['raw' => $message]);

        // Insertar en records
        \DB::table('records')->insert([
            'event' => 'Mensaje MQTTss',
            'description' => "Dispositivo: $deviceName - $message",
            'date_event' => now(),
            'users_id' => $device->users_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Normalización de datos con unidades removidas
        $energy = isset($data['energy_consumption']) ? preg_replace('/[^0-9.]/', '', $data['energy_consumption']) : null;
        $voltage = isset($data['voltage']) ? preg_replace('/[^0-9.]/', '', $data['voltage']) : null;
        $current = isset($data['current']) ? preg_replace('/[^0-9.]/', '', $data['current']) : null;

        if (is_numeric($energy) && is_numeric($voltage) && is_numeric($current)) {
            \Log::debug('Datos para tabla consumes', [
                'measured_at' => $data['timestamp'] ?? now(),
                'energy_consumption' => $energy,
                'voltage' => $voltage,
                'current' => $current,
                'devices_id' => $deviceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            \DB::table('consumes')->insert([
                'measured_at' => $data['timestamp'] ?? now(),
                'energy_consumption' => $energy,
                'voltage' => $voltage,
                'current' => $current,
                'devices_id' => $deviceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Registro de alerta por temperatura alta (más de 35°C)
        if (isset($data['temperature']) && is_numeric($data['temperature']) && floatval($data['temperature']) > 35) {
            \Log::debug("Insertando en alerts con:", [
                'type_alert' => 'Temperatura alta',
                'message' => "Temperatura crítica detectada: {$data['temperature']}°C",
                'level' => 'alto',
                'devices_id' => $deviceId,
                'created_at' => now(),
            ]);
            \DB::table('alerts')->insert([
                'type_alert' => 'Temperatura alta',
                'message' => "Temperatura crítica detectada: {$data['temperature']}°C",
                'level' => 'alto',
                'devices_id' => $deviceId,
                'created_at' => now(),
            ]);
        }

        // Alerta por consumo anormal (bombillos superando 20W, por ejemplo)
        if (strpos($topic, 'iot/energy') !== false && $energy && floatval($energy) > 20) {
            \DB::table('alerts')->insert([
                'type_alert' => 'Consumo anormal',
                'message' => "Consumo excesivo detectado: {$energy}W",
                'level' => 'medio',
                'devices_id' => $deviceId,
                'created_at' => now(),
            ]);
        }

        // Alerta por sensor de humo
        if ($topic === 'iot/sensor' && $data === true) {
            \DB::table('alerts')->insert([
                'type_alert' => 'Humo detectado',
                'message' => "¡Sensor de humo activado!",
                'level' => 'alto',
                'devices_id' => $deviceId,
                'created_at' => now(),
            ]);
        }
    }


    public function disconnect()
    {
        $this->mqtt->disconnect();
    }
}
