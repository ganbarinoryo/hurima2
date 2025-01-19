# coachtech フリマ

「coachtech フリマ」は、ある企業が開発した独自のフリマアプリで、coachtech ブランドのアイテムを出品するために製作されたアプリです。

## 機能

このフリマサイトには以下の主な機能があります：

- **会員登録**
  ![会員登録](https://github.com/ganbarinoryo/raw/main/src/public/images/register.png)

- **ログイン / ログアウト**

- **商品一覧取得**

- **商品詳細取得**

- **商品お気に入り一覧取得**

- **ユーザー情報取得**

- **ユーザー購入商品一覧取得**

- **ユーザ出品商品一覧取得**

- **プロフィール変更**

- **商品お気に入り追加 / 削除**

- **商品コメント追加 / 削除**

- **商品出品**

## 環境

このプロジェクトは以下の環境で動作します：

- **作業 OS**: MacOS Ventura 13.7.2
- **PHP バージョン**: 7.4.9
- **Docker 使用**
- **MySQL（Docker 内で設定）**

## セットアップ方法

### 前提条件

- Docker と Docker Compose がインストールされていること

### 手順

1. リポジトリをクローン

   git clone https://github.com/yourusername/coachtech-fleamarket.git coachtech-hurima

2. 必要なコンテナをビルドして起動

   下記を docker-compose.yml があるディレクトリで実行してください。

   docker-compose down && docker-compose build && docker-compose up -d

3. コンテナが立ち上がったら、Laravel のセットアップを行うために以下のコマンドを実行してください。依存関係をインストールします。

   docker-compose exec app composer install

4. 以下のコマンドを実行して、環境設定ファイル.env を設定します。

   cp .env.example .env

   .env ファイルが作成できたら以下のように設定してください。

   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=laravel_db
   DB_USERNAME=laravel_user
   DB_PASSWORD=laravel_pass

5. マイグレーションを実行して、データベースを作成します。

   docker-compose exec app php artisan migrate

6. サーバーを立ち上げ、ブラウザでアクセスします。

   docker-compose exec app php artisan serve

   サイトにアクセスするには、http://localhost:8000 にブラウザでアクセスしてください。

## php.ini 設定

    プロジェクトには以下のphp.ini設定が含まれています。

    date.timezone = "Asia/Tokyo"

    [mbstring]
    mbstring.internal_encoding = "UTF-8"
    mbstring.language = "Japanese"

    upload_max_filesize = 10M
    post_max_size = 12M

    max_execution_time = 300

## default.conf 設定

    以下は、Webサーバーの設定 (default.conf) です。

    server {
    listen 80;
    index index.php index.html;
    server_name localhost;
    client_max_body_size 10M;

    root /var/www/public;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    location /storage {
        alias /var/www/storage/app/public;
        access_log off;
        log_not_found off;
        expires max;
    }

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass php:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
        }
    }

## Dockerfile 設定

    FROM php:7.4.9-fpm

    COPY php.ini /usr/local/etc/php/

    RUN apt update \
        && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
        && docker-php-ext-install pdo_mysql zip

    RUN curl -sS https://getcomposer.org/installer | php \
        && mv composer.phar /usr/local/bin/composer \
        && composer self-update

    WORKDIR /var/www
