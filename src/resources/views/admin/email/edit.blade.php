@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/edit.css') }}">
@endsection

@section('content')
<div class="admin-edit">
    <h2 class="admin-edit__title">メール内容編集</h2>
    <form action="{{ route('admin.updateEmail') }}" method="post">
        @csrf
        <div class="admin-edit__box">
            <label class="admin-edit__mail-label" for="subject">件名</label>
            <input class="admin-edit__mail-subject--input" type="text" name="subject" id="subject" value="{{ $emailSettings['subject'] ?? '' }}">
        </div>

        <div class="admin-edit__box">
            <label class="admin-edit__mail-label" for="content">本文</label>
            <textarea class="admin-edit__mail-content--input" name="content" id="content">{{ $emailSettings['content'] ?? '' }}</textarea>
        </div>

        <div class="admin-edit__submit">
            <input type="submit" class="admin-edit__submit-button" value="更新する" >
        </div>
    </form>
@endsection
