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
    
    private function saveData($topic, $message)
    {
        \Log::info("MQTT - Topic: $topic, Message: $message");

        // Almacenar en la base de datos
        \DB::table('records')->insert([
            'event' => 'Mensaje MQTT',
            'description' => "Mensaje: $message",
            'date_event' => now(),
            'users_id' => 1, // Cambia según el usuario autenticado
            'created_at' => now(),
            'updated_at' => now(), //AGREGAR LOS OTROS REGISTROS NECESARIOS DE DISPOSITIVOS ASOCIADOS COMNO TAMBIEN A LAS ALERTAS NECESARIAS
        ]);
    }

    public function disconnect()
    {
        $this->mqtt->disconnect();
    }
}
