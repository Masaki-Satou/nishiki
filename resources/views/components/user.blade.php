@props([
    'noIndex'=>'',
    'tapUrl'=>'',
    'ogType'=>'',
    'title'=>'',
    'description'=>'',
    'css'=>'',
    'script'=>'',
    ])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{ $noIndex }}

        <!-- iPhoneでは、電話番号らしき文字列があると自動検出してリンクになってしまう？リンクにしたい場合は、href="tel:"で対応。 -->
        <!-- <meta name="format-detection" content="telephone=no" /> -->

        <!-- ブラウザのタブに表示される画像 -->
        <link rel="icon" type="image/png" href="{{ asset('images/icon.webp') }}" />
        
        <!-- ウェブクリップアイコンはスマホのホーム画面に登録した際などに表示されます。正方形で150pxくらいで用意しましょう。背景を透明にすると、iPhoneでは背景が黒になってしまうので注意 -->
        <!-- <link rel="apple-touch-icon" href="{{ asset('images/icon.webp') }}" /> -->

        <!-- favicon/webclipicon -->
        <!-- <meta property="og:site_name" content="{{ config('app.name', '京都錦市場') }}" /> -->
        <!-- クリック（タップ）された時のアドレス -->
        <!-- <meta property="og:url" content="{{ $tapUrl }}" /> -->
        <!-- トップページであればwebsite、それ以外はarticleにします。 -->
        <!-- <meta property="og:type" content="{{ $ogType }}" /> -->
        
        <!-- <meta property="og:title" content="{{ $title }}" /> -->
        <!-- <meta property="og:description" content="{{ $description }}" /> -->
        <!-- シェアされた時に表示したい画像を設定します。絶対パスで記入します。1200px × 630pxの画像画像の中の主要なコンテンツは正方形内に納める -->
        <!-- <meta property="og:image" content="{{ asset('/images/icon.webp') }}" /> -->
        <!-- <meta property="og:locale" content="ja_JP" /> -->

        <!-- 運営サイトのアカウントがある場合設定 -->
        <!-- <meta name="twitter:site" content="@moshamusha2010" /> -->

        <!-- <meta name="twitter:card" content="summary" /> -->
        
        <!-- <meta name="twitter:description" content="{{ $description }}" /> -->
        <!-- <meta name="twitter:image:src" content="{{ asset('/images/icon.webp') }}" /> -->



        <meta name="description" content="{{ $description }}" />
        <title>{{ $title }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Zen+Antique&display=swap" rel="stylesheet">



        <link rel="stylesheet" href="{{ asset('css/app.css') }}?3">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}?9">
        {{ $css }}
        
        <style>
            body{
                font-family: 'Zen Antique', serif;
                overflow: hidden;
                background-color: white;
                background-image: url('../../images/back.webp');
                /* background-image: url('../../images/awaji.png'); */
                background-size: cover;
                height:100vh;
                height:100dvh;
            }
        </style>


        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- <script src="{{ asset('js/libs/scroll.js') }}" defer></script> -->
        <!-- <script src="{{ asset('js/libs/mobile-menu.js') }}" defer></script> -->
        <script src="{{ asset('js/main.js') }}" defer></script>
        {{ $script }}
    
    </head>

    <body class="">

        
        <div class="global-container min-h-screen">
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

        </div>
    </body>
</html>
