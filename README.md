# セットアップガイド

このアプリケーションは、サードパーティアプリケーションからのOAuth認証ログインを可能にするサンプルアプリケーションです。

セットアップ手順：

- composer install を実行
- npm install を実行
- npm run build を実行
- php -r "file_exists('.env') || copy('.env.example', '.env');" を実行
- php artisan key:generate を実行
- php artisan migrate を実行
- php artisan passport:keys を実行
- php artisan passport:client を実行
    - クライアント名はデフォルトのままで使用
    - リダイレクトURLには http://localhost:8001/auth/callback を入力
    - 生成されたクライアントIDとクライアントシークレットは後で使用するため保存
- composer run dev を実行 (
  このプロジェクトで最初にこのコマンドを実行して、アプリケーションがポート8000で動作していることを確認してください)

# Setup Guide

This is a hq example app that enable oauth login from third party application

To setup this application:

- composer install
- npm install
- npm run build
- php -r "file_exists('.env') || copy('.env.example', '.env');"
- php artisan key:generate
- php artisan migrate
- php artisan passport:keys
- php artisan passport:client
    - Use default name for the client
    - For redirect url please put http://localhost:8001/auth/callback
    - Save the client ID and client secret for later uses
- composer run dev (Make sure the application is running in port 8000 by running this command in this project first)
