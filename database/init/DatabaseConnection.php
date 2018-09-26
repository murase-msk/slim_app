<?php
/**
 * Created by PhpStorm.
 * User: masaki
 * Date: 2018/09/23
 * Time: 13:23
 */

namespace database\init;

/**
 * 初期化用　データベースの各種設定
 * @package database\migrations
 */
class DatabaseConnection
{
    /** @var array $setting データベース接続各種設定 */
    private $setting;
    /** @var string \dbName データベース名 */
    protected $dbName;
    /** @var \PDO $pdo */
    protected $pdo;


    public function __construct($dbName)
    {
        $this->dbName = $dbName;
        $this->setting = require __DIR__ . '/../../src/settings.php';
        $this->setting = $this->setting['settings'];
    }

    /**
     * データベースサーバ接続後、データベースへ接続
     * @return \PDO
     */
    public function connectDb(){
        echo 'connecting db'.PHP_EOL;
        $this->connect();
        $this->createDbIfNotExist();
        $this->connect($this->dbName);
        return $this->pdo;
    }

    /**
     * データベース接続
     * @param string $dbName
     */
    private function connect($dbName = '')
    {
        $db = $this->setting['db_psql'];
        $dsn = 'pgsql:host=' . $db['host']. ' port=5432';
        $dsn .= strcmp($dbName, '') !== 0 ? ' dbname='.$this->dbName : '';
        $pdo = new \PDO($dsn, $db['user'], $db['pass']);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        $this->pdo = $pdo;
    }

    /**
     * データベースがなければ作成する
     */
    private function createDbIfNotExist()
    {
        if ($this->isDbExist()) {
            echo 'exist db' . PHP_EOL;
            $this->dropDatabase();
            $this->createNewDatabase();
        }else{
            $this->createNewDatabase();
        }

    }

    /**
     * データベースがあるかチェックする
     * @return bool
     */
    private function isDbExist()
    {
        $sql = 'select count(*) from pg_database where datname=:dbName;';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':dbName', $this->dbName);
        $stmt->execute();
        $result = $stmt->fetchColumn(0);
        return (int)$result === 0 ? false: true;
    }

    /**
     * データベース新規作成
     */
    private function createNewDatabase(){
        echo 'create database' . PHP_EOL;
        $sql = 'CREATE DATABASE ' . $this->dbName;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    /**
     * データベース削除
     */
    private function dropDatabase(){
        echo 'drop database' . PHP_EOL;
        $sql = 'drop DATABASE ' . $this->dbName;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }
}