<?php
/**
 * Created by PhpStorm.
 * User: masaki
 * Date: 2018/09/23
 * Time: 13:24
 */

namespace database\init;

/**
 * Class AccountTable
 * @property \PDO $con
 */
class AccountTable extends BaseTable
{

//    private const ID = 'id';
//    private const ACCOUNT_NAME = 'account_name';
//    private const EMAIL = 'email';
//    private const HASHED_PASSWORD = 'hashed_password';

    /** @var \PDO $con データベースコネクション */
    private $con;
    /** @var string tableName テーブル名 */
    private const tableName = 'account';
    /** @var string createTableSql  */
    private const createTableSql =
        "create table if not exists ".self::tableName."(" .
        "id serial NOT NULL, " .
        "account_name text NOT NULL, " .
        "email text, " .
        "hashed_password text, " .
        "CONSTRAINT account_id_primary_key PRIMARY KEY (id), " .
        "CONSTRAINT account_email_unique UNIQUE (email), " .
        "CONSTRAINT account_name_unique UNIQUE (account_name)" .
        ") ";

    public function __construct(\PDO $con)
    {
        parent::__construct($con, self::tableName, self::createTableSql);
        $this->con = $con;
    }

    /**
     * データ挿入
     * @param $data
     */
    public function insertData($data)
    {
        echo 'insert data' . PHP_EOL;
        // パスワードハッシュ化.
        $hashedPass = password_hash($data['password'], PASSWORD_DEFAULT);

        $sql = 'insert into '.self::tableName.' (account_name, email, hashed_password) values(:account_name, :email, :hashed_password)';
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':account_name', $data['account']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':hashed_password', $hashedPass);
        $stmt->execute();
    }
}