<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\EmulateDevice;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Registrar el comando de emulación
Artisan::command('device:emulate {device_id=sensor_001} {sensor=temperatura} {frequency=5}', function ($device_id, $sensor, $frequency) {
    $this->call(\App\Console\Commands\EmulateDevice::class, [
        'device_id' => $device_id,
        'sensor' => $sensor,
        'frequency' => $frequency,
    ]);
})->purpose('Emular un dispositivo y enviar datos periódicamente');