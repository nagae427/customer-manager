<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/button.css') }}">
    {{-- 各ファイルのCSSをここで読み込む --}}
    @yield('styles') 

    {{-- font-awesomeから取ってくるために --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>@yield('title', 'タイトルが指定されていません')</title>
</head>
<body>
    {{-- ヘッダー --}}
    <header class="header-container">
        @guest
        @include('partials.login-header')
        @endguest
        @auth
        @include('partials.header')
        @endauth
    </header>
    
    {{-- メインコンテンツ --}}
    <main>
        @yield('content')
    </main>

    {{-- jsを読み込むのに必要 --}}
    @stack('scripts')
</body>
</html>