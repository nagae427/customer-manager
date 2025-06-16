@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/login.css') }}">
@endsection

@section('title', 'ログイン')

@section('content')
    <div class="login-container">
        <h2>ログイン</h2>
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="user_id">
                <label for="user_id">ユーザID</label>
                <input type="text" name="user_id" value="{{ old('email') }}" required placeholder="ユーザIDを入力">
                @error('user_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="password">
                <label for="password">パスワード</label>
                <input type="password" name="password" placeholder="パスワードを入力">
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-login">ログイン</button>
        </form>
    </div>
@endsection