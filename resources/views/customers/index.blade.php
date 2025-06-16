@extends('layouts.app')


@section('title', '顧客情報一覧')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/confirm_modal.css') }}">
@endsection

@section('header-title')
<span>顧客情報一覧</span>
@endsection

@section('header_actions')
    @if(Auth::check() && Auth::user()->authority === 'admin')
    <a href="{{ route('customers.create') }}" title="新規顧客登録" class="btn btn-info">新規顧客登録</a>
    @endif
@endsection    

@section('content')
<div class="card customer-list">
    {{-- テーブル --}}
    <table>
        <thead>
            <tr>
                <th>顧客名</th>
                <th>担当者</th>
                <th>電話番号</th>
                <th>地域</th>
                <th>営業担当</th>
                <th>更新日</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reversed_customers as $customer)
                <tr>
                    <td><span class="customer-name">{{ $customer->customer_name }}</span> <br> <span class="thin">{{ $customer->customer_name_kana }}</span></td>
                    <td>{{ $customer->contact_person_name }} <br> <span class="thin">{{ $customer->contact_person_name_kana }}</span></td>
                    <td>{{ $customer->contact_person_tel }}</td>
                    <td>{{ $customer->area->area_name }}</td>
                    <td>{{ $customer->user->user_name }}</td>
                    <td><span class="thin">{{ $customer->updated_at->format('Y/m/d H:i') }}</span></td>
                    <td class="actions">
                        <a href="{{ route('customers.show', ['customer' => $customer->id]) }}" title="顧客情報詳細"><i class="fas fa-eye"></i></a>
                        @if(Auth::check() && Auth::user()->authority === 'admin')
                        <a href="{{ route('customers.edit', ['customer' => $customer->id]) }}" title="顧客情報編集"><i class="fas fa-edit"></i></a>
                        @endif
                        @if(Auth::check() && Auth::user()->authority === 'admin')
                        <button type="button"  
                        class="btn-sm js-open-modal"
                        data-modal-target="#deleteConfirmationModal" {{--ターゲットとなるモーダルのID。一番外側のdiv--}}
                        data-customer-id="{{ $customer->id }}" 
                        data-customer-name="{{ $customer->customer_name}}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>
</div>

{{-- モーダルウィンドウをインクルード  --}}
@include('partials/confirm_modal')

@endsection

{{-- customer_modal.jsを読み込む --}}
@push('scripts')
    <script src="{{ asset('js/components/confirm_modal.js') }}"></script>
@endpush