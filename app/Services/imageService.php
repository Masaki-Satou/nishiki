<?php


namespace App\Services;

use Illuminate\Support\Facades\Storage;

class imageService{

    //$modelはモデルを格納している変数で、カラム名はfilenameと想定している
    public static function upload($model,$filename,$path){

        // dd($filename);
        if(!is_null($filename) && $filename->isValid()){
            
            //modelの画像の値が空ではない時は元の画像を削除する
            if(!is_null($model->filename) && Storage::exists($path.$model->filename)){
                Storage::delete($path.$model->filename);
            }
            
            //basename()でファイル名だけを取得
            $model->filename=basename(Storage::putFile($path,$filename));
            // $file_name=basename($request->filename->store('public/images/shops'));//別の保存方法

        }

    }

    public static function delete($model,$filename,$path){
   
        //modelの画像の値が空ではない時は元の画像を削除する
        if(!is_null($model->filename) && Storage::exists($path.$model->filename)){
            Storage::delete($path.$model->filename);
        }


    }
}