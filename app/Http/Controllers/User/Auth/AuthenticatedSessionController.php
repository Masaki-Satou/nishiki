<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Cart;
use App\Models\Destination;
use App\Models\Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('user.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        
        Auth::guard('users')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function guestLogin()
    {
        $user=User::where(function($query){//複雑なwhere条件が増えた時の為にくくっている

            //sessionsテーブルのlast_activityがプラス60*60*\Constant::GUEST_HOUR以上経過していないuser_id（null以外を入れとかないとwhereNotInでおかしくなる）を取得してwhereNotInでそのuserをはじく
            $query->where('id','<',100)->whereNotIn('id',Session::select('user_id')->whereNotNull('user_id')->where('last_activity','>',time()-60*60*\Constant::GUEST_HOUR)->get()->toArray());
        })->first();

        // dd($user);
        
        if($user){
            //取得したゲストがカートに入れたまま決済していない時を想定してカート内を削除しておく
            Cart::where('user_id',$user->id)->delete();

            //送り先を全てfalseにして表示されないようにしておく（消すと過去の同じゲストIDの購入者の履歴が確認できないようになる）
            $destinations=Destination::where('user_id',$user->id)->get();
            foreach($destinations as $destination){
                $destination->is_select=false;
                $destination->save();
            }

            $email = 'guest@'.$user->id.'.com';
            $password = 'guest';
    
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                return back();
            }
        }

        return redirect()->back()->with(['message'=>'大変申し訳ございません。現在ゲストログインに障害が発生しております。','status'=>'alert']);
    }
}
