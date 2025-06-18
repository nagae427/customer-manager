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
            <p class="value">{{ $validated['customer_name'] }}</p>
        </div>
        <div class="form-item">
            <p class="label-value">顧客名(かな)</p>
            <p class="value">{{ $validated['customer_name_kana'] }}</p>
        </div>
    </div>

    <div class="form-items">
        <div class="form-item">
            <p class="label-value">郵便番号</p>
            <p class="value">{{ $validated['postal_code'] ?? '未入力' }}</p>
        </div>

        <div class="form-item">
            <p class="label-value">地区情報</p>
            <p class="value">{{ $selectedArea->area_name ?? '未選択' }}</p>
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
            <p class="value">{{ $selectedUser->user_name }}</p>
        </div>
    </div>

    {{-- 送信 --}}
    <form action="{{ route('customers.update', $customer) }}" method="POST">
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