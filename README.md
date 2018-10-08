# PHP Slim3アプリケーション

## 機能
  - アカウント登録
  - 画面遷移

## 動作要件

## push test

## 主要技術
  - Ubuntu16.04
  - Apache2.4
  - PostgreSQL
  - PHP7.2
     - Composer
     - Selenium
     - PHPUnit
  - Slim3
    - twig
    - pimple
    - slim-csrf
    - slim-flash
    
## ローカル環境実行方法
git clone https://github.com/murase-msk/slim_app.git

sh ./provision.sh

composer install

php database/init/initDatabase.php

