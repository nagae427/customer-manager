@extends('layouts.app')

@section('title', '顧客情報登録') 

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/create.css') }}">
@endsection

@section('header-title')
<a href="{{ route(('customers.index')) }}" title="戻る">
    <i class="fas fa-arrow-left"></i>
</a>
<span>顧客情報登録</span>
@endsection

@section('content')
<div class="card create-edit-container">
    <form action="{{ route('customers.store_confirm') }}" method="POST">
        @csrf
        <div class="form-items">
            <div class="form-item">
                <label for="customer_name">顧客名<span>*</span></label><br>
                <input type="text" id="customer_name" name="customer_name" maxlength="50" required placeholder="例: 株式会社ABC" value="{{ old('customer_name') }}">
            </div>
            <div class="form-item">
                <label for="customer_name_kana">顧客名(かな)<span>*</span></label><br>
                <input type="text" id="customer_name_kana" name="customer_name_kana" maxlength="100" required placeholder="例: かぶしきがいしゃえーびーしー" value="{{ old('customer_name_kana') }}">
            </div>
        </div>

        <div class="form-items">
            <div class="form-item">
                <label for="postal_code">郵便番号</label><br>
                <input type="text" id="postal_code" name="postal_code" maxlength="8" placeholder="例: 123-4567" value="{{ old('postal_code') }}">
            </div>

            <div class="form-item">
                <label for="area_id">地区情報<span>*</span></label><br>
                <select id="area_id" name="area_id" required>
                    <option value="">選択してください</option>
                    @foreach($areas as $area)
                    <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                        {{ $area->area_name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-item">
            <label for="address">住所</label><br>
            <input type="text" id="address" name="address" maxlength="255" placeholder="例: 東京都千代田区千代田1-1-1" value="{{ old('address') }}">
        </div>

        <div class="form-items">
            <div class="form-item">
                <label for="contact_person_name">担当者名<span>*</span></label><br>
                <input type="text" id="contact_person_name" name="contact_person_name" maxlength="30" required placeholder="例: 山田 太郎" value="{{ old('contact_person_name') }}">
            </div>
            
            <div class="form-item">
                <label for="contact_person_name_kana">担当者名(かな)<span>*</span></label><br>
                <input type="text" id="contact_person_name_kana" name="contact_person_name_kana" maxlength="50" placeholder="例: やまだ たろう" value="{{ old('contact_person_name_kana') }}">
            </div>
        </div>

        <div class="form-items">
            <div class="form-item">
                <label for="contact_person_tel">担当者電話番号<span>*</span></label><br>
                <input type="text" id="contact_person_tel" name="contact_person_tel" maxlength="20" placeholder="例: 090-1234-5678" required value="{{ old('contact_person_tel') }}"> 
            </div>

            <div class="form-item">
                <label for="user_id">営業担当者名<span>*</span></label><br>
                <select id="user_id" name="user_id" required>
                    <option value="">選択してください</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $area->id ? 'selected' : '' }}>
                            {{ $user->user_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-items">
            <div class="form-item"></div>
            <div class="form-item form-actions">
                <a href="{{ route('customers.index') }}" class="btn btn-back" title="キャンセル">キャンセル</a>
                <button type="submit" class="btn btn-info" title="確認画面へ">確認画面へ</button>
            </div>

        </div>
    </form>
</div>
@endsection