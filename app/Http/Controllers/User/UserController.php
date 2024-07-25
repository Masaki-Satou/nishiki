<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Onecup;


class UserController extends Controller
{


    public function onecup2(){
        // dd(request()->session());
        $onecups=Onecup::orderby('id','desc')->get()   ;
        // dd("2");
        return view('user.onecup',compact('onecups'))->with(['message'=>'送信に失敗しました。再度、送信して下さい。']);
    }

    public function onecup(){
        $onecups=Onecup::orderby('id','desc')->get()   ;
        // dd("0");
        return view('user.onecup',compact('onecups'));
    }

    public function onecupEntry(Request $request){
        
        // if ($request->session()->has('form_submitted')) {
        //     return redirect()->back();
        // }else{
        //     $request->session()->put('form_submitted', true);
        // }
        

        $validatedData = $request->validate([
            'name' => 'required|string|max:30',
            'quantity' => 'required|integer',
        ]);

        $onecut=Onecup::create([
            'name'=>$request->name,
            'quantity'=>$request->quantity,
        ]);
        
        // $request->session()->forget('form_submitted');
    
        return redirect()->route('user.onecup');
    }

    
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
