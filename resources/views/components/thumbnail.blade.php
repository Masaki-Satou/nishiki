
@if(empty($filename))
    <img {{ $attributes }} src="{{ asset('images/no-img.webp') }}">

@else
    <img {{ $attributes }} src="{{ asset($filepath.$filename) }}">
@endif