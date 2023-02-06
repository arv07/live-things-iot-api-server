<?php

namespace App\Models\Device\Available;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceAvailable extends Model
{
    use HasFactory;
    protected $table = 'devices_availables';
    protected  $primaryKey = 'id_device_available';

    protected $fillable = [
        'sensor',
        'reference',
    ];

    public function sensorsAvailables()
    {
        return $this->belongsToMany(SensorAvailable::class, 'devices_availables_sensors', 'id_device_available', 'id_sensor_available');
    }


    public function deviceAvailableExist($internalCode)
    {
        if(DeviceAvailable::where('internal_code', $internalCode)->get()->count())
        {
            return true;
        }
        else {
            return false;
        }
    }
}
