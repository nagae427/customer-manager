@extends('layouts.app')

@section('title', '営業担当者情報登録') 

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/users/create.css') }}">
@endsection

@section('header-title')
<a href="{{ $previousUrl }}" title="戻る">
    <i class="fas fa-arrow-left"></i>
</a>
<span>営業担当者情報編集</span>
@endsection

@section('content')
<div class="card create-edit-container">
    <form action="{{ route('users.update_confirm', $user) }}" method="POST">
        @csrf
        <div class="form-items">
            <div class="form-item">
                <label for="user_name">営業担当者名<span>*</span></label><br>
                <input type="text" id="user_name" name="user_name" maxlength="50" required placeholder="例: 株式会社ABC" value="{{ old('user_name', $user->user_name) }}">
            </div>
            <div class="form-item">
                <label for="user_name_kana">営業担当者名(かな)<span>*</span></label><br>
                <input type="text" id="user_name_kana" name="user_name_kana" maxlength="100" required placeholder="例: かぶしきがいしゃえーびーしー" value="{{ old('user_name_kana', $user->user_name_kana) }}">
            </div>
        </div>

        @if(Auth::user()->id !== $user->id)
        <div class="form-items"> 
            <div class="form-item authority"> 
                <label for="authority">権限<span>*</span></label><br>
                <select id="authority" name="authority" required>
                    <option value="">選択してください</option>
                    <option value="admin" {{ old('authority', $user->authority) == 'admin' ? 'selected' : '' }}>管理者</option>
                    <option value="sales" {{ old('authority', $user->authority) == 'sales' ? 'selected' : '' }}>営業担当者</option>
                </select>
                @error('authority') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-item"></div>
        </div>
        @endif


        <div class="form-items">
            <div class="form-item"></div>
            <div class="form-item form-actions">
                <a href="{{ $previousUrl }}" class="btn btn-back" title="キャンセル">キャンセル</a>
                <button type="submit" class="btn btn-info" title="確認画面へ">確認画面へ</button>
            </div>
        </div>
    </form>
</div>
@endsection