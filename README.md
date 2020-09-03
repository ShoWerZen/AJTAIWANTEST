## 環境建置

PHP 7.3.12, MySQL 8.0.21

## 複製 laravel.env 為 .env

需要填寫的資料如下：

1.資料庫設定-》DB_DATABASE, DB_USERNAME, DB_PASSWORD

2.重置密碼時的Mail設定-》MAIL_USERNAME, MAIL_PASSWORD, MAIL_FROM_ADDRESS

3.Google OAuth2 設定-》GOOGLE_CLIENT_ID

## 安裝需求套件

npm install && npm run dev && composer install