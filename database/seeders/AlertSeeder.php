<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Device;
use App\Models\Alert;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $devices = Device::all();

        if ($devices->isEmpty()) {
            // Si no hay dispositivos, no hacemos nada
            $this->command->info('No hay dispositivos disponibles para generar alertas.');
            return;
        }

        // 🔥 Generamos 100 alertas aleatorias
        for ($i = 0; $i < 100; $i++) {
            Alert::create([
                'type_alert' => $faker->randomElement([
                    'Sobrecalentamiento',
                    'Desconexión',
                    'Uso excesivo',
                    'Batería baja',
                    'Anomalía detectada'
                ]),
                'message' => $faker->sentence(6),
                'level' => $faker->randomElement(['alto', 'medio', 'bajo']),
                'created_at' => $faker->dateTimeBetween('-15 days', 'now'),
                'devices_id' => $devices->random()->id,
            ]);
        }
    }
}
