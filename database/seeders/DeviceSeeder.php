<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Device;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Device::create([
            'name' => 'Aire acondicionado',
            'type' => 'climatización',
            'status' => 'activo',
            'protocol' => 'WiFi',
            'location' => 'Sala',
            'users_id' => 1,
        ]);

        Device::create([
            'name' => 'Nevera',
            'type' => 'electrodoméstico',
            'status' => 'activo',
            'protocol' => 'Zigbee',
            'location' => 'Cocina',
            'users_id' => 1,
        ]);

        Device::create([
            'name' => 'Luz del cuarto',
            'type' => 'iluminación',
            'status' => 'inactivo',
            'protocol' => 'Z-Wave',
            'location' => 'Habitación Principal',
            'users_id' => 1,
        ]);
    }
}
