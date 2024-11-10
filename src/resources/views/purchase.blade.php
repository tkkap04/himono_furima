@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')

<div class="purchase-container">
    <div class="purchase-left">
        
        <div class="purchase-left-top">
            @if($item->images->isNotEmpty())
                @foreach($item->images as $image)
                    <img src="{{ $image->image_url }}" alt="商品画像" class="purchase-item-image">
                @endforeach
            @else
                <img src="{{ asset('image/1.png') }}" alt="ダミー画像" class="purchase-item-image">
            @endif
            <div class="purchase-item-info">
                <h2 class="purchase-item-name">{{ $item->name }}</h2>
                <p class="purchase-item-price">価格: ¥{{ number_format($item->price) }}</p>
            </div>
        </div>

        <div class="purchase-left-bottom">
            <div class="purchase-payment">
                <label>支払方法</label>
                <span>{{ $currentPaymentMethod->name ?? '未設定' }}</span>
                <a href="{{ route('change.method') }}" class="change-link">変更する</a>
            </div>

            <div class="purchase-address">
                <label>配送先</label>
                <span>〒{{ $currentAddress }}</span>
                <a href="{{ route('change.place') }}" class="change-link">変更する</a>
            </div>
        </div>

    </div>

    <div class="purchase-right">
        
        <div class="purchase-right-top">
            <h3>購入内容の確認</h3>
            <p>商品金額: ¥{{ number_format($item->price) }}</p>
            <p>支払い金額: ¥{{ number_format($totalPayment) }}</p>
            <p>支払い方法:{{ $currentPaymentMethod->name ?? '未設定' }}</p>
        </div>

        <div class="purchase-right-bottom">
            <form action="{{ route('purchase.confirm', ['id' => $item->id]) }}" method="POST">
                @csrf
                <div class="purchase-right-bottom__box">
                    <button type="submit" class="purchase-confirm-button">購入確定</button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/purchase.js') }}"></script>
@endsection
