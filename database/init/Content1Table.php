<?php
/**
 * Created by PhpStorm.
 * User: masaki
 * Date: 2018/09/26
 * Time: 15:40
 */

namespace database\init;


class Content1Table extends BaseTable
{

    private $con;
    private const tableName = 'content1';
    private const createTableSql =
        "create table if not exists ".self::tableName."(" .
        "id serial NOT NULL,".
        "value text,".
        "account_id integer,".
        "CONSTRAINT content_id_prime_key PRIMARY KEY (id),".
        "CONSTRAINT content_account_id_foreign_key FOREIGN KEY (account_id)".
        "REFERENCES public.account (id) MATCH SIMPLE ".
        "ON UPDATE NO ACTION ON DELETE NO ACTION".
        ") ";

    public function __construct(\PDO $con)
    {
        parent::__construct($con, self::tableName, self::createTableSql);
        $this->con = $con;
    }

    public function insertData($data)
    {
        echo 'insert data' . PHP_EOL;

        $sql = 'insert into '.self::tableName.' (title, value, account_id) values(:title, :value, :account_id)';
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':value', $data['value']);
        $stmt->bindParam(':account_id', $data['account_id']);
        $stmt->execute();
    }

}