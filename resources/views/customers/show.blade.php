@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/customers/show.css') }}">
        <link rel="stylesheet" href="{{ asset('css/partials/confirm_modal.css') }}">
@endsection

@section('title', '顧客情報詳細')

@section('header-title')
<a href="{{ url()->previous() }}" title="戻る">
    <i class="fas fa-arrow-left"></i>
</a>
<span>顧客情報詳細</span>
@endsection

@section('header_actions')
<div>
    @if(Auth::check() && Auth::user()->isAdmin())
    <a href="{{ route('customers.form', ['customer' => $customer->id]) }}" title="顧客情報編集" class="btn btn-info"><i class="fas fa-edit"></i>編集</a>
    @endif
</div>
<div>
    @if(Auth::check() && Auth::user()->isAdmin())
    <button type="button"  
    class="btn btn-danger btn-sm js-open-modal"
    data-modal-target="#deleteConfirmationModal" {{--ターゲットとなるモーダルのID。一番外側のdiv--}}
    data-customer-id="{{ $customer->id }}" 
    data-customer-name="{{ $customer->name }}">
        <i class="fas fa-trash-alt"></i>削除
    </button>
    @endif
</div>

{{-- モーダルウィンドウをインクルード  --}}
@include('partials/confirm_modal')

@endsection

@section('content')
<div class="show-container">
    {{-- 左のカード(顧客名、担当者、郵便番号、住所) --}}
    <div class="card left">
        <div class="name-information">
            <div class="customer-name"><p>{{ $customer->name }}</p></div>
            <div class="kana customer-name-kana"><p>{{ $customer->name_kana }}</p></div>
        </div>
        <div class="information">
            <div class=basic-information>
                <div class="heading"><p>基本情報</p></div>
                @if($customer->postal_code)
                <div class="postal-code"><p>{{ $customer->postal_code }}</p></div>
                @else
                <div class="postal-code"><p>未登録</p></div>
                @endif
                @if($customer->address)
                <div class="address"><p>{{ $customer->address }}</p></div>
                @else
                <div class="address"><p>未登録</p></div>
                @endif
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
            <div class="sales-content">
                <div class="heading"><p>営業担当者</p></div>
                <div class="user_name"><a href="{{ route('users.show', ['user' => $customer->user->id]) }}">{{ $customer->user->name }}</a></div>
                @if(Auth::user()->isAdmin())
                <div><span class="admin">(管理者)</span></div>
                @elseif(Auth::user()->isSales())
                <div><span class="sales">(営業担当者)</span></div>
                @endif
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

{{-- jsを読み込む --}}
@push('scripts')
    <script src="{{ asset('js/components/confirm_modal.js') }}"></script>
    <script src="{{ asset('js/partials/header.js') }}"></script>
@endpush