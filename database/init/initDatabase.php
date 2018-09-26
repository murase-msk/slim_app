<?php
/**
 * Created by PhpStorm.
 * User: masaki
 * Date: 2018/09/23
 * Time: 14:01
 */

namespace database\init;

require __DIR__ . '/../../vendor/autoload.php';

// マイグレーション.

$settings = require __DIR__ . '/../../src/settings.php';
$dbName = 'slim_app';

$slimAppDb = new DatabaseConnection($dbName);
$con = $slimAppDb->connectDb();

// テーブル初期化.
$accountTable = new AccountTable($con);
$content1Table = new Content1Table($con);
// 削除順 content1, account.
$content1Table->deleteTable();
$accountTable->deleteTable();
// 作成順 account, content1.
$accountTable->createTable();
$content1Table->createTable();

// シードデータインサート.
// accountテーブルデータ
$seeds = require  __DIR__ . '/../seeds/accountTableSeed.php';
foreach($seeds as $key => $value){
    $accountTable->insertData(
        [
            'email'=>$value['email'],
            'account'=>$value['account'],
            'password'=>$value['password']
        ]);
}


