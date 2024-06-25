<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       
        if(request()->is('admin*')){
            config(['session.cookie'=>config('session.cookie_admin')]);
        }

        Password::defaults(function () {
            return Password::min(8)->letters()->numbers();//8文字以上で文字と数値を混在させるルール
        });
    }
}
