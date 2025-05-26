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
            'name' => 'Smart Breaker de aire acondicionado cuarto principal',
            'type' => 'climatización',
            'status' => 'activo',
            'protocol' => 'iot/airconditioner',
            'location' => 'aire principal',
            'users_id' => 1,
        ]);
        Device::create([
            'name' => 'Smart Breaker de aire acondicionado cuarto secundario',
            'type' => 'climatización',
            'status' => 'activo',
            'protocol' => 'iot/airconditioner2',
            'location' => 'aire de visita',
            'users_id' => 1,
        ]);

        Device::create([
            'name' => 'Smart Breaker de nevera de la cocina',
            'type' => 'electrodoméstico',
            'status' => 'activo',
            'protocol' => 'iot/fridge',
            'location' => 'Cocina',
            'users_id' => 1,
        ]);

        Device::create([
            'name' => 'Smart Breaker de lavadora-Secadora',
            'type' => 'electrodoméstico',
            'status' => 'activo',
            'protocol' => 'iot/washer_dryer',
            'location' => 'Cocina',
            'users_id' => 1,
        ]);
        
        Device::create([
            'name' => 'Bombillo sala',
            'type' => 'electrodoméstico',
            'status' => 'activo',
            'protocol' => 'iot/energy1',
            'location' => 'Sala',
            'users_id' => 1,
        ]);
        
        Device::create([
            'name' => 'Bombillo cuarto 1',
            'type' => 'electrodoméstico',
            'status' => 'activo',
            'protocol' => 'iot/energy2',
            'location' => 'cuarto principal',
            'users_id' => 1,
        ]);
        
        Device::create([
            'name' => 'Bombillo cuarto 2',
            'type' => 'electrodoméstico',
            'status' => 'activo',
            'protocol' => 'iot/energy3',
            'location' => 'cuarto de visita',
            'users_id' => 1,
        ]);
        
        Device::create([
            'name' => 'Bombillo baño',
            'type' => 'electrodoméstico',
            'status' => 'activo',
            'protocol' => 'iot/energy5',
            'location' => 'baño',
            'users_id' => 1,
        ]);
        
        Device::create([
            'name' => 'Bombillo cocina',
            'type' => 'electrodoméstico',
            'status' => 'activo',
            'protocol' => 'iot/energy4',
            'location' => 'Cocina',
            'users_id' => 1,
        ]);

        Device::create([
            'name' => 'Smart Breaker de cocina electrica',
            'type' => 'electrodoméstico',
            'status' => 'activo',
            'protocol' => 'iot/kitchen',
            'location' => 'Cocina',
            'users_id' => 1,
        ]);

        Device::create([
            'name' => 'Termostato',
            'type' => 'electrodoméstico',
            'status' => 'activo',
            'protocol' => 'iot/temperature/humedad',
            'location' => 'General',
            'users_id' => 1,
        ]);

        Device::create([
            'name' => 'Sensor de humo',
            'type' => 'electrodoméstico',
            'status' => 'activo',
            'protocol' => 'iot/sensor',
            'location' => 'General',
            'users_id' => 1,
        ]);

        Device::create([
            'name' => 'Smart Breaker del calentador de agua',
            'type' => 'electrodoméstico',
            'status' => 'activo',
            'protocol' => 'iot/water_heater',
            'location' => 'General',
            'users_id' => 1,
        ]);
    }
}
