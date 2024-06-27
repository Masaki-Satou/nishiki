<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;


class UserController extends Controller
{


    public function welcome(Request $request){
        return view('user.welcome')->with('toast',$request->session()->get('toast'));
    }


    //各ディスカウントページでボタンが押された時にセッションにviewedを設定
    public function use(Request $request){
        $request->session()->put('viewed', true);
        return redirect()->route('user.welcome')->with('toast',1);
    }

    
    public function kani(){
        return view('user.kani');
    }


    public function karaage(){
        return view('user.karaage');
    }


    public function sushi(){
        return view('user.sushi');
    }

    public function potato(){
        return view('user.potato');
    }

    public function tume(){
        return view('user.tume');
    }

    public function eel(){
        return view('user.eel');
    }
    
    public function meat(){
        return view('user.meat');
    }


}
