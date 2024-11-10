@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/registlogin.css') }}">
@endsection

@section('content')

<div class="container">
    <div class="input">
        <div class="input-title">
            <h2 class="input-title__text">会員登録</h2>
        </div>

        <form class="input-box" action="/register" method="post">
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
                <input type="submit" class="input-box__item-submit-button" value="登録する" >
            </div>
        </form>

        <div>
            <a class="input-move" href="/login">ログインはこちら</a>
        </div>

    </div>
</div>

@endsection