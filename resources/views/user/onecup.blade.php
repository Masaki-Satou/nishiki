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
        
        



        <div class="onecup__inner pt-5">
            
            <div class="update">
                <a href="/onecup">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M13.836 2.477a.75.75 0 0 1 .75.75v3.182a.75.75 0 0 1-.75.75h-3.182a.75.75 0 0 1 0-1.5h1.37l-.84-.841a4.5 4.5 0 0 0-7.08.932.75.75 0 0 1-1.3-.75 6 6 0 0 1 9.44-1.242l.842.84V3.227a.75.75 0 0 1 .75-.75Zm-.911 7.5A.75.75 0 0 1 13.199 11a6 6 0 0 1-9.44 1.241l-.84-.84v1.371a.75.75 0 0 1-1.5 0V9.591a.75.75 0 0 1 .75-.75H5.35a.75.75 0 0 1 0 1.5H3.98l.841.841a4.5 4.5 0 0 0 7.08-.932.75.75 0 0 1 1.025-.273Z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <div class="main">
                
                <x-auth-validation-errors></x-auth-validation-errors>
              
                
                <form class="onecut-form" method="POST" action="{{ route('user.onecupEntry') }}">
                @csrf
                    <div>
                        <x-label for="name" value="実施者（複数名で行っている場合は1時間前後関わった場合はサブの氏名も記載）" />
                        <x-input placeholder="例：庄司、田中、廣川" id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
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

                    <x-flash-message />

                </form>
            </div>

            <p class="w-full pl-2 pt-2 text-sm">送信履歴</p>
            <div class="record mb-5">
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


    //  window.addEventListener('focus', () => {
    //     // 画面更新処理
    //     location.reload(); // ページ全体を再読み込み
    // });

</script>