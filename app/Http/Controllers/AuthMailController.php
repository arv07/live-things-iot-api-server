<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuthMailable;

class AuthMailController extends Controller
{
    /* public function validateEmail($email, $hash)
    {
        $details = [
            'title' => ' Correo de industria code',
            'body' => 'Este es el body del correo',
            'link' => 'http://localhost/api/validateEmail/'.$hash
        ];
        $authMail = new AuthMailable($details);

        Mail::to($email)->send($authMail);

        return 'Mensaje envaido';
    } */
}
