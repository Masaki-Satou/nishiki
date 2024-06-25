<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// use Illuminate\Support\Facades\Auth;
use App\Models\Shop;

use App\Services\imageService;

class ShopController extends Controller
{
    //
    public function __construct(){

        $this->middleware('auth:owners');

        // $this->middleware(function($request,$next){

        //     $id=$request->route()->parameter('shop');//shopのidを取得(文字列で取得される)
            
        //     if(!is_null($id)){
        //         $shopsOwnerId=Shop::findOrFail($id)->owner->id;
        //         $shopId=(int)$shopsOwnerId;
        //         $ownerId=Auth::id();//数字で取得される
        //         if($shopId!==$ownerId){
        //             abort(404);
        //         }
        //     }
        //     return $next($request);
        // });

     }

    function index(Request $request){

        $shops=Shop::orderby('sort_order','asc')->where('name','like','%'.$request->name.'%')->get();
        return view('owner.shops.index',compact('shops'));
    }

    function create(){

        return view('owner.shops.create');

    }

    function store(Request $request){

        $validateData=$request->validate([

            'name'=>'required|string|max:50',
            'filename' => 'required|file|image|mimes:jpeg,png,jpg,webp',
            'postcode'=>'required|string|max:8',
            'address'=>'required|string|max:50',
            'tel'=>'nullable|string|max:15',
            'email'=>'nullable|string|max:255',
            'holidays'=>'nullable|string|max:15',
            'time'=>'required|string|max:30',
            'information'=>'required|string|max:255',
            'sns'=>'nullable|url',
            'sort_order'=>'nullable|integer',
            'is_selling'=>'required',

        ]);


        $shop=new Shop;

        $shop->name=$request->name;


        //画像保存処理は別のクラスに分ける
        imageService::upload($shop,$request->filename,'public/shops/');
        // $tempFilename=$request->filename;
        // if(!is_null($tempFilename) && $tempFilename->isValid()){
            
        //     //basename()でファイル名だけを取得
        //     $shop->filename=basename(Storage::putFile('public/shops',$tempFilename));
        //     // $file_name=basename($request->filename->store('public/images/shops'));//別の保存方法
            
        // }
        
        $shop->postcode=$request->postcode;
        $shop->address=$request->address;
        $shop->tel=$request->tel;
        $shop->email=$request->email;
        $shop->holidays=$request->holidays;
        $shop->time=$request->time;
        $shop->information=$request->information;
        $shop->sns=$request->sns;
        $shop->sort_order=$request->sort_order;
        $shop->is_selling=$request->is_selling;
        
        $shop->save();
        

        return redirect()->route('owner.shops.edit',['shop'=>$shop->id])->with([
            'message'=>'店舗情報を登録しました。',
            'status'=>'info'
        ]);


    }

    function edit($id){
        
        $shop=Shop::findOrFail($id);

        return view('owner.shops.edit',compact('shop'));

    }

    function update(Request $request,$id){

         $validateData=$request->validate([

            'name'=>'required|string|max:50',
            'filename' => 'file|image|mimes:jpeg,png,jpg,webp',
            'postcode'=>'required|string|max:8',
            'address'=>'required|string|max:50',
            'tel'=>'nullable|string|max:15',
            'email'=>'nullable|string|max:255',
            'holidays'=>'nullable|string|max:15',
            'time'=>'required|string|max:30',
            'information'=>'required|string|max:255',
            'sns'=>'nullable|url',
            'sort_order'=>'nullable|integer',
            'is_selling'=>'required',

        ]);

        $shop=Shop::findOrFail($id);

        $shop->name=$request->name;

        //画像保存処理は別のクラスに分ける
        imageService::upload($shop,$request->filename,'public/shops/');
        // $tempFilename=$request->filename;
        // if(!is_null($tempFilename) && $tempFilename->isValid()){
            
        //     //画像の値が空ではない時は元の画像を削除する
        //     if(!is_null($shop->filename) && Storage::exists('public/shops/'.$shop->filename)){
        //         Storage::delete('public/shops/'.$shop->filename);
        //     }
            
        //     //basename()でファイル名だけを取得
        //     $shop->filename=basename(Storage::putFile('public/shops/',$tempFilename));
        //     // $file_name=basename($request->filename->store('public/images/shops'));//別の保存方法

        // }

        $shop->postcode=$request->postcode;
        $shop->address=$request->address;
        $shop->tel=$request->tel;
        $shop->email=$request->email;
        $shop->holidays=$request->holidays;
        $shop->time=$request->time;
        $shop->information=$request->information;
        $shop->sns=$request->sns;
        $shop->sort_order=$request->sort_order;
        $shop->is_selling=$request->is_selling;

        $shop->save();


        return redirect()->route('owner.shops.edit',['shop'=>$id])->with([
            'message'=>'店舗情報を更新しました。',
            'status'=>'info'
        ]);

    }
}
