<?php

namespace App\Models\Utils;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utils extends Model
{
    //use HasFactory;

    public function createRandomToken(Int $length): String
    {
        //Generate a random string.
        $token = openssl_random_pseudo_bytes($length);
        //Convert the binary data into hexadecimal representation.
        $token = bin2hex($token);

        return $token;
    }
}
