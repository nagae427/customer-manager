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
                    <button type="submit"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13.25a.75.75 0 00-1.5 0v4.5a.75.75 0 00.75.75h4.5a.75.75 0 000-1.5h-3.75V4.75z" clip-rule="evenodd" />
                            </svg>
                        </span>
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