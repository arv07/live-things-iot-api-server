<?php

namespace App\Http\Middleware;
use Illuminate\Auth\Access\AuthorizationException;
use PHPUnit\Exception;


use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return route('login');
            //return "1";

        } else {
            return response()->json(['state' => 'error', 'message' => 'user is not authenticated','data' => 0, 'levelNotification' => '2'], 200);
        }
    }
}
