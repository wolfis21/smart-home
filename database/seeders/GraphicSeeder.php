<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Graphic;

class GraphicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Graphic::create([
            'type_graphics' => 'línea',
            'data_json' => json_encode([
                'labels' => ['12:00', '12:15', '12:30', '12:45'],
                'data' => [0.35, 0.45, 0.40, 0.60]
            ]),
            'consumes_id' => 1,
        ]);

        Graphic::create([
            'type_graphics' => 'barras',
            'data_json' => json_encode([
                'labels' => ['Enero', 'Febrero', 'Marzo'],
                'data' => [12.1, 10.5, 14.3]
            ]),
            'consumes_id' => 2,
        ]);
    }
}
