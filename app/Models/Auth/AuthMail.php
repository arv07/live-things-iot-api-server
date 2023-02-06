<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Mail\AuthMailable;
use Illuminate\Support\Facades\Mail;
use stdClass;

class AuthMail extends Model
{
    use HasFactory;


    public function sendConfirmEmail($email, $hash, $password)
    {
        try {
            error_log("Alistando variables");
            $details = [
                'title' => ' Correo de industria code',
                'body' => 'Este es el body del correo',
                'link' => 'http://localhost/api/user/validateEmail/' . $hash,
                'password' => $password
            ];

            error_log("Cargando en mail");
            $authMail = new AuthMailable($details);

            error_log("Enviando meail");
            Mail::to($email)->send($authMail);

            return 'send';

            
        } catch (\Throwable $th) {

            return 'error sending email';
        }


        //return 'Mensaje envaido';
    }
}
