<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Automation;
use Carbon\Carbon;

class AutomationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Automation::create([
            'name' => 'Encender aire si hace calor',
            'conditions' => json_encode([
                'sensor' => 'temperatura',
                'operador' => '>',
                'valor' => 30
            ]),
            'action' => json_encode([
                'device_id' => 1,
                'action' => 'on'
            ]),
            'time_program' => Carbon::now()->addMinutes(10),
            'users_id' => 1,
        ]);

        Automation::create([
            'name' => 'Apagar luces a medianoche',
            'conditions' => json_encode([
                'hora' => '00:00'
            ]),
            'action' => json_encode([
                'device_id' => 3,
                'action' => 'off'
            ]),
            'time_program' => Carbon::tomorrow()->startOfDay(),
            'users_id' => 1,
        ]);
    }
}
