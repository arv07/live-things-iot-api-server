<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\Finder\Exception\AccessDeniedException;
class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                /*return response()->json([
                    'message' => 'Not authenticated ppp'
                ], 401);*/
                return response()->json(['state' => 'error', 'message' => 'user is not authenticated', 'levelNotification' => '2'], 401);
            }
        });

        $this->renderable(function (\Illuminate\Auth\Access\HandlesAuthorization $e, $request) {
            if ($request->is('api/*')) {
                /*return response()->json([
                    'message' => 'Not authenticated ppp'
                ], 401);*/
                return response()->json(['state' => 'error', 'message' => 'sin permisos', 'levelNotification' => '2'], 401);
            }
        });
    }
}
