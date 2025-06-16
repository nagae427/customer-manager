<div class="separate1">
    <div class="header-logo">
        <h2>顧客情報管理システム</h2>
    </div>
    <div class="user-content">
        <div class="customers-index">
            <a href="{{ route('customers.index') }}">顧客一覧</a>
        </div>
        <div class="users-index">
            <a href="{{ route('users.index') }}">営業担当者一覧</a>
        </div>
        <div class="dashboard">
            <a href="{{ route('dashboard') }}">ダッシュボード</a>
        </div>
        <div class="user-logged-name">
            <p>ログイン中: {{ Auth::user()->user_name }}</p>
            <p>ランク : {{ Auth::user()->authority }}</p>
        </div>
        <div class="logout">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="header-logout-btn">
                    <i class="fas fa-sign-out-alt"></i> ログアウト
                </button>
            </form>
        </div>
    </div>
</div>
<div class="separate2">
    <div class="title">
        @yield('header-title')
    </div>
    <div class="message">
        @error('user_id')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success')}}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-error">
            {{ session('error')}}
        </div>
        @endif
    </div>
    <div class="header-actions">
        @yield('header_actions')
    </div>
</div>

