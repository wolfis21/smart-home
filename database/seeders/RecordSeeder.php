<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Record;
use Carbon\Carbon;

class RecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sesiones
        Record::create([
            'event' => 'Inicio de sesión',
            'description' => 'El usuario inició sesión desde Chrome.',
            'date_event' => Carbon::now()->subMinutes(10),
            'users_id' => 1,
        ]);

        Record::create([
            'event' => 'Cierre de sesión',
            'description' => 'El usuario cerró sesión.',
            'date_event' => Carbon::now(),
            'users_id' => 1,
        ]);

        // Dispositivos
        Record::create([
            'event' => 'Dispositivo encendido',
            'description' => 'Encendido del aire acondicionado desde la app móvil.',
            'date_event' => Carbon::now()->subMinutes(5),
            'users_id' => 1,
        ]);

        Record::create([
            'event' => 'Dispositivo apagado',
            'description' => 'Apagado del televisor desde la web.',
            'date_event' => Carbon::now()->subMinutes(2),
            'users_id' => 1,
        ]);

        // Alertas
        Record::create([
            'event' => 'Alerta de sobrecalentamiento',
            'description' => 'El dispositivo "Calentador" presentó un sobrecalentamiento.',
            'date_event' => Carbon::now()->subMinutes(7),
            'users_id' => 1,
        ]);

        Record::create([
            'event' => 'Alerta de batería baja',
            'description' => 'Sensor de puerta con batería inferior al 20%.',
            'date_event' => Carbon::now()->subMinutes(4),
            'users_id' => 1,
        ]);
    }
}
