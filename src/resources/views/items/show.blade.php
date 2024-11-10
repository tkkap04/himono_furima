@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')

<div class="item-detail-container">
    <div class="item-detail-left">
        @if($item->images->isNotEmpty())
            @foreach($item->images as $image)
                <img src="{{ $image->image_url }}" alt="商品画像" class="item-detail-image">
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
            <!-- お気に入り解除ボタン -->
            <form action="{{ route('favorite.destroy', ['item' => $item->id]) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="favorite-button">
                    <img src="{{ asset('icon/heart_red.png') }}" alt="お気に入り解除" class="favorite-icon">
                </button>
            </form>
        @else
            <!-- お気に入り登録ボタン -->
            <form action="{{ route('favorite.store') }}" method="post">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <button type="submit" class="favorite-button">
                    <img src="{{ asset('icon/heart_gray.png') }}" alt="お気に入り" class="favorite-icon">
                </button>
            </form>
        @endif
        </div>

        <a href="{{ route('comments.index', ['id' => $item->id]) }}" class="item-detail__comment-button">
            <img src="{{ asset('icon/comment.png') }}" alt="コメント" class="comment-icon">
        </a>

        @if(!$isCommentPage)
            <div class="item-detail__button-box">
                <a href="/purchase/{{ $item->id }}" class="item-detail__purchase-button">購入する</a>
            </div>

            <div class="item-detail-description">
                <h3>商品説明</h3>
                <p>{{ $item->description }}</p>
            </div>

            <div class="item-detail-info">
                <h3>商品の情報</h3>
                <p>カテゴリー {{ $item->category->name }}</p>
                <p>商品の状態 {{ $item->condition->name }}</p>
            </div>
        @else
        <a href="{{ route('items.show', ['id' => $item->id]) }}" class="back-button">
            <img src="{{ asset('icon/back.png') }}" alt="戻る" class="back-icon">
        </a>
            <div class="comments-section">
                <h3>コメント一覧</h3>
                @foreach($comments as $comment)
                    <div class="comment">
                        <p><strong>{{ $comment->user->name }}</strong> <span>{{ $comment->created_at->format('Y-m-d H:i') }}</span></p>
                        <p>{{ $comment->content }}</p>
                    </div>
                @endforeach

                <form action="{{ route('comments.store', ['id' => $item->id]) }}" method="POST">
                    @csrf
                    <textarea name="comment" rows="4" class="comment-textarea" placeholder="コメントを入力してください"></textarea>
                    <button type="submit" class="comment-submit-button">コメントを投稿</button>
                    <!-- 戻るボタン -->
                </form>
            </div>
        @endif
    </div>
</div>

@endsection