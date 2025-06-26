<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- font-awesomeから取ってくるために --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>@yield('title', 'タイトルが指定されていません')</title>
</head>
<body>
    <!-- ヘッダー上部分-->
    <div class="hidden md:flex justify-between items-center space-x- bg-gray-100 shadow-md">
        <div class="flex justify-start space-x-6 p-5 text-gray-900">
            <a href="{{ route('dashboard') }}" class="items-center text-2xl font-bold" title="ダッシュボードへ"><i class="fa-solid fa-clipboard"></i>顧客管理システム</a>
            @if (Auth::check())
            <div class="flex justify-start items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="group relative inline-block no-underline overflow-hidden">
                    ダッシュボード
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 origin-bottom-left transition-transform duration-400 ease-out group-hover:scale-x-100"></span>
                </a>
                <a href="{{ route('customers.index') }}" class="group relative inline-block no-underline overflow-hidden">
                    顧客一覧
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 origin-bottom-left transition-transform duration-400 ease-out group-hover:scale-x-100"></span>
                </a>
                <a href="{{ route('users.index') }}" class="group relative inline-block no-underline overflow-hidden">
                    営業担当者一覧
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 origin-bottom-left transition-transform duration-400 ease-out group-hover:scale-x-100"></span>
                </a>
            </div>
            @endif
        </div>
        <div class="flex items-center space-x-5 mr-5">
            <div>
                @if(Auth::check()) 
                    @if(Auth::user()->isAdmin())
                    <p class="text-green-500 text-1xl hover:text-green-700">{{ Auth::user()->name }}
                    </p>
                    @elseif(Auth::user()->isSales())
                    <p class="text-blue-500">{{ Auth::user()->name }}
                    </p>
                    @endif
                @else
                <p>ログインしていません</p>
                @endif
            </div>
            <div class="logout">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="header-logout-btn">
                        <i class="fas fa-sign-out-alt"></i> ログアウト
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="flex justify-between items-center space-x- bg-gray-100 shadow-md md:hidden">
        <div></div>
        <div class="flex justify-start space-x-6 p-5 text-gray-900">
            <a href="{{ route('dashboard') }}" class="items-center text-2xl font-bold" title="ダッシュボードへ"><i class="fa-solid fa-clipboard"></i>顧客管理システム</a>
        </div>
        <!-- ハンバーガーメニュー -->
        <button id="hamburger-menu" class="text-gray-900 focus:outline-none">
            <i class="fas fa-bars text-2xl"></i>
        </button>             
        <div class="flex items-center space-x-5 mr-5">

        </div>
    </div>
    
    {{-- ヘッダー下部分 --}}
    <div class="text-center bg-gray-200 p-5">
        @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <span class="font-medium">{{ session('success')}}</span>
        </div>
        @endif
        @if (session('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <span class="font-medium">{{ session('error') }}</span>
        </div>
        @endif
    </div>
    
    {{-- メインコンテンツ --}}
    <main>
        @yield('content')
    </main>

    {{-- jsを読み込むのに必要 --}}
    @stack('scripts')
</body>
</html>