<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- iPhoneでは、電話番号らしき文字列があると自動検出してリンクになってしまう？リンクにしたい場合は、href="tel:"で対応。 -->
        <meta name="format-detection" content="telephone=no" />

        <!-- ブラウザのタブに表示される画像 -->
        <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}" />
        
        <!-- ウェブクリップアイコンはスマホのホーム画面に登録した際などに表示されます。正方形で150pxくらいで用意しましょう。背景を透明にすると、iPhoneでは背景が黒になってしまうので注意 -->
        <link rel="apple-touch-icon" href="{{ asset('images/icon.jpg') }}" />

        <!-- favicon/webclipicon -->
        <meta property="og:site_name" content="{{ config('app.name', '京丹波') }}" />
        <!-- クリック（タップ）された時のアドレス -->
        <meta property="og:url" content="https://kyoutanba.com" />
        <!-- トップページであればwebsite、それ以外はarticleにします。 -->
        <meta property="og:type" content="article" />
        
        <meta property="og:title" content="京丹波" />
        <meta property="og:description" content="管理者、オーナー登録、店舗管理、商品管理" />
        <!-- シェアされた時に表示したい画像を設定します。絶対パスで記入します。1200px × 630pxの画像画像の中の主要なコンテンツは正方形内に納める -->
        <meta property="og:image" content="{{ asset('/images/logo.webp') }}" />
        <meta property="og:locale" content="ja_JP" />

        <!-- 運営サイトのアカウントがある場合設定 -->
        <!-- <meta name="twitter:site" content="@moshamusha2010" /> -->
        
        <meta name="twitter:card" content="summary" />
        
        <meta name="twitter:description" content="店舗管理、商品管理" />
        <meta name="twitter:image:src" content="{{ asset('/images/logo.webp') }}" />



        <!-- インデックスさせない -->
        <meta name="robots" content="noindex,nofollow">
        <meta name="description" content="管理者、オーナー登録、店舗管理、商品管理" />
        <title>京丹波</title>

        <!-- Fonts -->
        <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> -->

        <!-- Scripts -->
        <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body>
        <!-- font-sans text-gray-900 antialiased -->
        <div class="">
            {{ $slot }}
        </div>
    </body>
</html>


