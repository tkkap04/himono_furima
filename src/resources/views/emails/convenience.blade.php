<!DOCTYPE html>
<html>
<head>
    <title>{{ $subject ?? '注文確定メール' }}</title>
</head>

<body>
<p>{{ $user->name }} 様</p>
<p>以下の商品について、コンビニ支払いの情報をお知らせいたします。</p>

<ul>
    <li>商品名: {{ $item->name }}</li>
    <li>価格: ¥{{ number_format($item->price) }}</li>
</ul>

<p>コンビニ支払いの手順は以下の通りです:</p>
<ol>
    <li>コンビニ端末で以下の番号を入力してください。</li>
    <li>受付番号: 123-4567</li>
    <li>レジでお支払いを行ってください。</li>
</ol>

<p>ご購入ありがとうございます。</p>
</body>
</html>