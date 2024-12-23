@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')

<div class="purchase-container">
    <div class="purchase-left">
        <div id="card-errors" style="color: red; margin-top: 10px;"></div>
            <div class="purchase-left-top">
                @if($item->images->isNotEmpty())
                    @foreach($item->images as $image)
                        <img src="{{ asset($image->image_url) }}" alt="{{ $item->name }}" class="purchase-item-image">
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
            @if($currentPaymentMethod->name === 'クレジットカード')
                <!-- クレジットカード用フォーム -->
            <form action="{{ route('payment.card') }}" method="POST" id="card-payment-form">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <input type="hidden" name="buyer_id" value="{{ auth()->id() }}">
                <input type="hidden" name="payment_method_id" value="{{ $currentPaymentMethod->id ?? '' }}">
                <input type="hidden" name="postal_code" value="{{ $currentAddress->postal_code ?? '' }}">
                <input type="hidden" name="address" value="{{ $currentAddress->address ?? '' }}">
                <input type="hidden" name="building_name" value="{{ $currentAddress->building_name ?? '' }}">
                <button type="submit" id="show-card-modal" class="purchase-confirm-button">購入確定</button>
            </form>
            @else
            <!-- 銀行振込・コンビニ払いフォーム -->
            <form action="{{ route('payment.noncard') }}" method="POST">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <input type="hidden" name="buyer_id" value="{{ auth()->id() }}">
                <input type="hidden" name="payment_method_id" value="{{ $currentPaymentMethod->id ?? '' }}">
                <input type="hidden" name="postal_code" value="{{ $currentAddress->postal_code ?? '' }}">
                <input type="hidden" name="address" value="{{ $currentAddress->address ?? '' }}">
                <input type="hidden" name="building_name" value="{{ $currentAddress->building_name ?? '' }}">
                <button type="submit" class="purchase-confirm-button">購入確定</button>
            </form>
            @endif
        </div>
    </div>
</div>

<!-- カード情報入力モーダル -->
<div id="card-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <span id="close-modal" class="close-button">&times;</span>
        <h3>カード情報入力</h3>
        <form id="stripe-form">
            @csrf
            <div id="card-element" style="margin-bottom: 20px;"></div>
            <div id="card-errors" role="alert" style="color: red;"></div>
            <button type="button" id="submit-payment-button" class="purchase-confirm-button">支払いを確定する</button>
        </form>
    </div>
</div>

<div id="stripe-key" data-key="{{ $stripeKey }}"></div>
@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ asset('js/purchase.js') }}"></script>
@endsection
