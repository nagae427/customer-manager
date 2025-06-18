@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('title', 'ログイン')

@section('content')
    <div class="card login-container">
        <h2>ログイン</h2>
        <p>アカウント情報を入力してください</p>
        <form action="{{ route('login_post') }}" method="post">
            @csrf
            @error('error')
            <div class="text-danger" style="color: red;">{{ $message }}</div>
            @enderror
            <div class="user-id">
                <label for="user_id">ユーザID</label>
                <input type="text" name="user_id" value="{{ old('user_id') }}" placeholder="ユーザIDを入力">
                @error('user_id')
                    <div class="text-danger" style="color: red;">{{ $message }}</div>
                @enderror
            </div>
            <div class="password">
                <label for="password">パスワード</label>
                <input type="password" name="password" placeholder="パスワードを入力">
                @error('password')
                {{-- ここで 'password' の必須エラーメッセージが表示されます --}}
                <div class="text-danger" style="color: red;">{{ $message }}</div>
                @enderror

            </div>
            <button type="submit" class="btn btn-info">ログイン</button>
        </form>
    </div>
@endsection