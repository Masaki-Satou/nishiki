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
                <img src="{{ asset('../images/potato.png') }}" alt="">
            </div>
            <p>1piece service!!</p>
            <a class="" href="{{ route('user.use') }}">TAP TO USE UP</a>  
        </div>
    </div>

</div>
    
</x-user>
