<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Area;

class AreaController extends Controller
{
    //
    public function __construct(){

        $this->middleware('auth:owners');
    
    }

    public function edit(){
        $areas=Area::with('prefectures')->get();
        // dd($areas);
        return view('owner.areas.edit',compact('areas'));
    }
    


    public function update(Request $request){
        
        $request->validate(
            [
                'areas.*' => 'required',
            ]
        );

        for($i=1;$i<=count($request->areas);$i++){
            Area::where('id',$i)->update(['price'=>$request->areas[$i]]);
        }

        return redirect()
        ->route('owner.areas.edit')
        ->with([
             'message'=>'送料を更新しました。',
             'status'=>'info'
         ]);

    }
}
