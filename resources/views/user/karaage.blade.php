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
       
    <div id="container">
        <div class="inner">
            <div class="img__wrapper">
                <img src="{{ asset('../images/karaage.png') }}" alt="">
            </div>
            <p>Plus 1piece!!</p>
            <a class="" href="{{ route('user.use') }}">TAP <br> TO USE UP</a>  
        </div>
    </div>

</div>
    
</x-user>
