<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Illuminate\Session\TokenMismatchException; 

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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

     public function render($request, Throwable $exception)
    {
        $url='';
        if(request()->is('admin*')){
            $url='admin';
        }else if(request()->is('owner*')){
            $url='owner';
        }else{
            $url='user';
        }
        // Tokenエラーの時、ログイン画面にリダイレクトする。
        if ($exception instanceof TokenMismatchException) {
            return redirect()->route('user.onecup')->with(['message'=>'送信できませんでした。再度、送信して下さい。']);
            // return redirect(route($url.'.login'));
        }

        return parent::render($request, $exception);
    }


    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
