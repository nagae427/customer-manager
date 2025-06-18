@extends('layouts.app')


@section('title', 'ダッシュボード')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/confirm_modal.css') }}">
@endsection

@section('header-title')
<div>ダッシュボード<br><span class="greet">こんにちは、<span style="font-size: 1.1rem;">{{ Auth::user()->user_name }}</span> さん</span></div>
@endsection 

@section('content')
<div class="card left">
    <div class="list-header">
        <div class="header-title">
            <span>最近の顧客({{ $three_days_ago->format('m/d') }}～ 今日まで)</span>
        </div>
        <div class="all-show">
            <a href="{{ route('customers.index') }}">すべて表示</a>
        </div>
    </div>
        @foreach($recentCustomers as $customer)
        <div class="customer js-clickable-row" data-href="{{route('customers.show', ['customer' => $customer->id]) }}">
            <div class="customer-title">
                <span class="customer-name">{{ $customer->customer_name }}</span> <br> <span class="thin">{{ $customer->contact_person_name }}</span>
            </div>
            <div class="actions js-no-link">
                <a href="{{ route('customers.show', ['customer' => $customer->id]) }}" title="顧客情報詳細"><i class="fas fa-eye"></i></a>
                @if(Auth::check() && Auth::user()->authority === 'admin')
                <a href="{{ route('customers.edit', ['customer' => $customer->id]) }}" title="顧客情報編集"><i class="fas fa-edit"></i></a>
                @endif
                @if(Auth::check() && Auth::user()->authority === 'admin')
                <button type="button"  
                class="btn-sm js-open-modal"
                data-modal-target="#deleteConfirmationModal" {{--ターゲットとなるモーダルのID。一番外側のdiv--}}
                data-url_name="dashboard"
                data-customer-id="{{ $customer->id }}" 
                data-customer-name="{{ $customer->customer_name}}">
                    <i class="fas fa-trash-alt"></i>
                </button>
                @endif
            </div>   
        </div> 
        @endforeach
</div>

<div class="right">
    <div class="card count">
        <h2>総顧客数: <span style="color: #007bff;">{{ $count_customers }}人</span></h2>
    </div>
    <div class="card count count-sales">
        <h2>営業担当者数: <span style="color: #08ff83;">{{ $count_sales }}人</span></h2>
    </div>

    <div class="card quick-actions">
        <div class="quick-title"><span>クイックアクション</span></div>
        <div class="quick-action">
            <a href="{{ route('customers.index') }}">顧客一覧</a>
        </div>
        <div class="quick-action">
            <a href="{{ route('users.index') }}">営業担当者一覧</a>
        </div>
    </div>
</div>

{{-- モーダルウィンドウをインクルード  --}}
@include('partials/confirm_modal')

@endsection

{{-- jsを読み込む --}}
@push('scripts')
    <script src="{{ asset('js/components/confirm_modal.js') }}"></script>
    <script src="{{ asset('js/pages/index.js') }}"></script>
    <script src="{{ asset('js/partials/header.js') }}"></script>
@endpush