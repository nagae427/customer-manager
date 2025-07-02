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
                <button class="open-modal-btn bg-blue-500 text-white font-bold py-2 px-4 rounded-t hover:bg-blue-600" data-url="{{ route('users.edit') }}" data-title="新規営業担当者登録">新規登録</button>
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
                    {{-- ここを修正 --}}
                    <tr class="user-row open-modal-btn hover:bg-gray-50 cursor-pointer" data-url="{{ route('users.show', $user) }}" data-user-id="{{ $user->id }}" data-user-role="{{ $user->is_admin }}"  data-title="{{ $user->name}} さんの情報">
                        <td class="px-4 py-2 border-b border-gray-200 whitespace-nowrap 
                        @if(Auth::user()->id === $user->id) 
                            text-blue-800"
                        @endif>
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
                        <td class="actions no-open-modal px-4 py-2 border-b border-gray-200 whitespace-nowrap">
                            <button class="open-modal-btn text-blue-600 hover:text-blue-800 mr-2" data-url="{{ route('users.show', $user) }}" data-user-id="{{ $user->id }}" data-title="{{ $user->name}} さんの情報" title="{{ $user->name}} さんの情報"><i class="fas fa-eye"></i></button>
                            @if(Auth::check() && Auth::user()->isAdmin())
                                {{-- 編集ボタンをモーダル表示用に変更 --}}
                                <button class="open-modal-btn text-green-600 hover:text-green-800 mr-2" data-url="{{ route('users.edit', $user) }}" data-title="営業担当者情報編集" title="営業担当者情報編集"><i class="fas fa-edit"></i></button>
                                {{-- 削除ボタンを追加 --}}
                                @if(Auth::user()->id !== $user->id)
                                <button class="open-modal-btn text-red-600 hover:text-red-800" data-url="{{ route('users.confirm', $user) }}" data-title="{{ $user->name}} さんの情報削除確認" title="情報削除確認"><i class="fas fa-trash"></i></button>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="commonModal" class="fixed inset-0 bg-gray-600/70 hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out" data-modal-id="commonModal">
    <div class="relative m-auto bg-white rounded-lg shadow-xl p-6 w-11/12 md:w-1/2 lg:w-1/3 max-w-lg transition-transform duration-300 ease-out transform scale-95 opacity-0">
        <div class="flex justify-between text-center border-b pb-3 mb-4">
            <h3 class="text-xl font-semibold" id="commonModalTitle"></h3>
            <button id="closeButton" class="text-gray-500 hover:text-gray-700 text-2xl focus:outline-none close-modal" data-modal-id="commonModal">&times;</button>
        </div>
        <div id="commonModalBody">
            {{-- ここにhtml --}}
        </div>
    </div>
</div>

@endsection