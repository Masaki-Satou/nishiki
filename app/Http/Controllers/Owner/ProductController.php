<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Image;
use App\Models\Stock;

use App\Models\PrimaryCategory;

class ProductController extends Controller
{
    public function __construct(){

        $this->middleware('auth:owners');
    
    }

    public function index(Request $request)
    {   
        $category=$request->category;//whenのfunctionの中でuseで変数を渡すのエラー回避
        $is_selling=$request->is_selling;//whenのfunctionの中でuseで変数を渡すのエラー回避
       
        //文字列でtrue,falseがわたってくるので、boolead型に変換
        if(is_null($is_selling) || $is_selling=='true'){//初期表示時（デフォルトの販売中）と販売中選択時
            $is_selling=true;
        }else if($is_selling=='false'){
            $is_selling=false;
        }


        $categories=PrimaryCategory::with('secondary')->get();
        // $products=Product::all();
        // withでイーガーローディング（この場合はビュー側でimage1のリレーション先のimagefileとstockを取得する時の対処）
        $products=Product::with('imageFirst','stock')
                 ->when($category,function($query) use($category){return $query->where('secondary_category_id',$category );})
                 ->where('is_selling',$is_selling)
                 ->orderby('sort_order','asc')->get();
        
        return view('owner.products.index',compact('products','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $images=Image::select('id','title','filename')->orderby('updated_at','desc')->get();
        $categories=PrimaryCategory::with('secondary')->get();

        return view('owner.products.create',compact('images','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'name'=>'required|string|max:50',
            'information'=>'required|string|max:510',
            'price'=>'required|integer',
            'is_selling'=>'required|boolean',
            'sort_order'=>'nullable|integer',
            'quantity'=>'required|integer|between:0,1000',
            'category'=>'required|exists:secondary_categories,id',
            'image1'=>'required|exists:images,id',
            'image2'=>'nullable|exists:images,id',
            'image3'=>'nullable|exists:images,id',
            'image4'=>'nullable|exists:images,id',
            
        ]);

        try{
            DB::transaction(function() use($request){
                $product=Product::create([
                    'name'=>$request->name,
                    'information'=>$request->information,
                    'price'=>$request->price,
                    'sort_order'=>$request->sort_order,
                    'secondary_category_id'=>$request->category,
                    'image1'=>$request->image1,
                    'image2'=>$request->image2,
                    'image3'=>$request->image3,
                    'image4'=>$request->image4,
                    'is_selling'=>$request->is_selling,
                ]);
    
                Stock::create([
                    'product_id'=>$product->id,
                    'type'=>1,
                    'quantity'=>$request->quantity,
                ]);
            },2);
           


        }catch(Throwable $e){
            Log::error($e);
            throw $e;
        }

        return redirect()
        ->route('owner.products.index')
        ->with(['message'=>'商品を登録しました',
                'status'=>'info']);
    }

    
    
    public function edit($id)
    {
        $product=Product::findOrFail($id);
        $quantity=Stock::where('product_id',$product->id)->sum('quantity');
        $images=Image::select('id','title','filename')->orderby('updated_at','desc')->get();
        $categories=PrimaryCategory::with('secondary')->get();


        return view('owner.products.edit',compact('product','quantity','images','categories'));
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

        $request->validate([

            'name'=>'required|string|max:50',
            'information'=>'required|string|max:510',
            'price'=>'required|integer',
            'is_selling'=>'required|boolean',
            'sort_order'=>'nullable|integer',
            'quantity'=>'nullable|integer|between:0,1000',

            'current_quantity'=>'required|integer',

            'category'=>'required|exists:secondary_categories,id',
            'image1'=>'required|exists:images,id',
            'image2'=>'nullable|exists:images,id',
            'image3'=>'nullable|exists:images,id',
            'image4'=>'nullable|exists:images,id',
            
        ]);

        $product=Product::findOrFail($id);
        $quantity=Stock::where('product_id',$product->id)->sum('quantity');
        
        //0の時に数値と数字になって正しくうごかないので、厳密に比べていないので、厳密(!==)にするのならキャストが必要
        if($request->current_quantity!=$quantity){
            // $id=$request->route()->parameter('product');//ルートでパレメーターを設定している時のパラメーター取得の方法（基本は引数の$idから取得）
            return redirect()->route('owner.products.edit',['product'=>$id])
            ->with(['message'=>'商品が購入されたか別の方が更新したため、在庫数が変動しましたので再度在庫数を確認して下さい',
            'status'=>'alert']);;
        }else{

            try{
                DB::transaction(function() use($request,$product){
                   
                    $product->name=$request->name;
                    $product->information=$request->information;
                    $product->price=$request->price;
                    $product->sort_order=$request->sort_order;
                    $product->secondary_category_id=$request->category;
                    $product->image1=$request->image1;
                    $product->image2=$request->image2;
                    $product->image3=$request->image3;
                    $product->image4=$request->image4;
                    $product->is_selling=$request->is_selling;
                    // dd($product->temperature_zone);
                    $product->save();

                    //増減する数量が入力されていたらStockテーブルも作成
                    if(!is_null($request->quantity)){
                        if($request->type===\Constant::PRODUCT_ADD){
                            $newQuantity=$request->quantity;
                        }else if($request->type===\Constant::PRODUCT_REDUCE){
                            $newQuantity=$request->quantity*-1;
                        }
                        Stock::create([
                            'product_id'=>$product->id,
                            'type'=>$request->type,
                            'quantity'=>$newQuantity,
                        ]);
                    }
                },2);
               
    
    
            }catch(Throwable $e){
                Log::error($e);
                throw $e;
            }

            return redirect()->route('owner.products.edit',['product'=>$id])
            ->with(['message'=>'商品情報を更新しました。',
            'status'=>'info']);;

        }




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::findOrFail($id)->delete();

        return redirect()->route('owner.products.index')->with(['message'=>'商品情報を削除しました。','status'=>'alert']);

    
    }
}
