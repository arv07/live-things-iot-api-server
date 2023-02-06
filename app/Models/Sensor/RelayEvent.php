<?php

namespace App\Models\Sensor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelayEvent extends Model
{
    use HasFactory;
    protected $table = 'relay_events';
    protected  $primaryKey = 'id_relay_event';

    protected $casts = [
        'updated_at'  => 'datetime:d-m-Y H:i', 
        'created_at'  => 'datetime:d-m-Y H:i'
    ];


    protected $fillable = [
        'state'
    ];
}
