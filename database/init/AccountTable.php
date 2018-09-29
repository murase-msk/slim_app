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
    // カラム名.
    public const ID = 'id';
    public const ACCOUNT_NAME = 'account_name';
    public const EMAIL = 'email';
    public const HASHED_PASSWORD = 'hashed_password';
    /** @var string tableName テーブル名 */
    public const tableName = 'account';

    /** @var \PDO $con データベースコネクション */
    private $con;
    /** @var string createTableSql  */
    private const createTableSql =
        "create table if not exists ".self::tableName."("
        .self::ID." serial NOT NULL, "
        .self::ACCOUNT_NAME." text NOT NULL, "
        .self::EMAIL." text, "
        .self::HASHED_PASSWORD." text, "
        ."CONSTRAINT account_id_primary_key PRIMARY KEY (".self::ID."), "
        ."CONSTRAINT account_email_unique UNIQUE (".self::EMAIL."), "
        ."CONSTRAINT account_name_unique UNIQUE (".self::ACCOUNT_NAME.")"
        .") ";

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

        $sql = 'insert into '.self::tableName
            .' ('
            .self::ACCOUNT_NAME.', '
            .self::EMAIL.', '
            .self::HASHED_PASSWORD
            .') '
            .'values(:account_name, :email, :hashed_password)';
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':account_name', $data['account']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':hashed_password', $hashedPass);
        $stmt->execute();
    }
}