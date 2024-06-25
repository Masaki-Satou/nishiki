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
            <img src="{{ asset('../images/nishiki.webp') }}" alt="">
        </div>
        
        @if($toast)
        <p class="toast">Thank you</p>
        @endif

        
    </div>

</div>
    
</x-user>
