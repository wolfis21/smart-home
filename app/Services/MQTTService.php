<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\Exceptions\MqttClientException;

class MQTTService
{
    protected $mqtt;

    public function __construct()
    {
        $server = 'bc46-79-127-148-142.ngrok-free.app'; 
        $port = 1883;
        $clientId = 'LaravelClient';

        try {
            $this->mqtt = new MqttClient($server, $port, $clientId);
            $this->mqtt->connect();
        } catch (MqttClientException $e) {
            logger('MQTT Connection failed: ' . $e->getMessage());
        }
    }

    public function publish($topic, $message)
    {
        try {
            $this->mqtt->publish($topic, $message);
            $this->mqtt->disconnect();
        } catch (MqttClientException $e) {
            logger('MQTT Publish failed: ' . $e->getMessage());
        }
    }

    public function subscribe($topic, callable $callback)
    {
        try {
            $this->mqtt->subscribe($topic, function ($topic, $message) use ($callback) {
                $callback($topic, $message);
            }, 0);

            $this->mqtt->loop(true);
            $this->mqtt->disconnect();
        } catch (MqttClientException $e) {
            logger('MQTT Subscribe failed: ' . $e->getMessage());
        }
    }
}
