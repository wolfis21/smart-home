<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MQTTService;

class MQTTController extends Controller
{
    protected $mqtt;

    public function __construct(MQTTService $mqtt)
    {
        $this->mqtt = $mqtt;
    }

    public function publishMessage()
    {
        try {
            app(\App\Services\MQTTService::class)->publish('test/topic', 'Mensaje desde Laravel');
            return response()->json(['message' => 'Publicado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function subscribeMessage()
    {
        try {
            app(\App\Services\MQTTService::class)->subscribe('test/topic', function ($topic, $message) {
                logger("Mensaje recibido: $message");
            });
            return response()->json(['message' => 'Suscripción activa']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
