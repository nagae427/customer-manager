@extends('layouts.app')

@section('title', '顧客情報登録確認')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/customers/create.css') }}">
@endsection

@section('header-title')
<span>顧客情報編集確認</span>
@endsection

@section('content')
<div class="card create-edit-container">
    <div class="form-items">
        <div class="form-item">
            <p class="label-value">顧客名</p>
            <p class="value">{{ $validated['name'] }}</p>
        </div>
        <div class="form-item">
            <p class="label-value">顧客名(かな)</p>
            <p class="value">{{ $validated['name_kana'] }}</p>
        </div>
    </div>

    <div class="form-items">
        <div class="form-item">
            <p class="label-value">郵便番号</p>
            <p class="value">{{ $validated['postal_code'] ?? '未入力' }}</p>
        </div>

        <div class="form-item">
            <p class="label-value">地区情報</p>
            <p class="value">{{ $selectedArea->name ?? '未選択' }}</p>
        </div>
    </div>

    <div class="form-item">
        <p class="label-value">住所</p>
        <p class="value">{{ $validated['address'] ?? '未入力' }}</p>
    </div>

    <div class="form-items">
        <div class="form-item">
            <p class="label-value">担当者名</p>
            <p class="value">{{ $validated['contact_person_name'] }}</p>
        </div>
        
        <div class="form-item">
            <p class="label-value">担当者名(かな)</p>
            <p class="value">{{ $validated['contact_person_name_kana'] }}</p>
        </div>
    </div>

    <div class="form-items">
        <div class="form-item">
            <p class="label-value">担当者電話番号</p>
            <p class="value">{{ $validated['contact_person_tel'] ?? '未入力' }}</p>
        </div>

        <div class="form-item">
            <p class="label-value">営業担当者名</p>
            <p class="value">{{ $selectedUser->name }}</p>
        </div>
    </div>

    {{-- 送信 --}}
    <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $validated['id'] ?? '' }}">
        <input type="hidden" name="name" value="{{ $validated['name'] }}">
        <input type="hidden" name="name_kana" value="{{ $validated['name_kana'] }}">
        <input type="hidden" name="postal_code" value="{{ $validated['postal_code'] ?? '' }}">
        <input type="hidden" name="area_id" value="{{ $validated['area_id'] ?? '' }}">
        <input type="hidden" name="address" value="{{ $validated['address'] ?? '' }}">
        <input type="hidden" name="contact_person_name" value="{{ $validated['contact_person_name'] }}">
        <input type="hidden" name="contact_person_name_kana" value="{{ $validated['contact_person_name_kana'] }}">
        <input type="hidden" name="contact_person_tel" value="{{ $validated['contact_person_tel'] }}">
        <input type="hidden" name="user_id" value="{{ $validated['user_id'] }}">
        <div class="form-items">
            <div class="form-item"></div>
            <div class="form-item form-actions">
                <button type="submit" class="btn btn-back" value="back" name="back"><i class="fas fa-arrow-left"></i> 修正する</button>
                <button type="submit" class="btn btn-info" title="保存する">保存する</button>
            </div>
        </div>
    </form>
</div>
@endsection