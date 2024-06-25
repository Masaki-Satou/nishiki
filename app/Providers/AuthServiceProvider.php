<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use Illuminate\Auth\Notifications\ResetPassword;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //ガード事にパスワードリセットのURLを作成
        ResetPassword::createUrlUsing(function ($user, string $token) {
            // dd($user);
            $url='';
          
            $url='user';
            
            return url(route($url.'.password.reset', ['token' => $token,'email'=>$user->email]));
        });
    }
}
