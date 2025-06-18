@extends('layouts.app')

@section('title', '営業情報登録確認')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/users/create.css') }}">
@endsection

@section('header-title')
<span>営業担当者情報編集確認</span>
@endsection

@section('content')
<div class="card create-edit-container">
    <div class="form-items">
        <div class="form-item">
            <p class="label-value">営業担当者名</p>
            <p class="value">{{ $validated['user_name'] }}</p>
        </div>
        <div class="form-item">
            <p class="label-value">営業担当者名(かな)</p>
            <p class="value">{{ $validated['user_name_kana'] }}</p>
        </div>
    </div>

    <div class="form-item">
        <p class="label-value">権限</p>
        <p class="value">{{ $selectedAuthority }}</p>
    </div>

    {{-- 送信 --}}
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-items">
            <div class="form-item"></div>
            <div class="form-item form-actions">
                <button type="button" class="btn btn-back" onclick="history.back()"><i class="fas fa-arrow-left"></i> 修正する</button>
                <button type="submit" class="btn btn-info" title="更新する">更新する</button>
            </div>
        </div>
    </form>
</div>
@endsection