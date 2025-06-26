@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/users/show.css') }}">
        <link rel="stylesheet" href="{{ asset('css/partials/confirm_modal.css') }}">
@endsection

@section('title', '営業担当者情報詳細')

@section('header-title')
<a href="{{ $previousUrl }}" title="戻る">
    <i class="fas fa-arrow-left"></i>
</a>
<span>営業情報詳細</span>
@endsection

@section('header_actions')
<div>
    @if(Auth::check() && Auth::user()->authority === 'admin')
    <a href="{{ route('users.edit', ['user' => $user->id]) }}" title="営業情報編集" class="btn btn-info"><i class="fas fa-edit"></i>編集</a>
    @endif
</div>
<div>
    @if(Auth::check() && Auth::user()->authority === 'admin' && Auth::user()->id !== $user->id && $user->customers->count() == 0)
    <button type="button"  
    class="btn btn-danger btn-sm js-open-modal"
    data-modal-target="#deleteConfirmationModal" {{--ターゲットとなるモーダルのID。一番外側のdiv--}}
    data-user-id="{{ $user->id }}" 
    data-user-name="{{ $user->user_name}}">
        <i class="fas fa-trash-alt"></i>削除
    </button>
    @endif
</div>

{{-- モーダルウィンドウをインクルード  --}}
@include('partials/user_confirm_modal')

@endsection

@section('content')
<div class="show-container">
    {{-- 左のカード(営業担当者名、かな) --}}
    <div class="card left">
        <div class="user-information">
            <div class="user-name">
                <p>{{ $user->user_name }}@if($user->authority == "admin")
                    <span class="admin">(管理者)</span>
                    @elseif($user->authority == "sales")
                    <span class="sales">(営業担当者)</span>
                    @endif
                </p>
            </div>
            <div class="kana user-name-kana"><p>{{ $user->user_name_kana }}</p></div>
        </div>
        <div class="user-customer-container">
            <h2>担当顧客</h2>
            {{-- 担当顧客一覧テーブル --}}
            @if($user->customers->isNotEmpty())
                @foreach($user->customers as $customer)
                <div class="js-clickable-row user-customer-content" data-href="{{route('customers.show', ['customer' => $customer->id]) }}">
                    <div class="name">
                        <h2>{{ $customer->customer_name }}</h2>
                        <p>{{ $customer->contact_person_name }}</p>
                    </div>
                    <div class="actions js-no-link text-center">
                        {{-- 詳細表示ボタン --}}
                        <a href="{{ route('customers.show', ['customer' => $customer->id]) }}" title="顧客情報詳細"> {{-- Bootstrapのボタンクラスを追加 --}}
                            <i class="fas fa-eye"></i>
                        </a>

                        {{-- 編集ボタン (管理者権限がある場合のみ表示) --}}
                        @if(Auth::check() && Auth::user()->authority === 'admin')
                        <a href="{{ route('customers.edit', ['customer' => $customer->id]) }}" title="顧客情報編集"> {{-- Bootstrapのボタンクラスとマージンを追加 --}}
                            <i class="fas fa-edit"></i>
                        </a>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
                <p>この営業担当者に紐付けられた顧客はいません。</p>
            @endif
        </div>
    </div>

    {{-- 右のカード --}}
    <div class="right">
        {{-- 更新情報、最終更新 --}}
        <div class="card down">
            <div class="update">
                <div class="heading"><p>更新情報</p></div>
                <div><p>最終更新: {{ $user->updated_at->format('Y/m/d H:i') }}</p></div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- jsを読み込む --}}
@push('scripts')
    <script src="{{ asset('js/components/user_confirm_modal.js') }}"></script>
    <script src="{{ asset('js/pages/index.js') }}"></script>
    <script src="{{ asset('js/partials/header.js') }}"></script>
@endpush