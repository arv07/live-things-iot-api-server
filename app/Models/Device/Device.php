<?php

namespace App\Models\Device;

use App\Models\Sensor\DeviceSensor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $table = 'devices';
    protected  $primaryKey = 'id_device';

    protected $fillable = [
        'name',
        'description',
        'location',
        'state',
        'id_socket',
        'internal_code',
        'reference',
        'version',
        'device_token',
       

    ];

    protected $casts = [
        'updated_at'  => 'datetime:d-m-Y H:i', 
        'created_at'  => 'datetime:d-m-Y H:i'
    ];

    protected $hidden = [
        'user_token',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function sensors()
    {
        return $this->hasMany(DeviceSensor::class, 'id_device', 'id_device');
    }


    public function isDeviceInUse($internalCode)
    {
        if(Device::where('internal_code', $internalCode)->get()->count())
        {
            return true;
        }
        else {
            return false;
        }
    }
}
