@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
<div class="edit-box">
    <h2 class="edit-box__title">プロフィール設定</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form class="edit-box__form" action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="edit-box__form-group--image">
            <input class="edit-box__form-input--image" type="file" name="profile_image" id="profile_image">
            <img id="profileImagePreview" src="{{ $user->profile_image ? asset($user->profile_image) : asset('icon/person.png') }}" alt="プロフィール画像" class="edit-box__form-image">
            <div class="edit-box__form-label--box">
                <label for="profile_image" class="edit-box__form-label--image">画像を選択する</label>
            </div>
        </div>

        <div class="edit-box__form-group">
            <label  class="edit-box__form-label" for="username">ユーザー名</label>
            <input class="edit-box__form-input" type="text" name="name" id="username" value="{{ old('name', $user->name) }}" placeholder="ユーザー名未設定">
        </div>

        <div class="edit-box__form-group">
            <label  class="edit-box__form-label" for="postal_code">郵便番号（ハイフンなし）</label>
            <input class="edit-box__form-input" type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $user->postal_code) }}" placeholder="○○○○○○○">
        </div>

        <div class="edit-box__form-group">
            <label  class="edit-box__form-label" for="address">住所</label>
            <input class="edit-box__form-input" type="text" name="address" id="address" value="{{ old('address', $user->address) }}" placeholder="東京都渋谷区千駄ヶ谷1-2-3">
        </div>

        <div class="edit-box__form-group">
            <label  class="edit-box__form-label" for="building_name">建物名（任意）</label>
            <input class="edit-box__form-input" type="text" name="building_name" id="building_name" value="{{ old('building_name', $user->building_name) }}" placeholder="マンション名 部屋番号">
        </div>

        <div class="edit-box__item-submit">
            <input type="submit" class="edit-box__item-submit-button" value="更新する" >
        </div>
    </form>
</div>

@endsection


@section('scripts')
<script src="{{ asset('js/edit.js') }}"></script>
@endsection