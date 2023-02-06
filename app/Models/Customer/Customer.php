<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected  $primaryKey = 'id_customer';

    protected $fillable = [
        'identification',
        'name'
    ];
}
