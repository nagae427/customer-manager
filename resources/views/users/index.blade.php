@extends('layouts.app')

@section('title', '営業担当者一覧')

{{-- ここからコンテンツ --}}
@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-4"> 

    {{-- PC・タブレット向けのテーブル表示 (変更なし) --}}
    <div class="flex justify-between">
        <div class="ml-1 space-x-1">
            {{-- 切り替えボタン --}}
            <button id="salesBtn" class="tab active py-2 scale-110 px-4 rounded-t bg-green-500 text-white">営業担当者</button>
            <button id="adminBtn" class="tab py-2 px-4 rounded-t bg-red-500 opacity-50 text-white hover:bg-red-500 hover:opacity-100">管理者</button>
        </div>
        <div>
            @if(Auth::check() && Auth::user()->isAdmin())
                <button id="openEditModal" data-store-url="{{ route('users.store') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-t hover:bg-blue-600">新規登録</button>
            @endif
        </div>
    </div>
    <div class="hidden md:block overflow-x-auto rounded-lg shadow-md">
        <table class="min-w-full text-left text-sm text-gray-700 border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border-b border-gray-200">営業担当者名</th>
                    <th class="px-4 py-2 border-b border-gray-200">電話番号・メールアドレス</th>
                    <th class="px-4 py-2 border-b border-gray-200">顧客人数</th>
                    <th class="px-4 py-2 border-b border-gray-200">更新日時</th>
                    <th class="px-4 py-2 border-b border-gray-200">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    @php
                        $userData= json_encode([
                            "id" => $user->id,
                            "name" => $user->name,
                            "name_kana" => $user->name_kana,
                            "phone" => $user->phone,
                            "email" => $user->email,
                            "is_admin" => $user->is_admin,
                            "customers_count" => $user->customers->count(),
                            "updated_at" => $user->updated_at->format('Y/m/d H:i'),
                            // "show_url" => route('users.show', $user),
                            "store_url" => (Auth::check() && Auth::user()->isAdmin() ? route('users.store', $user) : null)
                        ]);
                    @endphp
                    {{-- ここを修正 --}}
                    <tr class="user-row hover:bg-gray-50 cursor-pointer" data-user="{{ $userData }}" data-user-id="{{ $user->id }}" data-user-role="{{ $user->is_admin }}">
                        <td class="px-4 py-2 border-b border-gray-200 whitespace-nowrap">
                            <span class="user-name font-medium">{{ $user->name }}</span> <br>
                            <span class="text-xs text-gray-500">{{ $user->name_kana }}</span>
                        </td>
                        <td class="px-4 py-2 border-b border-gray-200 whitespace-nowrap">
                            <span class="user-phone">{{ $user->phone }}</span> <br>
                            <span class="user-email">{{ $user->email }}</span>
                        </td>
                        <td class="px-4 py-2 border-b border-gray-200 whitespace-nowrap">{{ $user->customers->count() }} 人</td>
                        <td class="px-4 py-2 border-b border-gray-200 whitespace-nowrap">
                            <span class="text-xs text-gray-500">{{ $user->updated_at->format('Y/m/d H:i') }}</span>
                        </td>
                        <td class="actions js-no-modal-open px-4 py-2 border-b border-gray-200 whitespace-nowrap">
                            <button class="open-show-modal text-blue-600 hover:text-blue-800 mr-2" data-user-id="{{ $user->id }}" title="営業担当者情報詳細"><i class="fas fa-eye"></i></button>
                            @if(Auth::check() && Auth::user()->isAdmin())
                                {{-- 編集ボタンをモーダル表示用に変更 --}}
                                <button class="open-edit-modal text-green-600 hover:text-green-800 mr-2" data-user-id="{{ $user->id }}" title="営業担当者情報編集"><i class="fas fa-edit"></i></button>
                                {{-- 削除ボタンを追加 --}}
                                <button class="open-delete-modal text-red-600 hover:text-red-800" data-delete-url="{{ route('users.delete', ['user' => $user->id]) }}" data-user-name="{{ $user->name}}" title="営業担当者削除"><i class="fas fa-trash"></i></button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- モーダルを埋め込む --}}
@include('modals/edit_modal')
@include('modals/show_modal')
@include('modals/delete_modal')

@endsection