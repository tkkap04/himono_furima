<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="stripe-key" content="{{ config('services.stripe.key') }}">
    <title>FURIMA</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> 
    @yield('css')
</head>

<body>
    <div class="app">
        <header class="header">
            <nav class="header-nav">
                <div class="header-nav-left">
                    <li class="header-nav-left__item">
                        <a href="/">
                            <img src="{{ asset('logo.svg') }}" alt="Logo" class="header-nav-left__img">
                        </a>
                    </li>
                </div>
                @if(Auth::check())
                    <div class="header-nav-center">
                        <form class="header-nav-center__form" action="{{ route('items.index') }}" method="get">
                            @csrf
                            <input class="header-nav-center__form-input" type="text" name="search" placeholder="何をお探しですか？" value="{{ request()->get('search') }}">
                                <button class="header-nav-center__form-button" type="submit"></button>
                        </form>
                        </div>
                    <ul class="header-nav-right">
                        <li class="header-nav-right__item">
                            <form id="logout-form" action="{{ route('logout') }}" method="post">
                                @csrf
                            </form>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                ログアウト
                            </a>
                        </li>
                        <li class="header-nav-right__item">
                            @if(Route::currentRouteName() === 'mypage')
                                <a href="/">トップページ</a>
                            @else
                                <a href="/mypage">マイページ</a>
                            @endif
                        </li>
                        <li class="header-nav-right__item"><a href="/sell">出品</a></li>
                    </ul>
                @elseif(Route::currentRouteName() !== 'login' && Route::currentRouteName() !== 'register')
                    <div class="header-nav-center">
                        <form class="header-nav-center__form" action="{{ route('items.index') }}" method="get">
                            @csrf
                            <input class="header-nav-center__form-input" type="text" name="search" placeholder="何をお探しですか？" value="{{ request()->get('search') }}">
                                <button class="header-nav-center__form-button" type="submit"></button>
                        </form>
                        </div>
                    <ul class="header-nav-right">
                        <li class="header-nav-right__item"><a href="/login">ログイン</a></li>
                        <li class="header-nav-right__item"><a href="/register">会員登録</a></li>
                        <li class="header-nav-right__item"><a href="/sell">出品</a></li>
                    </ul>
                @endif
            </nav>
        </header>

        <main class="content">
            @yield('content')
        </main>
    </div>
    
    <!-- JavaScriptの読み込み -->
     @yield('scripts')
</body>  
</html>
