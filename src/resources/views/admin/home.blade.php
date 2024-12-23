@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/home.css') }}">
@endsection

@section('content')
<div class="admin-home">
    <h2 class="admin-home__title">管理画面</h2>
    <div class="admin-home__menu">
        <div class="admin-home__button-box">
            <a href="{{ route('admin.email.list') }}" class="admin-home__button">ユーザー一覧</a>
        </div>
        <div class="admin-home__button-box">
            <a href="{{ route('admin.editEmail') }}" class="admin-home__button">メール内容編集</a>
        </div>
    </div>
</div>
@endsection
