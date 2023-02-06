<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class MailController extends Controller
{
    public function sendEmail()
    {
        $details = [
            'title' => ' Correo de industria code',
            'body' => 'Este es el body del correo'
        ];

        Mail::to("andresrico07@gmail.com")->send(new TestMail($details));

        return 'Correo envaido';
    }
}
