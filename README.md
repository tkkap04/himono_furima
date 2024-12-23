## Furima
![Stamp](https://github.com/tkkap04/himono_furima/blob/main/top.png)

## 作成した目的
不要な商品の売買をするため

## アプリケーションURL
http://localhost
ログインパスワードは8文字以上

## 機能一覧
- 会員登録機能
- ログイン機能
- 商品一覧表示機能
- 商品詳細表示機能
- 商品検索機能
- 商品お気に入り機能（登録・削除）
- コメント投稿機能
- コメント削除機能（admin）
- マイページ表示機能
- 決済方法変更機能
- 配送先変更機能
- 出品機能
- adminユーザー一覧表示機能
- adminメール送信機能
- adminメール編集機能

## 使用技術(実行環境)
- Laravel Framework 8.83.27
- PHP 8.1.2

## テーブル設計
![Table](https://github.com/tkkap04/himono_furima/blob/main/table.png)

## ER図
![Atte](https://github.com/tkkap04/himono_furima/blob/main/er.png)

## 環境構築
- Dockerのビルドからマイグレーション、シーディングまでを記述する
1. docker-compose exec php bash
2. composer install
3. .env.exampleファイルから.envを作成し、環境変数を変更
4. php artisan key:generate
5. php artisan migrate

## URL
- 開発環境：http://localhost/
- phpmyadmin：http://localhost:8080/
