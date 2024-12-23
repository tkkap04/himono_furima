@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/list.css') }}">
<link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@endsection

@section('content')
<div class="admin-list">
    <h2 class="admin-list__title">ユーザー一覧</h2>
    <form action="{{ route('admin.sendEmailAll') }}" method="post">
        @csrf
        <button type="submit" class="admin-list__sendall">メール一斉送信</button>
    </form>
    <table class="user-table">
        <thead class="user-table-thead">
            <tr class="user-table-row">
                <th class="user-table-head">ID</th>
                <th class="user-table-head">名前</th>
                <th class="user-table-head">メールアドレス</th>
                <th class="user-table-head">送信ボタン</th>
            </tr>
        </thead>
        <tbody class="user-table-tbody">
            @foreach($users as $user)
                <tr class="user-table-row">
                    <td class="user-table-description">{{ $user->id }}</td>
                    <td class="user-table-description">{{ $user->name }}</td>
                    <td class="user-table-description">{{ $user->email }}</td>
                    <td class="user-table-description">
                        <form action="{{ route('admin.sendEmail', ['user' => $user->id]) }}" method="post">
                            @csrf
                            <button type="submit" class="admin-list__send">メール送信</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
<nav>
    <ul class="pagination">
        {{ $users->appends(request()->query())->links('vendor.pagination.default') }}
    </ul>
</nav>
@endsection
