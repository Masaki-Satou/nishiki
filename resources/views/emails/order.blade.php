
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

<p class="mb-4">{{ $user->name }} 様　よりご注文が入りました。</p>

<p class="mb-4">メールアドレス：{{ $user->email }} </p>

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

<a class="mt-4" href="{{ route('owner.earnings.noinvoice' ) }}">クリックして確認する</p>


