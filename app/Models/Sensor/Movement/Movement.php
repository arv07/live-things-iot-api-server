<?php

namespace App\Models\Sensor\Movement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;
    protected $table = 'movement_sensors';
    protected  $primaryKey = 'id_movement_sensor';

    protected $fillable = [
        'state'
    ];
}
