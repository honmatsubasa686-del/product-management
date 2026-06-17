# COACHTECH mogitate

## 作成者

本間翼

## 使用技術

- PHP 8.2
- Laravel 10.x
- MySQL 8.0
- Docker / Docker Compose / Laravel Sail
- Vite / Tailwind CSS 3.4
- phpMyAdmin

## ER図

ER図はMermaid記法および画像でも確認できます。
画像はプロジェクト内の `assets` フォルダに配置しています。

![ER図](./assets/er.png)

### Mermaid記法

```mermaid
erDiagram

PRODUCTS {
    bigint unsigned id PK
    varchar(255) name
    int price
    varchar(255) image
    text description
    timestamp created_at
    timestamp updated_at
}

SEASONS {
    bigint unsigned id PK
    varchar(255) name
    timestamp created_at
    timestamp updated_at
}

PRODUCT_SEASON {
    bigint unsigned id PK
    bigint unsigned product_id FK
    bigint unsigned season_id FK
    timestamp created_at
    timestamp updated_at
}

PRODUCTS ||--o{ PRODUCT_SEASON : has
SEASONS ||--o{ PRODUCT_SEASON : has
```
## 制約
- UNIQUE(product_id, season_id)

## 開発環境URL

http://localhost

## 動作環境

- Docker
- Docker Compose

※ Windowsの場合はWSL2の利用を推奨します。

## 環境構築
1. **リポジトリをクローン**

    git clone git@github.com:honmatsubasa686-del/product-management.git
    cd product-management

2. **Composer依存パッケージのインストール**

    プロジェクトの初回セットアップ時は、`vendor` ディレクトリが存在しないため `sail` コマンドを使用できません。
    以下のDockerコマンドを実行して、コンテナ内で `composer install` を実行します。

        docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
        laravelsail/php82-composer:latest \
        composer install

3. **.env ファイルの設定**

    cp .env.example .env

    `.env` ファイルを開き、データベース接続情報が以下と一致していることを確認します。

    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=sail
    DB_PASSWORD=password

    重要: DB_HOST は localhost や 127.0.0.1 ではなく、Dockerコンテナ名である mysql を指定します。

4. **Sailの起動とエイリアス設定**

    # Sailをバックグラウンドで起動
    ./vendor/bin/sail up -d

    # 以降、必要に応じて以下のエイリアスを設定すると sail コマンドを短く実行できます。

    echo "alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'" >> ~/.zshrc

    # または bash の場合
    
    echo "alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'" >> ~/.bashrc

    # シェルを再起動するか、新しいターミナルを開いてエイリアスを有効にする
    exec $SHELL

5. **アプリケーションキーの生成**

    sail artisan key:generate

6. **データベースのマイグレーションと初期データ投入**

    sail artisan migrate --seed

   ※既存のデータベースをリセットしたい場合は以下を実行してください。
    sail artisan migrate:fresh --seed

7. **ストレージリンクの作成**
    sail artisan storage:link

8. **フロントエンド依存パッケージのインストール**

    sail npm install

9. **Viteの起動**

    sail npm run dev

    `npm run dev` は開発中は起動したままにしてください。


## 機能一覧
- 商品一覧表示
- 商品検索
- 商品の価格順並び替え
- 商品検索結果の価格順並び替え
- 商品詳細表示
- 商品登録
- 商品編集
- 商品削除
- 商品画像アップロード
- 季節の複数選択
- バリデーションエラーメッセージ表示
- ページネーション

## テーブル設計

### products テーブル

| カラム名 | 型 | 制約 | 説明 |
| --- | --- | --- | --- |
| id | bigint unsigned | primary key | 商品ID |
| name | varchar(255) | not null | 商品名 |
| price | int | not null | 値段 |
| image | varchar(255) | not null | 商品画像パス |
| description | text | not null | 商品説明 |
| created_at | timestamp | nullable | 作成日時 |
| updated_at | timestamp | nullable | 更新日時 |

### seasons テーブル

| カラム名 | 型 | 制約 | 説明 |
| --- | --- | --- | --- |
| id | bigint unsigned | primary key | 季節ID |
| name | varchar(255) | not null | 季節名 |
| created_at | timestamp | nullable | 作成日時 |
| updated_at | timestamp | nullable | 更新日時 |

### product_season テーブル

| カラム名 | 型 | 制約 | 説明 |
| --- | --- | --- | --- |
| id | bigint unsigned | primary key | 中間テーブルID |
| product_id | bigint unsigned | foreign key | 商品ID |
| season_id | bigint unsigned | foreign key | 季節ID |
| created_at | timestamp | nullable | 作成日時 |
| updated_at | timestamp | nullable | 更新日時 |

### product_season テーブルの制約

- `product_id` は `products.id` を参照
- `season_id` は `seasons.id` を参照
- `product_id` と `season_id` の組み合わせは一意
- 商品削除時、関連する `product_season` のレコードも削除されます



## 補足事項

- 商品画像は `storage/app/public` 配下に保存しています。
- 初期データはSeederで投入しています。
- 初期データ投入後、商品10件と季節4件が登録されます。
- 商品と季節は多対多の関係です。
- Apple Silicon搭載MacでMySQLコンテナ起動時にエラーが出る場合は、`compose.yaml` の `mysql` サービスに `platform: 'linux/amd64'` を追加してください。
