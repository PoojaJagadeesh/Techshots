<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Arr;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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

    public function render($request, Throwable  $e)
  {

    if ($e instanceof AuthorizationException) {
        return response()->json([
            'status' => false,
            'message' => 'You are not authorized to perform this action.'
           ],401);
    }

    return parent::render($request, $e);
   }

   protected function unauthenticated($request, AuthenticationException $exception)
    {
        if($request->expectsJson()){
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        $guard = Arr::get($exception->guards(), 0);
         switch($guard){
            case 'admin':
                $login = route('admin.login');
                break;
            default:
                $login = route('premiumlogin');
                break;
         }
         return redirect()->guest($login);
    }

}
