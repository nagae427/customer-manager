<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- font-awesomeから取ってくるために --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>@yield('title', 'タイトルが指定されていません')</title>
</head>
<body>
    <!-- ヘッダー上部分-->
    <div class="hidden md:flex p-2 justify-between items-center space-x-2 bg-gray-100 shadow-md">
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
                    営業担当者・管理者一覧
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 origin-bottom-left transition-transform duration-400 ease-out group-hover:scale-x-100"></span>
                </a>
            </div>
            @endif
        </div>
        <div class="message max-w-sm">
            @if (session('success'))
            <div class="text-sm text-green-800 rounded-lg bg-green-50 break-all" role="alert">
                <span class="font-medium">{{ session('success')}}</span>
            </div>
            @endif
            @if (session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 break-words" role="alert">
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            @endif
        </div>
        <div class="flex items-center space-x-5 mr-5">
            <div>
                @if(Auth::check()) 
                    @if(Auth::user()->isAdmin())
                    <button class="open-modal-btn text-green-500 text-1xl hover:text-green-700" data-url="{{ route('users.show', Auth::user()->id) }}" data-user-id="{{ $user->id }}" data-title="{{ $user->name}} さんの情報" title="{{ $user->name}} さんの情報">{{ Auth::user()->name }}
                    </button>
                    @elseif(Auth::user()->isSales())
                    <button class="open-modal-btn text-blue-500 text-1xl hover:text-blue-700" data-url="{{ route('users.show', Auth::user()->id) }}" data-user-id="{{ $user->id }}" data-title="{{ $user->name}} さんの情報" title="{{ $user->name}} さんの情報">{{ Auth::user()->name }}
                    </button>
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
    
    {{-- メインコンテンツ --}}
    <main>
        @yield('content')
    </main>
    {{-- @include('') --}}
</body>
</html>