@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/success.css') }}">
@endsection

@section('content')
<div class="success-container">
    <h2 class="success-container__title">ご購入ありがとうございました！</h2>
    <p class="success-container__text">クレジットカードでのお支払いが正常に処理されました。</p>
    <a href="{{ route('mypage') }}" class="success-container__link">トップページに戻る</a>
</div>
@endsection