@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/show.css') }}">
@endsection

@section('title', '顧客情報詳細')

@section('header-title')
<a href="{{ route(('customers.index')) }}" title="戻る">
    <i class="fas fa-arrow-left"></i>
</a>
<span>顧客情報詳細</span>
@endsection

@section('header_actions')
<div>
    <a href="{{ route('customers.edit', ['customer' => $customer->id]) }}" title="顧客情報編集" class="btn btn-info"><i class="fas fa-edit"></i>編集</a>
</div>
<div>
    <form action="{{ route('customers.destroy', $customer->id) }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('本当に削除しますか？')" title="顧客情報削除" class="btn btn-danger"><i class="fas fa-trash-alt"></i>削除</button>
    </form>
</div>
@endsection

@section('content')
<div class="show-container">
    {{-- 左のカード(顧客名、担当者、郵便番号、住所) --}}
    <div class="card left">
        <div class="customer-information">
            <div class="customer-name"><p>{{ $customer->customer_name }}</p></div>
            <div class="kana customer-name-kana"><p>{{ $customer->customer_name_kana }}</p></div>
        </div>
        <div class="information">
            <div class=basic-information>
                <div class="heading"><p>基本情報</p></div>
                <div class="postal-code"><p>{{ $customer->postal_code }}</p></div>
                <div class="address"><p>{{ $customer->address }}</p></div>
            </div>
            <div class="contact-information">
                <div class="heading"><p>担当者情報</p></div>
                <div class="contact-person-name"><p>{{ $customer->contact_person_name }}</p></div>
                <div class="kana contact-person-name-kana"><p>{{ $customer->contact_person_name_kana }}</p></div>
                <div class="contact-person-tel"><p>{{ $customer->contact_person_tel }}</p></div>
            </div>
        </div>
    </div>

    {{-- 右のカード --}}
    <div class="right">
        {{-- 営業担当者、ランク --}}
        <div class="card up">
            <div class="sales">
                <div class="heading"><p>営業担当者</p></div>
                <div class="user_name"><p>{{ $customer->user->user_name }}</p></div>
                <div class="authority"><p>{{ $customer->user->authority }}</p></div>
            </div>
        </div>
        {{-- 更新情報、最終更新 --}}
        <div class="card down">
            <div class="update">
                <div class="heading"><p>更新情報</p></div>
                <div><p>最終更新: {{ $customer->updated_at->format('Y/m/d H:i') }}</p></div>
            </div>
        </div>
    </div>
</div>
@endsection