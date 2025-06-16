@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/dashboard.css') }}">
@endsection

@section('title', 'ダッシュボード')

@section('content')
<h1>ログイン成功です</h1>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">ログアウト</button>
</form>
@endsection