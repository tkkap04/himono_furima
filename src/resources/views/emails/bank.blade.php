<!DOCTYPE html>
<html>
<head>
    <title>{{ $subject ?? '注文確定メール' }}</title>
</head>

<body>
<p>{{ $user->name }} 様</p>
<p>以下の商品について、銀行振込の支払い情報をお知らせいたします。</p>

<ul>
    <li>商品名: {{ $item->name }}</li>
    <li>価格: ¥{{ number_format($item->price) }}</li>
</ul>

<p>振込先情報は以下の通りです:</p>
<p>
    銀行名: 〇〇銀行<br>
    支店名: 〇〇支店<br>
    口座番号: 1234567<br>
    口座名義: フリマアプリ
</p>

<p>ご購入ありがとうございます。</p>
</body>
</html>