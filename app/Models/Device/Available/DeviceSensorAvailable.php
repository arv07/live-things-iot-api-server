<?php

namespace App\Models\Device\Available;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceSensorAvailable extends Model
{
    use HasFactory;
    protected $table = 'devices_availables_sensors';
    protected  $primaryKey = 'id_device_available_sensor';

    protected $fillable = [
        'id_device_available',
        'id_sensor_available',
    ];
}
