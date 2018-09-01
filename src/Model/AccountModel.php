<?php
/**
 * Created by PhpStorm.
 * User: masaki
 * Date: 2018/08/14
 * Time: 16:21
 */

namespace src\Model;


class AccountModel
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

    public function getData()
    {
        $sql = 'select * from new_table';
        $stmt = $this->con->prepare($sql);
        $stmt->execute(array());
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;

    }

    /**
     * アカウントを登録する
     *
     * @param [type] $data
     * @return void
     */
    public function insertAccountData($data)
    {
        $sql = 'insert into account (name, email, password) values(:name, :email, :password)';
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':name', $data['account']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->execute();
    }

    /**
     * 登録済みのメールアドレスであるか
     *
     * @param [type] $email
     * @return boolean
     */
    public function isSameEmail($email){
        $sql = 'select count(*) from account where email = :email';
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn(0) === 0 ? false: true;
    }

    /**
     * 登録済みのアカウント名であるか
     *
     * @param [type] $account
     * @return boolean
     */
    public function isSameAccount($account){
        $sql = 'select count(*) from account where name = :account';
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':account', $account);
        $stmt->execute();
        return $stmt->fetchColumn(0) === 0 ? false: true;
    }

    // /**
    //  * すべてのアカウント情報を取得する
    //  *
    //  * @return void
    //  */
    // public function getAccountData()
    // {
    //     $sql = 'select name, email from account';
    //     $stmt = $this->con->prepare($sql);
    //     $stmt->execute();
    //     $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    //     return $result;
    // }
}