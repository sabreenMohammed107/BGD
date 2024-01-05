<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Response;

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
    }


    protected function unauthenticated($request, AuthenticationException $exception)
        {
            // if ($request->expectsJson()) {
            //     return response()->json(['error' => 'Unauthenticated.'], 401);
            // }
            if ($request->is('admin') || $request->is('admin/*')) {

                return redirect()->guest('/login/admin');
            }
            if ($request->is('doctor') || $request->is('doctor/*')) {

                return redirect()->guest('/login/doctor');
            }

            return redirect()->guest(route('login'));
        }

//         public function render($request, Throwable $e)
// {
//     if ($e instanceof AuthenticationException) {
//         return response()->json(
//             [
//                 'type' => 'error',
//                 'status' => Response::HTTP_UNAUTHORIZED,
//                 'message' => 'Access Token expires',
//             ],
//             Response::HTTP_UNAUTHORIZED
//         );
//         if ($request->is('admin') || $request->is('admin/*')) {

//             return redirect()->guest('/login/admin');
//         }
//         if ($request->is('doctor') || $request->is('doctor/*')) {

//             return redirect()->guest('/login/doctor');
//         }

//         return redirect()->guest(route('login'));
//     }

//     return parent::render($request, $e);
// }
}
