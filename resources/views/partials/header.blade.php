<div class="separate1">
    <div class="header-logo">
        <h2><i class="fa-solid fa-clipboard"></i>顧客情報管理システム</h2>
    </div>

    @if (Auth::check())
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
            @if(Auth::check()) 
                <p>{{ Auth::user()->user_name }}
                @if(Auth::check() && Auth::user()->authority === 'admin')
                <span class="admin">(管理者)</span></p>
                @elseif(Auth::check() && Auth::user()->authority === 'sales')
                <span class="sales">(営業担当者)</span></p> 
                @endif
            @else
            <p>ログインしていません</p>
            @endif
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
    @endif
</div>
<div class="separate2">
    <div class="title">
        @yield('header-title')
    </div>
    <div class="message-container">
        @if (session('success'))
        <div class="message alert alert-success"><p>{{ session('success')}}</p></div>
        @endif
        @if (session('error'))
        <div class="message alert-error">
            {{ session('error') }}
        </div>
        @endif

        @if (session('status'))
        <div class="message alert-success">
            {{ session('status') }}
        </div>
        @endif
    </div>
    <div class="header-actions">
        @yield('header_actions')
    </div>
</div>

