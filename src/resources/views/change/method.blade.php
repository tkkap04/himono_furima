@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/change.css') }}">
@endsection

@section('content')
<div class="change-container">
    <div class="change-container__inner">
        <div class="change-container__title-box">
            <h2 class="change-container__title-text">支払方法の変更</h2>
        </div>
        <div class="change-container__current-box">
            <p class="change-container__current">現在の支払方法:{{ $currentPaymentMethod->name ?? '未設定' }}</p>
        </div>
        <form action="{{ route('update.method') }}" method="POST">
            @csrf
            <label class="change-container__item" for="payment_method">新しい支払方法</label>
            <select class="change-container__select" name="payment_method_id" id="payment_method" required>
                @foreach($paymentMethods as $method)
                    <option class="change-container__option" value="{{ $method->id }}" {{ $method->id == $user->payment_method_id ? 'selected' : '' }}>
                        {{ $method->name }}
                    </option>
                @endforeach
            </select>            
            <div class="input-box__item-submit">
                <input type="submit" class="input-box__item-submit-button" value="更新する" >
            </div>
        </form>
    </div>
</div>
@endsection

    

