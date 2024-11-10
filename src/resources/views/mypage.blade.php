@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage-container">
    <div class="mypage-content">
        <div class="mypage__profile-section">
            <div class="mypage__profile-image">
                <img id="profileImagePreview" src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('icon/person.png') }}" alt="プロフィール画像" class="mypage__profile-image__img">
            </div>
            <div class="mypage__profile-details">
                <p class="mypage__profile-username">{{ $user->name ?? 'ユーザー名未設定' }}</p>
                <a href="/profile/edit" class="mypage__profile-edit-button">プロフィール編集</a>
            </div>
        </div>

        <div class="mypage__tabs-section">
            <div class="mypage__tabs">
                <div class="mypage__tab-item {{ $activeTab === 'selling' ? 'active-tab' : '' }}">
                    <a href="{{ route('mypage.selling') }}" class="{{ $activeTab === 'selling' ? 'active' : '' }}">出品した商品</a>
                </div>
                <div class="mypage__tab-item {{ $activeTab === 'purchased' ? 'active-tab' : '' }}">
                    <a href="{{ route('mypage.purchased') }}" class="{{ $activeTab === 'purchased' ? 'active' : '' }}">購入した商品</a>
                </div>
            </div>
        </div>

        <div class="mypage__items-section">
            <div class="mypage__items-section-list">
                @foreach ($items as $item)
                    <a class="mypage__items-section-box">
                        <img src="{{ asset($item->image_url) }}" alt="{{ $item->name }}" class="mypage__items-section-image">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
