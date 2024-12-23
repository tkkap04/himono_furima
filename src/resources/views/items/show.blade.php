@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')

<div class="item-detail-container">
    <div class="item-detail-left">
        @if($item->images->isNotEmpty())
            @foreach($item->images as $image)
                <img src="{{ asset($image->image_url) }}" alt="{{ $item->name }}" class="item-detail-image">
            @endforeach
        @else
            <img src="{{ asset('image/1.png') }}" alt="ダミー画像" class="item-detail-image">
        @endif
    </div>

    <div class="item-detail-right">
        <h2 class="item-detail-title">{{ $item->name }}</h2>

        <p class="item-detail-brand">ブランド {{ $item->brand }}</p>

        <p class="item-detail-price">価格: ¥{{ number_format($item->price) }}</p>

        <div class="item-detail__favorite-button">
            @if($isFavorited)
                <form action="{{ route('favorite.destroy', ['item' => $item->id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="favorite-button">
                        <img src="{{ asset('icon/heart_red.png') }}" alt="お気に入り解除" class="favorite-icon">
                    </button>
                </form>
            @else
                <form action="{{ route('favorite.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <button type="submit" class="favorite-button">
                        <img src="{{ asset('icon/heart_gray.png') }}" alt="お気に入り" class="favorite-icon">
                    </button>
                </form>
            @endif
        </div>

        @if(!$isCommentPage)
            <a href="{{ route('comments.index', ['id' => $item->id, 'from' => $fromToppage ? 'items.index' : ($fromMypage ? 'mypage' : '')]) }}" class="item-detail__comment-button">
                <img src="{{ asset('icon/comment.png') }}" alt="コメント" class="comment-icon">
            </a>
        @endif

        @if($isCommentPage)
            <a href="{{ route('items.show', ['id' => $item->id, 'from' => $fromToppage ? 'items.index' : ($fromMypage ? 'mypage' : '')]) }}" class="back-button">
                <img src="{{ asset('icon/back.png') }}" alt="戻る" class="back-icon">
            </a>
        @else
            @if($fromToppage)
                <a href="{{ route('items.index') }}" class="item-detail__pageback">トップページに戻る</a>
            @endif

            @if($fromMypage)
                <a href="{{ route('mypage') }}" class="item-detail__pageback">マイページに戻る</a>
            @endif
        @endif

        @if(!$isCommentPage)
            <div class="item-detail__button-box">
                <a href="/purchase/{{ $item->id }}" class="item-detail__purchase-button">購入する</a>
            </div>
        @endif

        @if($isCommentPage)
            <div class="item-detail__comments-section">
                <h3>コメント一覧</h3>
                @foreach($comments as $comment)
                    <div class="item-detail__comment-box">
                        <p class="item-detail__comment-name">{{ $comment->user->name }}</p>
                        <p class="item-detail__comment-content">{{ $comment->content }}</p>
                        <div class="item-detail__comment-below">
                            <p class="item-detail__comment-date">{{ $comment->created_at->format('Y-m-d H:i') }}</p>
                            @if(Auth::user() && Auth::user()->isAdmin())
                            <div class="item-detail__comment-delete-form">
                                <form action="{{ route('comments.destroy', ['id' => $comment->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="comment-delete-button">削除</button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <form action="{{ route('comments.store', ['id' => $item->id]) }}" method="post">
                    @csrf
                    <textarea name="comment" rows="4" class="item-detail__comment-textarea" placeholder="コメントを入力してください"></textarea>
                    <button type="submit" class="comment-submit-button">コメントを投稿</button>
                </form>
            </div>
        @endif

        <div class="item-detail-description">
            <h3>商品説明</h3>
            <p>{{ $item->description }}</p>
        </div>

        <div class="item-detail-info">
            <h3>商品の情報</h3>
            <p>カテゴリー {{ $item->category->name }}</p>
            <p>商品の状態 {{ $item->condition->name }}</p>
        </div>
    </div>
</div>

@endsection
