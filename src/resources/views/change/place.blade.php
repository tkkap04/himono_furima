@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/change.css') }}">
@endsection

@section('content')
<div class="change-container">
    <div class="change-container__title-box">
        <h2 class="change-container__title-text">配送先の変更</h2>
    </div>
    <p class="change-container__current">現在の配送先: {{ $currentAddress }}</p>
    <form action="{{ route('update.place', ['id' => session('item_id')]) }}" method="post">
        @csrf
        <div class="change-container__group">
            <div class="change-container__item-box">
                <label class="change-container__item" for="postal_code">郵便番号</label>
            </div>
            <input class="change-container__input" type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $currentAddress['postal_code'] ?? '') }}">
        </div>
        <p class="input-box__error-message">
            @error('email')
            {{ $message }}
            @enderror
        </p>
        <div class="change-container__group">
            <div  class="change-container__item-box">
                <label class="change-container__item" for="address">住所</label>
            </div>
            <input class="change-container__input" type="text" id="address" name="address" value="{{ old('address', $currentAddress['address'] ?? '') }}">
        </div>
        <p class="input-box__error-message">
            @error('email')
            {{ $message }}
            @enderror
        </p>
        <div class="change-container__group">
            <div  class="change-container__item-box">
                <label class="change-container__item" for="building">建物名</label>
            </div>
            <input class="change-container__input" type="text" id="building" name="building" value="{{ old('building', $currentAddress['building_name'] ?? '') }}">
        </div>

        <div class="input-box__item-submit">
            <input type="submit" class="input-box__item-submit-button" value="更新する" >
        </div>
    </form>
</div>
@endsection

