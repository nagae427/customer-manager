@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    ログイン
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    アカウント情報を入力してください
                </p>
            </div>

            <form class="mt-8 space-y-6" action="{{ route('login_post') }}" method="post">
                @csrf

                {{-- エラーメッセージの表示（共通） --}}
                @error('error')
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <span class="block sm:inline">{{ $message }}</span>
                    </div>
                @enderror

                {{-- ユーザーID入力欄 --}}
                <div class="rounded-md-space-y-px">
                    <div>
                        <label for="user_id">ユーザID</label>
                        <input id="user_id" name="user_id" type="text" autocomplete="username"
                               class="shadow-sm appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                               value="{{ old('user_id') }}" placeholder="ユーザIDを入力" maxlength="10">
                    </div>
                    @error('user_id')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- パスワード入力欄 --}}
                <div>
                    <label for="password">パスワード</label>
                    <input id="password" name="password" type="password" autocomplete="current-password"
                           class="shadow-sm appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                           placeholder="パスワードを入力" maxlength="20">
                    @error('password')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ログインボタン --}}
                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        ログイン
                    </button>
                </div>
            </form>
            <div>
                <p>初期パスワード : password</p>
            </div>
        </div>
    </div>
@endsection