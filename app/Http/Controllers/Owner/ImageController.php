<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Image;
use App\Models\Product;

use App\Services\imageService;

class ImageController extends Controller
{
    public function __construct(){

        $this->middleware('auth:owners');
    
    }

    public function index()
    {

    //通常のイーガーローディング
    //    $images=Image::with('pImage1','pImage2','pImage3','pImage4')->orderBy('updated_at','desc')->paginate(20);//orderByDesc('updated_at')でもOK

       //withCountでリレーション先のカウントを取得。下記の'pImage1'の例で言うと、p_image_count　というカラムを追加して値を持ってくれる
       $images=Image::select(['id','filename','title'])->withCount(['pImage1','pImage2','pImage3','pImage4'])->orderBy('updated_at','desc')->paginate(20);//orderByDesc('updated_at')でもOK
    //    $images=Image::findOrFail(1); 
    //    dd($images);
       return view('owner.images.index',compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('owner.images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'files.*.image' => 'required|file|image|mimes:jpeg,png,jpg,webp',
            ]
        );

        
        $imagefiles=$request->file('files');
        if(!is_null($imagefiles)){
            foreach($imagefiles as $imagefile){
                $image=new Image;
                imageService::upload($image,$imagefile['image'],'public/products/');
                $image->save();
            }
        }

        return redirect()->route('owner.images.index')->with(['message'=>'画像を登録しました。','status'=>'info']);

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
        //
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
        $request->validate(['title'=>'string|max:30']);


        $image=Image::findOrFail($id);

        $image->title=$request->title;

        $image->save();

        return redirect()->route('owner.images.index')->with(['message'=>'alt属性値を更新しました。','status'=>'info']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image=Image::findOrFail($id);

        $imageInProducts=Product::
                 Where('image1',$image->id)
               ->orWhere('image2',$image->id)
               ->orWhere('image3',$image->id)
               ->orWhere('image4',$image->id)
               ->get();

        if($imageInProducts){
            //foreach($imageInProducts as $product){}でもいい
            $imageInProducts->each(function($product) use($image){
                if($product->image1===$image->id){
                    $product->image1=null;
                    $product->save();
                }
                if($product->image2===$image->id){
                    $product->image2=null;
                    $product->save();
                }
                if($product->image3===$image->id){
                    $product->image3=null;
                    $product->save();
                }
                if($product->image4===$image->id){
                    $product->image4=null;
                    $product->save();
                }
            });
        }

        imageService::delete($image,$image->filename,'public/products/');

        $image->delete();

        return redirect()->route('owner.images.index')->with(['message'=>'画像を削除しました。','status'=>'alert']);

    }
}
