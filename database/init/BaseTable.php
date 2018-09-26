<?php
/**
 * Created by PhpStorm.
 * User: masaki
 * Date: 2018/09/26
 * Time: 14:58
 */

namespace database\init;

abstract class BaseTable
{

    private $tableName;
    private $createTableSql;
    private $con;


    public function __construct(\PDO $con, $tableName, $createTableSql)
    {
        $this->con = $con;
        $this->tableName = $tableName;
        $this->createTableSql = $createTableSql;
    }

    /**
     * テーブルが有るか
     * @return bool
     */
    private function isTableExist()
    {
        $sql = "select count(*) from pg_class where relkind = 'r' and relname = :tableName";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue("tableName", $this->tableName, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn(0) === 0 ? false: true;
    }

    public function createTable(){

        if (!$this->isTableExist()) {
            echo 'create new table '.$this->tableName.PHP_EOL;
            $stmt = $this->con->prepare($this->createTableSql);
            var_dump($stmt->queryString);
            $stmt->execute();
        }
    }

    abstract public function insertData($dates);

    public function deleteTable()
    {
        if ($this->isTableExist()) {
            echo 'delete table '.$this->tableName.PHP_EOL;
            $sql = "drop table ". $this->tableName;
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
        }
    }
}