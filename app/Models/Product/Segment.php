<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    use HasFactory;

    protected $table = 'segments';
    protected  $primaryKey = 'id_segment';

    protected $fillable = [
        'segment',
        
    ];
}
