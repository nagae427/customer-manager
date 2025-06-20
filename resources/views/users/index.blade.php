@extends('layouts.app')

@section('title', '営業担当者一覧')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/users/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials/user_confirm_modal.css') }}">
@endsection

@section('header-title')
<a href="{{ $previousUrl }}" title="戻る">
    <i class="fas fa-arrow-left"></i>
</a>
<span>営業担当者一覧</span>
@endsection

@section('header_actions')
    @if(Auth::check() && Auth::user()->authority === 'admin')
    <a href="{{ route('users.create') }}" title="新規営業担当者登録" class="btn btn-info">新規営業担当者登録</a>
    @endif
@endsection

{{-- ここからコンテンツ --}}
@section('content')
<div class="card user-list">
    {{-- 一覧テーブル --}}
    <table>
        <thead>
            <tr>
                <th>営業担当者名</th>
                <th>権限</th>
                <th>顧客人数</th>
                <th>更新日時</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="js-clickable-row" data-href="{{route('users.show', ['user' => $user->id]) }}">
                    <td><span class="user-name">{{ $user->user_name }}</span> <br> <span class="thin">{{ $user->user_name_kana }}</span></td>
                    <td>
                        @if($user->authority == "admin")
                        <span class="admin">管理者</span>
                        @elseif($user->authority == "sales")
                        <span class="sales">営業担当者</span>
                        @endif
                    </td> 
                    <td>{{ $user->customers->count() }} 人</td>
                    <td><span class="thin">{{ $user->updated_at->format('Y/m/d H:i') }}</span></td>
                    <td class="actions js-no-link">
                        <a href="{{ route('users.show', ['user' => $user->id]) }}" title="営業担当者情報詳細"><i class="fas fa-eye"></i></a>
                        @if(Auth::check() && Auth::user()->authority === 'admin')
                        <a href="{{ route('users.edit', ['user' => $user->id]) }}" title="営業担当者情報編集"><i class="fas fa-edit"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>
</div>

{{-- モーダルウィンドウをインクルード  --}}
@include('partials/user_confirm_modal')

@endsection

{{-- jsを読み込む --}}
@push('scripts')
    <script src="{{ asset('js/components/user_confirm_modal.js') }}"></script>
    <script src="{{ asset('js/pages/index.js') }}"></script>
    <script src="{{ asset('js/partials/header.js') }}"></script>
@endpush