<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/button.css') }}">
    @yield('styles') 

    {{-- font-awesomeから取ってくるために --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>@yield('title', 'タイトルが指定されていません')</title>
</head>
<body>
    <header class="header-container">
        @include('partials.header')
    </header>
    <main>
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>