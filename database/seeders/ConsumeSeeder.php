<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Consume;
use Carbon\Carbon;

class ConsumeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Consume::create([
            'measured_at' => Carbon::now()->subMinutes(30),
            'energy_consumption' => '0.45',
            'voltage' => '110',
            'current' => '4.1',
            'devices_id' => 1,
        ]);

        Consume::create([
            'measured_at' => Carbon::now()->subMinutes(20),
            'energy_consumption' => '0.60',
            'voltage' => '120',
            'current' => '5.0',
            'devices_id' => 1,
        ]);

        Consume::create([
            'measured_at' => Carbon::now()->subMinutes(10),
            'energy_consumption' => '0.10',
            'voltage' => '110',
            'current' => '0.8',
            'devices_id' => 3,
        ]);
        
        $deviceId = 1; // Aire acondicionado

        for ($i = 0; $i < 10; $i++) { // 10 registros provisionales de prueba
            Consume::create([
                'measured_at' => Carbon::now()->subMinutes($i * 15),
                'energy_consumption' => number_format(rand(30, 80) / 100, 2), // 0.30 a 0.80
                'voltage' => rand(110, 125), //Voltaje (110 – 125)
                'current' => number_format(rand(20, 60) / 10, 1), // Corriente 2.0 a 6.0
                'devices_id' => 1,
            ]);
            Consume::create([
                'measured_at' => Carbon::now()->subMinutes($i * 15),
                'energy_consumption' => number_format(rand(30, 80) / 100, 2), // 0.30 a 0.80
                'voltage' => rand(110, 125), //Voltaje (110 – 125)
                'current' => number_format(rand(20, 60) / 10, 1), // Corriente 2.0 a 6.0
                'devices_id' => 2,
            ]);
            Consume::create([
                'measured_at' => Carbon::now()->subMinutes($i * 15),
                'energy_consumption' => number_format(rand(30, 80) / 100, 2), // 0.30 a 0.80
                'voltage' => rand(110, 125), //Voltaje (110 – 125)
                'current' => number_format(rand(20, 60) / 10, 1), // Corriente 2.0 a 6.0
                'devices_id' => 3,
            ]);
        }
    }
}
