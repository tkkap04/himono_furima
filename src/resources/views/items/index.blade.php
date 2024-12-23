@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')


<div class="main-box">
    <div class="main-box-top-wrapper">
        <div class="main-box-top">
            <a class="main-box-top__item {{ $activeTab === 'recommend' ? 'active' : '' }}" 
               href="{{ route('items.index', ['tab' => 'recommend']) }}">おすすめ</a>
            <a class="main-box-top__item {{ $activeTab === 'favorites' ? 'active' : '' }}" 
               href="{{ route('items.index', ['tab' => 'favorites']) }}">マイリスト</a>
        </div>
    </div>
    
    <div class="main-box-bottom-wrapper">
        @if($items->isEmpty())
            <p>アイテムが見つかりません。</p>
        @else
        <div class="main-box-bottom">
            @foreach($items as $item)
                <div class="main-box-bottom__item">
                    <a href="{{ route('items.show', ['id' => $item->id, 'from' => 'items.index']) }}">
                        @if($item->images->isNotEmpty())
                            <img src="{{ $item->images->where('is_top', true)->first()->image_url ?? $item->images->first()->image_url }}" alt="{{ $item->name }}" class="item-image">
                        @else
                            <img src="{{ asset('image/1.png') }}" alt="ダミー画像" class="item-image">
                        @endif
                    </a>
                </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
