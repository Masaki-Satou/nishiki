<x-user 
    title="" 
    description="" 
    ogType="website" 
    tapUrl="">

    <x-slot name="noIndex">
        <meta name="robots" content="noindex,nofollow">
    </xslot>

    <x-slot name="css">
        
    </xslot>

    <x-slot name="script">
    </x-slot>
    
    <div class="onecup">

        <div class="onecup__inner pt-11">
            
            <div class="main">
                
                <x-auth-validation-errors></x-auth-validation-errors>
              
                
                <form class="onecut-form" method="POST" action="{{ route('user.onecupEntry') }}">
                @csrf
                    <div>
                        <x-label for="name" value="実施者（複数名で行っている場合は1時間前後関わった場合はサブの氏名も記載）" />
                        <x-input placeholder="例：庄司、佐藤、田中" id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                    </div>
        
                    <div class="mt-4">
                        <x-label for="quantity" value="杯数" />
                        <x-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" :value="old('quantity')" required />
                    </div>

                    <div class="flex items-center justify-center mt-4">
                        <x-button class="submitbutton ml-4">
                            送信
                        </x-button>

                        
                    </div>

                    @isset($message)
                    <p class="pb-4 text-center text-lg text-red-500">{{ $message }}</p>
                    @endisset

                </form>
            </div>

            <div class="record mt-5 mb-5">
                
                <table>
                    @foreach($onecups as $onecup)
                    
                    
                    <tr class=@if($onecup->created_at->format('d') % 2 == 0) "yes" @endif>
                        <td>{{ $onecup->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $onecup->name }}</td>
                        <td>{{ $onecup->quantity }}</td>
                    </tr>
                    @endforeach
                </table>
                    
            </div>


        </div>

    </div>

</div>

</x-user>




<script>

    //2重送信の防止策
    btnEl=document.querySelector('.submitbutton');
    form=document.querySelector('.onecut-form');
    btnEl.addEventListener('click',function(e){
        
        //clickイベントはフォームのネイティブな検証をスキップしてしてしまうので、実装
        if (form.checkValidity()) {
            btnEl.disabled = true;
            form.submit();
        } else {
            // 無効な場合、ブラウザにエラーメッセージを表示させる
            form.reportValidity();
        }

     });

</script>