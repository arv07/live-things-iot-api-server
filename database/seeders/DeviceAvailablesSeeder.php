<?php

namespace Database\Seeders;

use App\Models\Device\Available\DeviceAvailable;
use App\Models\Device\Available\DeviceSensorAvailable;
use App\Models\Device\Available\SensorAvailable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceAvailablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** SENSORS */
        SensorAvailable::create([
            'sensor' => 'fingerprint',
            'reference' => 'AS608',
        ]);

        SensorAvailable::create([
            'sensor' => 'relay',
            'reference' => 'G3MB-202P 5V',
        ]);

        SensorAvailable::create([
            'sensor' => 'movement',
            'reference' => 'HC SR501',
        ]);

        /** DEVICES */
        DeviceAvailable::create([
            'name' => 'Access Door V1',
            'internal_code' => '123456',
            'reference' => 'DDA1',
            'version' => 'V1'            
        ]);

        DeviceAvailable::create([
            'name' => 'Smart Light V1',
            'internal_code' => '987654',
            'reference' => 'DRL1',
            'version' => 'V1'            
        ]);


        //Device DDA1 has AS608 sensor
        DeviceSensorAvailable::create([
            'id_device_available' => 1, 
            'id_sensor_available' => 1
        ]);

        //Device DRL1 has G3MB-202P 5V sensor
        DeviceSensorAvailable::create([
            'id_device_available' => 2, 
            'id_sensor_available' => 2
        ]);

        //Device DRL1 has HC SR501
        DeviceSensorAvailable::create([
            'id_device_available' => 2, 
            'id_sensor_available' => 3
        ]);
        
    }
}
