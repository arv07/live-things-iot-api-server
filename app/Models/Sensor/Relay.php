<?php

namespace App\Models\Sensor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relay extends Model
{
    use HasFactory;
    protected $table = 'relay_sensors';
    protected  $primaryKey = 'id_relay';

    protected $fillable = [
        'state'
    ];

    protected $casts = [
        'updated_at'  => 'datetime:d-m-Y H:i', 
        'created_at'  => 'datetime:d-m-Y H:i'
    ];


    public function relayEvents()
    {
        return $this->hasMany(RelayEvent::class, 'id_relay', 'id_relay');
    }
}
