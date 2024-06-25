<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Validation\Rule;

use Throwable;
use Illuminate\Support\Facades\Log;

use App\Models\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     

     public function __construct(){
        $this->middleware('auth:admin');
     }

    
    public function index()
    {

        $users=User::select('id','name','email','created_at')->paginate(8);
        
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $users=User::where('id','>',99)->get();
        // $users=User::where('id','>',99)->get();
        // // dd($users);
        // foreach($users as $user){

        //     $itti=0;
        //     $mySelect=0;

        //     //$user->nameの全角、半角スペースをなくし、変数に格納
        //     $user_name=str_replace(" ", "", $user->name);
        //     $user_name=str_replace("　", "", $user_name);
            
        //     //destinationテーブルから同じIDのデータを新しい順で取得
        //     $destinations=Destination::where('user_id',$user->id)->orderByDesc('id')->get();


        //     //コレクションが空ではないかのコレクションメソッド
        //     if(!$destinations->isEmpty()){
        //         // dd($destination);
        //         //コレクションの1レコード目のアクセスには$destinations[0]->nameもしくは下記foreachで
        //         foreach($destinations as $destination){
        //             //destination->nameの全角、半角スペースをなくして変数に格納
        //             $des_name=str_replace(" ", "", $destination->name);
        //             $des_name=str_replace("　", "", $des_name);
                    
        //             if($itti==0 && $des_name==$user_name){
                        
        //                 $itti=1;
                        
        //                 $destination->destination_home=true;
                        
        //                 $destination->save();
                        
        //                 Destination::where('user_id',$user->id)->where('id','<>',$destination->id)->update(['destination_home'=>false]);
        //             }

        //             if($mySelect==0 && $destination->is_select){
        //                 $mySelect=1;
        //                 //なぜか複数is_selectがtrueになっているので、ここで修正
        //                 Destination::where('user_id',$user->id)->where('id','<>',$destination->id)->update(['is_select'=>false]);
        //             }
        //         }
                
        //         if($itti==0){

        //             //上記操作で一致しなかった場合、最新のレコードを取得し、そのレコードを本人住所に設定する
        //             $destination=Destination::where('user_id',$user->id)->orderByDesc('id')->limit(1)->get();
        //             $destination[0]->destination_home=true;
        //             $destination[0]->save();
        //             // dd($destination[0]->id);

        //             Destination::where('user_id',$user->id)->where('id','<>',$destination[0]->id)->update(['destination_home'=>false]);

        //         }

                
        //         if($mySelect==0){
        //             //上記操作で一致しなかった場合、最新のレコードを取得し、そのレコードを選択中に設定する
        //             $destination=Destination::where('user_id',$user->id)->orderByDesc('id')->limit(1)->get();
        //             $destination[0]->is_select=true;
        //             $destination[0]->save();
        //             // dd($destination[0]->id);

        //             Destination::where('user_id',$user->id)->where('id','<>',$destination[0]->id)->update(['is_select'=>false]);
        //         }

        //     }
        // }



        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|confirmed|min:8'
        ]);

        //複数のテーブルを操作する時はトランザクション処理を入れる
        // try{
        //     DB::transaction(function() use($request){

                $user=User::create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>Hash::make($request->password),
                ]);
                
        //         Shop::create([
        //             'owner_id'=>$owner->id,
        //             'name'=>'店舗名',
        //             'infomation'=>'店舗情報',
        //             'filename'=>'',
        //             'is_selling'=>true
        //         ]);
        //     },2);

        // }catch(Throwable $e){
        //     Log::error($e);
        //     throw $e;
        // }

        return redirect()
               ->route('admin.users.index')
               ->with([
                    'message'=>'ユーザー情報を登録しました。',
                    'status'=>'info'
                ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $user=User::findOrFail($id);
        
        return view('admin.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //下記のバリデーションの返却地は配列を返す
        // $validateData=$request->validate([
        //     'name'=>'required|string|max:255',
        //     'email'=>'required|string|email|max:255|unique:owners',
        // ]);
        // dd($validateData);

        //Validator::makeの返却地はバリデーションオブジェクトを返却する
        $validateData=Validator::make($request->all(),[
                'name'=>'required|string|max:255',
                'email'=>['required','string','email','max:255',Rule::unique('users')->ignore($id)],
        ]);
        
            //ある項目が入力されていたらバリデートする方法（変数に格納しなくてもmakeの後に続けた方が完結）
        $validateData->sometimes('password','required|string|confirmed|min:8', function ($request) {
            return isset($request->password);
        })->validate();
        

        $user=User::findOrFail($id);

        $user->name=$request->name;
        $user->email=$request->email;

        //パスワードを変更しない場合は空の為、更新しないように
        if($request->password){
            $user->password=Hash::make($request->password);
        }
        $user->save();

        return redirect()
        ->route('admin.users.edit',['user'=>$id])
        ->with([
                'message'=>'ユーザー情報を更新しました。',
                'status'=>'info'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        User::findOrFail($id)->delete();

        return redirect()
        ->route('admin.users.index')
        ->with([
            'message'=>'ユーザー情報を削除しました。',
            'status'=>'alert'
        ]);
    }

}
