<?php
/**
 * Created by PhpStorm.
 * User: masaki
 * Date: 2018/07/29
 * Time: 16:17
 */

namespace src\Model;


class SampleModel
{
    private $con;

    /**
     * SampleModel constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->con = $pdo;
    }

    public function getData(){
        $sql = 'select * from new_table';
        $stmt = $this->con->prepare($sql);
        $stmt->execute(array());
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;

    }

}