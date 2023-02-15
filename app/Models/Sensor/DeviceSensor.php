<?php

namespace App\Models\Sensor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sensor\Fingerprint\Fingerprint;
use App\Models\Sensor\Movement\Movement;

class DeviceSensor extends Model
{
    use HasFactory;
    protected $table = 'device_sensors';
    protected  $primaryKey = 'id_device_sensor';

    protected $fillable = [
        'sensors'
    ];


    public function fingerprint()
    {
        return $this->hasMany(Fingerprint::class, 'id_device_sensor', 'id_device_sensor');
    }

    public function relay()
    {
        return $this->hasMany(Relay::class, 'id_device_sensor', 'id_device_sensor');
    }

    public function movement()
    {
        return $this->hasMany(Movement::class, 'id_device_sensor', 'id_device_sensor');
    }
}
