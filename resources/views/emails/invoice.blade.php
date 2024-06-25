
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

<p class="mb-4">下記のご注文の商品の発送手配を致しましたので、お知らせ致します。</p>

<p class="mb-4">決済方法：{{ $payment }}</p>
<p class="mt-4">お届け希望時間：{{ $earning->timezone->name }}</p>

<p class="mt-4">お届け先住所：{{ $earning->destination->prefecture->name . $earning->destination->address }}</p>

<p class="text-blue-500">送り状番号、その他お知らせ：{{ $earning->invoice }}</p>


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

<p class="mt-4">商品の到着までもう少々お待ち下さい。又のご注文、心よりお待ちしております。</p>

<p class="pt-20">※注意事項
    <br>●代引きを選択されている場合
    <br>合計金額に、ヤマト運輸（コレクト）便/代引手数料 300円がかかりますので、ご了承下さい。
</p>