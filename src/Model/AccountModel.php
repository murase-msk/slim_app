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

//    public function getData()
//    {
//        $sql = 'select * from new_table';
//        $stmt = $this->con->prepare($sql);
//        $stmt->execute(array());
//        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
//        return $result;
//
//    }



    /**
     * アカウントを登録する
     * @param $email
     * @param $account
     * @param $password
     */
    public function insertAccountData($email, $account, $password)
    {
        // パスワードハッシュ化.
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);

        $sql = 'insert into account (name, email, password) values(:name, :email, :password)';
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':name', $account);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPass);
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
        $result = $stmt->fetchColumn(0);
        return (int)$result === 0 ? false: true;
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

    /**
     * アカウント認証できるか
     * @param $account
     * @param $password
     * @return bool
     */
    public function isAuthAccount($account, $password)
    {
        $sql = 'select name, password from account where name = :account ';
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':account', $account);
//        $stmt->bindParam(':password', $password);
        $stmt->execute();
        //return $stmt->fetchColumn(0) === 0 ? false: true;
        $hashedPassword = $stmt->fetch()['password'];
        return password_verify($password, $hashedPassword);
    }

    /**
     * アカウント削除
     * @param $account
     * @param $password
     */
    public function deleteAccount($account, $password)
    {
        if($this->isAuthAccount($account, $password)){
            $sql = 'delete from account where name = :account';
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':account', $account);
            $stmt->execute();
        }
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