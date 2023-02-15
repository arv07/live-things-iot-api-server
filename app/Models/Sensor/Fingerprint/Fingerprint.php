<?php

namespace App\Models\Sensor\Fingerprint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sensor\Fingerprint\FingerprintUser;

class Fingerprint extends Model
{
    use HasFactory;
    protected $table = 'fingerprint_sensors';
    protected  $primaryKey = 'id_fingerprint_sensor';

    protected $fillable = [
        'reference',
    ];


    public function fingerprintUsers()
    {
        return $this->hasMany(FingerprintUser::class, 'id_fingerprint_sensor', 'id_fingerprint_sensor');
    }

}


