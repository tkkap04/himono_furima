@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/registlogin.css') }}">
@endsection

@section('content')

<div class="container">
    <div class="input">
        <div class="input-title">
            <h2 class="input-title__text">ログイン</h2>
        </div>

        <form class="input-box" action="/login" method="post">
        @csrf
            <div class="input-box__item-title-box">
                <p class="input-box__item-title">メールアドレス</p>
            </div>
            <div class="input-box__item__email">
                <input type="email" name="email" class="input-box__item-input" placeholder="Email" value="{{ old('email') }}" >
            </div>
            <p class="input-box__error-message">
                @error('email')
                {{ $message }}
                @enderror
            </p>

            <div class="input-box__item-title-box">
                <p class="input-box__item-title">パスワード</p>
            </div>
            <div class="input-box__item__password">
                <input type="password" name="password" class="input-box__item-input" placeholder="Password" >
            </div>
            <p class="input-box__error-message">
                @error('password')
                {{ $message }}
                @enderror
            </p>
            <div class="input-box__item-submit">
                <input type="submit" class="input-box__item-submit-button" value="ログインする" >
            </div>
        </form>

        <div>
            <a class="input-move" href="/register">会員登録はこちら</a>
        </div>

    </div>
</div>

@endsection