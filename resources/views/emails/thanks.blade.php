
@php
    $total_price=0;
    $payment="";
    if($earning->payment_method==1){
        $payment="クレジットカード";
    }else if($earning->payment_method==2){
        $payment="銀行振り込み";
    }else if($earning->payment_method==3){
        $payment="代引き";
    }
@endphp

<p class="mb-4">{{ $user->name }} 様</p>

<p class="mb-4">下記のご注文をうけ賜わりましたので、お知らせ致します。</p>

<p class="mb-4">決済方法：{{ $payment }}</p>
<p class="mt-4">お届け希望日：{{ $earning->deli_date }}</p>
<p class="mt-4">お届け希望時間：{{ $earning->timezone->name }}</p>

<p class="mt-4">お届け先住所：{{ $earning->destination->prefecture->name . $earning->destination->address }}</p>

@foreach($earning->details as $detail)
<ul class="list-none p-0 mb-4">
    
    @if($detail->product_id)
    <li>商品名：{{ $detail->product->name }}</li>
    @else
    <li>商品名：送料</li>
    @endif
    <li>商品単価：{{ number_format($detail->price) }}</li>
    <li>数量：{{ $detail->quantity }}</li>
    <li>小計：{{ number_format($detail->price * $detail->quantity) }}</li>
    @php
        $total_price+=$detail->price * $detail->quantity
    @endphp
</ul>

@endforeach
<p class="mt-4">合計：{{ number_format($total_price) }}</p>

<p class="mt-4">発送の準備を行いますので、少々お待ち下さい。この度はご注文、誠にありがとうございました。</p>

<p class="pt-20">※注意事項
    <br>●銀行振込を選択された場合
    <br>銀行振り込みは前払いとなり、ご入金確認後、手配致します。
    <br>振込先：
    <br>三井住友銀行　三田支店（サンダ）　店番391
    <br>普通　9102605
    <br>株式会社ロペ商事（ロペショウジ）
    <br>※お振込み手数料はお客様負担にてお願い致します。
    <br>なお、7日以内に入金確認が出来ない場合はキャンセルとさせていただきますのでご了承下さい。
    <br>
    <br>●代引きを選択された場合
    <br>合計金額に、ヤマト運輸（コレクト）便/代引手数料 300円がかかりますので、ご了承下さい。
</p>

