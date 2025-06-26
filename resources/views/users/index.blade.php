@extends('layouts.app')

@section('title', '営業担当者一覧')

@section('header-title')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
        <a href="{{ url()->previous() }}" title="戻る" class="mr-3 text-gray-500 hover:text-gray-700">
            <i class="fas fa-arrow-left"></i>
        </a>
        <span>営業担当者一覧</span>
    </h2>
@endsection

{{-- ここからコンテンツ --}}
@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-4"> {{-- コンテンツ全体の左右のパディング --}}

    {{-- PC・タブレット向けのテーブル表示 --}}
    <div class="hidden md:block overflow-x-auto rounded-lg shadow-md"> {{-- テーブル全体に丸みと影を追加 --}}
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
                    <tr class="js-clickable-row hover:bg-gray-50" data-href="{{route('users.show', $user) }}">
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
                        <td class="actions js-no-link px-4 py-2 border-b border-gray-200 whitespace-nowrap">
                            <a href="{{ route('users.show', $user) }}" title="営業担当者情報詳細" class="text-blue-600 hover:text-blue-800 mr-2"><i class="fas fa-eye"></i></a>
                            @if(Auth::check() && Auth::user()->isAdmin())
                            <a href="{{ route('users.edit', $user) }}" title="営業担当者情報編集" class="text-green-600 hover:text-green-800"><i class="fas fa-edit"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- スマホ向けのカード表示 --}}
    <div class="md:hidden"> {{-- mdブレークポイント未満で表示 --}}
        <div class="max-h-[calc(100vh-180px)] overflow-y-auto pr-2"> {{-- 最大高さを設定し、縦スクロールを有効にする --}}
            <div class="grid grid-cols-2 gap-4"> {{-- 2列グリッドでカードを配置 --}}
                @foreach($users as $user)
                    <a href="{{ route('users.show', $user) }}" class="block bg-white p-3 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 text-sm">
                        <div class="flex flex-col items-center mb-2">
                            <i class="fas fa-user-circle text-3xl text-gray-500 mb-1"></i>
                            <p class="font-bold text-base text-gray-900 text-center leading-tight">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 text-center">{{ $user->name_kana }}</p>
                        </div>
                        <div class="border-t border-gray-200 pt-2 mt-2 text-gray-700">
                            <p><i class="fas fa-phone-alt text-gray-400 w-4 mr-1"></i> {{ $user->phone }}</p>
                            <p class="truncate"><i class="fas fa-envelope text-gray-400 w-4 mr-1"></i> {{ $user->email }}</p>
                            <p><i class="fas fa-users text-gray-400 w-4 mr-1"></i> {{ $user->customers->count() }} 人</p>
                            <p class="text-xs text-gray-400 mt-1"><i class="fas fa-clock text-gray-400 w-4 mr-1"></i> {{ $user->updated_at->format('Y/m/d H:i') }}</p>
                        </div>
                        @if(Auth::check() && Auth::user()->isAdmin())
                        <div class="mt-3 text-right">
                            <a href="{{ route('users.edit', $user) }}" title="営業担当者情報編集" class="inline-flex items-center px-2 py-1 bg-green-500 text-white text-xs font-medium rounded-md hover:bg-green-600 transition-colors duration-200">
                                <i class="fas fa-edit mr-1"></i> 編集
                            </a>
                        </div>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- js-clickable-row のためのJavaScript --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.js-clickable-row').forEach(row => {
            row.addEventListener('click', function(event) {
                // 操作アイコンがクリックされた場合はリンク遷移を阻止
                if (event.target.closest('.js-no-link')) {
                    event.preventDefault(); // リンク遷移を完全に阻止
                    event.stopPropagation(); // イベントのバブリングも停止
                    return;
                }
                const href = this.dataset.href;
                if (href) {
                    window.location.href = href;
                }
            });
        });
    });
</script>
@endpush
@endsection