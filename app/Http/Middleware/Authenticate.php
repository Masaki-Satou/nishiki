<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

use Illuminate\Support\Facades\Route;


class Authenticate extends Middleware
{
    //ログインが必要な画面にアクセスした時のリダイレクト先
    private $user_route='user.onecup';

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            
            return route($this->user_route);

        }
    }
}
