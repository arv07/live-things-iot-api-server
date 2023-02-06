<?php

namespace App\Models\Device\Available;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorAvailable extends Model
{
    use HasFactory;
    protected $table = 'sensors_availables';
    protected  $primaryKey = 'id_sensor_available';

    protected $fillable = [
        'sensor',
        'reference',
    ];

    public function devicesAvailables()
    {
        return $this->belongsToMany(DeviceAvailable::class);
    }
}
