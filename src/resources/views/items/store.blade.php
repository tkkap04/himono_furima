@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/store.css') }}">
@endsection

@section('content')
<div class="store-box">
    <h1 class="store-box__title">商品を出品する</h1>
    
    <form action="{{ route('items.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <!-- 商品画像 -->
        <div class="store-box__form-item">
            <label for="image" class="store-box__image-title">
                <span class="store-box__image-text">商品画像を選択</span>
            </label>
            <input type="file" name="images[]" class="store-box__form-input--image" id="image" multiple onchange="previewImages(event)">
        </div>
        <div id="image-previews"></div>
        <p class="store-box__error-message">
            @error('images')
            {{ $message }}
            @enderror
        </p>

        <!-- 画像プレビュー -->
        <div id="image-previews"></div>

        <div class="store-box__subtitle">
            <p class="store-box__subtitle-text">商品の詳細</p>
        </div>

        <!-- カテゴリー -->
        <div class="store-box__form-item">
            <label for="category_id" class="store-box__form-title">カテゴリー</label>
            <select name="category_id" id="category_id" class="store-box__form-input">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <p class="store-box__error-message">
            @error('category_id')
            {{ $message }}
            @enderror
        </p>

        <!-- 商品状態 -->
        <div class="store-box__form-item">
            <label for="condition_id" class="store-box__form-title">商品状態</label>
            <select name="condition_id" id="condition_id" class="store-box__form-input">
                @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                        {{ $condition->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <p class="store-box__error-message">
            @error('condition_id')
            {{ $message }}
            @enderror
        </p>

        <div class="store-box__subtitle">
            <p class="store-box__subtitle-text">商品名と説明</p>
        </div>

        <!-- 商品名 -->
        <div class="store-box__form-item">
            <label for="name" class="store-box__form-title">商品名</label>
            <input type="text" name="name" class="store-box__form-input" id="name" value="{{ old('name') }}">
        </div>
        <p class="store-box__error-message">
            @error('name')
            {{ $message }}
            @enderror
        </p>

        <!-- ブランド -->
        <div class="store-box__form-item">
            <label for="brand" class="store-box__form-title">ブランド</label>
            <input type="text" name="brand" class="store-box__form-input" id="brand" value="{{ old('brand') }}">
        </div>

        <!-- 商品説明 -->
        <div class="store-box__form-item">
            <label for="description" class="store-box__form-title">商品説明</label>
            <textarea name="description" class="store-box__form-textarea" id="description" rows="5">{{ old('description') }}</textarea>
        </div>

        <div class="store-box__subtitle">
            <p class="store-box__subtitle-text">販売価格</p>
        </div>

        <!-- 価格 -->
        <div class="store-box__form-item">
            <label for="price" class="store-box__form-title">価格</label>
            <input type="number" name="price" class="store-box__form-input" id="price" value="{{ old('price') }}" step="1">
        </div>
        <p class="store-box__error-message">
            @error('price')
            {{ $message }}
            @enderror
        </p>

        <!-- 出品ボタン -->
        <div class="input-box__item-submit">
            <button type="submit" class="input-box__item-submit-button">出品する</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/store.js') }}"></script>
@endsection
