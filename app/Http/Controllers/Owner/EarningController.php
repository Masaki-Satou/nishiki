<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Earning;
use App\Models\Detail;

use Illuminate\Support\Facades\DB;

use App\Jobs\SendInvoiceMail;

use Symfony\Component\HttpFoundation\StreamedResponse;

class EarningController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth:owners');
    }

    public function index(Request $request){

        //scope化を検討
        $startDay=$request->startDay;//whenのfunction useで渡すには変数に格納が必要
        $endDay=$request->endDay;
        if($endDay){
            $endDay=$request->endDay.' 23:59:59';//これを入れないと00:00:00になって実質前日までになる
        }

       
        //get()せずにeloquentのままならsubjoinに使用できる(get()するとコレクションになる？)
        $invoiceTotalPrice=Detail::
        when($startDay,
        function($query) use($startDay){ return $query->where('created_at','>=',$startDay);})
        ->when($endDay,
        function($query) use($endDay){ return $query->where('created_at','<=',$endDay);})
        ->select(DB::raw('sum(price * quantity) as invoiceTotalPrice,earning_id'))->groupBy('earning_id');

        $earnings=Earning::
        when($startDay,
        function($query) use($startDay){ return $query->where('created_at','>=',$startDay);})
        ->when($endDay,
        function($query) use($endDay){ return $query->where('created_at','<=',$endDay);})
        ->joinSub($invoiceTotalPrice,'invoiceTotalPrice',function($join){$join->on('id','invoiceTotalPrice.earning_id');})->with('details','user','destination','destination.prefecture','timeZone')->orderby('created_at','desc')->get();
        

        //上でソフトデリート以外の伝票番号事の売上がinvoiceTobalPriceに入っているので、総合計はsumで取得
        $totalPrice=$earnings->sum('invoiceTotalPrice');

        return view('owner.earnings.index',compact('earnings','totalPrice'));
    }



    public function noinvoice(){
        $invoiceTotalPrice=Detail::select(DB::raw('sum(price * quantity) as invoiceTotalPrice,earning_id'))->groupBy('earning_id');
        $earnings=Earning::joinSub($invoiceTotalPrice,'invoiceTotalPrice',function($join){$join->on('id','invoiceTotalPrice.earning_id');})->with('details','user','destination','destination.prefecture','timeZone')->whereNull('invoice')->orderby('created_at','desc')->get();
        return view('owner.earnings.noinvoice',compact('earnings'));
    }




    public function invoice_update(Request $request,$id){
       
        $earning=Earning::findOrFail($id);
        
        // $oldinvoice=$earning->invoice;//更新する前の値を取得しておく

        $earning->invoice=$request->invoice;

        $earning->save();

        SendInvoiceMail::dispatch($earning,$earning->user);

        return redirect()->route('owner.earnings.show',['id'=>$id])->with(['message'=>'送り状番号を反映しました','status'=>'info']);

        // if($oldinvoice && $request->invoice){
        //     return redirect()->route('owner.earnings.index')->with(['message'=>'送り状番号を修正しました',
        //     'status'=>'info']);
        // }else if(is_null($oldinvoice) && $request->invoice){
        //     return redirect()->route('owner.earnings.noinvoice')->with(['message'=>'送り状番号を登録しました',
        //     'status'=>'info']);
        // }else{
        //     return redirect()->route('owner.earnings.noinvoice')->with(['message'=>'未発送に戻しました。',
        //     'status'=>'info']);
        // }

    }



    public function show($id){

        
        // キャンセル処理後も閲覧可能にする為に、withTrashed()でゴミ箱も含めた検索をする
        $earning=Earning::withTrashed()->findOrFail($id);
        
        //キャンセル確定以外の未発送含むデータ
        $earnings=Earning::where('user_id',$earning->user_id)->get();

        $totalPrice=0;
        foreach($earning->details as $detail){
            $totalPrice+=$detail->price * $detail->quantity;
        }
        return view('owner.earnings.show',compact('earning','totalPrice','earnings'));
    }



    public function note_update(Request $request,$id){
       
        // キャンセル処理後もメモの編集は可能にしておく為に、withTrashed()でゴミ箱も含めた検索をする
        $earning=Earning::withTrashed()->findOrFail($id);
        
        $earning->note=$request->note;

        $earning->save();

        return redirect()->route('owner.earnings.show',['id'=>$id])->with(['message'=>'メモ書きを反映しました','status'=>'info']);

    }


    public function delete_list(){
        $invoiceTotalPrice=Detail::select(DB::raw('sum(price * quantity) as invoiceTotalPrice,earning_id'))->groupBy('earning_id');
        $earnings=Earning::onlyTrashed()->joinSub($invoiceTotalPrice,'invoiceTotalPrice',function($join){$join->on('id','invoiceTotalPrice.earning_id');})->with('details','user','destination','destination.prefecture','timeZone')->orderby('created_at','desc')->get();
        
    //    foreach($earnings as $earning){
    //        foreach($earning->details as $detail){
    //            dd($detail->product->name);
    //        }
    //    }
        
        return view('owner.earnings.deletelist',compact('earnings'));
    }


    public function soft_delete($id){

        Earning::findOrFail($id)->delete();//この場合はsoftDeleteになるように設定している

        return redirect()->route('owner.earnings.show',['id'=>$id])->with(['message'=>'キャンセル処理を行いました。','status'=>'alert']);

    }

    public function delete_cancel($id){

        Earning::onlyTrashed()->findOrFail($id)->restore();//softDeleteを戻す

        return redirect()->route('owner.earnings.show',['id'=>$id])->with(['message'=>'キャンセルを解除しました。','status'=>'info']);

    }



    public function pdf($id) {

        $earning=Earning::findOrFail($id);
        // $totalPrice=Detail::where('earning_id',$earning->id)->select(DB::raw('sum(quantity * price) as totalPrice'))->value('totalPrice');
        // $totalPrice=$earning->details->map(function($item){ return $item->quantity * $item->price; })->sum();//レコードごとの合計金額のコレクションを作成し、その合計を取得
        
        $totalPrice=$earning->details->reduce(function($carry,$item){ return $carry + $item->quantity * $item->price; },0);//コレクションを作成せず、関数内で累積値を計算
        $shippingTotalPrice=$earning->details->reduce(function($carry,$item){ 
            //送料の合計を取得（product_idがnullの時は送料なので）
            if(is_null($item->product_id)){
                return $carry + $item->quantity * $item->price;
            }
         },0);//コレクションを作成せず、関数内で累積値を計算

        // dd($shippingTotalPrice);
        
        $pdf = \PDF::loadView('owner.earnings.pdf',compact('earning','totalPrice','shippingTotalPrice'));
        // return $pdf->download('納品明細書.pdf');
        return $pdf->stream('納品明細書.pdf');

    }


    public function downloadCsv(Request $request)
    {
        $startDay=$request->startDay;//whenのfunction useで渡すには変数に格納が必要
        $endDay=$request->endDay;
        if($endDay){
            $endDay=$request->endDay.' 23:59:59';//これを入れないと00:00:00になって実質前日までになる
        }

        //Earningモデルにはソフトデリートを適用させているので、get()したときにはソフトデリートのrowは取得されない
        $earnings=Earning::
        // rightJoin('details','earnings.id','=','details.earning_id')
        // ->leftJoin('users','users.id','=','earnings.user_id')
        // ->leftJoin('products','products.id','=','details.product_id')
        
        // ->select('details.earning_id','earnings.created_at','earnings.user_id','users.name as user_name','details.product_id','products.name as product_name','details.price','details.quantity')
        when($startDay,
        function($query) use($startDay){ return $query->where('earnings.created_at','>=',$startDay);})
        ->when($endDay,
        function($query) use($endDay){ return $query->where('earnings.created_at','<=',$endDay);})
        ->cursor();//クエリの結果セットがイテレーターとして返され、メモリに一度にロードされるのではなく、必要に応じて行ごとに取得される。
        
        //dd($earnings);

        $csvHeader = [
            '売上ID', '購入日','会員ID','氏名', '商品ID', '商品名', '単価（税込）','数量'
        ];

        $temps = [];

        array_push($temps, $csvHeader);
    
        foreach ($earnings as $earning) {
            foreach($earning->details as $detail){
                $product_name= $detail->product_id ? $detail->product->name : '送料';
                $temp = [
                    $earning->id,
                    $earning->created_at,
                    $earning->user_id,
                    $earning->user->name,
                    $detail->product_id,
                    $product_name,
                    $detail->price,
                    $detail->quantity
                ];
                array_push($temps, $temp);
            }

            // $product_name= $earning['product_id'] ? $earning['product_name']:'送料';
            // $temp = [
            //     $earning['earning_id'],//earning->earning_idでも取得できそう
            //     $earning['created_at'],
            //     $earning['user_id'],
            //     $earning['user_name'],
            //     $earning['product_id'],
            //     $product_name,
            //     $earning['price'],
            //     $earning['quantity'],
            // ];
            // array_push($temps, $temp);
        }
        $stream = fopen('php://temp', 'w');
        foreach ($temps as $temp) {
            fputcsv($stream, $temp);
        }
        
        rewind($stream);//ポインタをファイルの先頭に移動
        $csv = str_replace(PHP_EOL, "\r\n", stream_get_contents($stream));
        $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');
        $filename = "売上一覧.csv";
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename='.$filename,
        );
        
        return response($csv, 200, $headers);


        // $csvHeader = ['売上ID', '購入日','会員ID','氏名', '商品ID', '商品名', '単価','数量'];
        
        // $csvData = $earnings->toArray();
        
        // $response = new StreamedResponse(function () use ($csvHeader, $csvData) {
            
        //     $handle = fopen('php://output', 'w');

        //     fputcsv($handle, $csvHeader);

        //     foreach ($csvData as $row) {
        //         fputcsv($handle, $row);
        //     }

        //     fclose($handle);

        // }, 200, [
        //     'Content-Type' => 'text/csv',
        //     'Content-Disposition' => 'attachment; filename="売上一覧.csv"',
        // ]);

        // return $response;

    }

}
