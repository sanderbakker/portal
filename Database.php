<?php

/**
 * Created by PhpStorm.
 * User: sande
 * Date: 22-7-2017
 * Time: 10:54
 */
class Database
{
    private $host;
    private $dbUsername;
    private $dbPassword;
    private $connection;
    private $iv;
    public function __construct($host, $dbUsername, $dbPassword, $iv)
    {
        $this->dbPassword = $dbPassword;
        $this->dbUsername = $dbUsername;
        $this->host = $host;
        $this->iv = $iv;

    }

    public function createDatabase($dbName){
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword);
        $query = "CREATE DATABASE IF NOT EXISTS $dbName";
        if(!$this->connection){
            var_dump("Connection failed");
        }
        else {
            $this->connection->prepare($query)->execute();
        }
        $this->connection->close();
    }
    public function createTable($query, $dbName){
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword, $dbName);
        if(!$this->connection){
            var_dump("Connection failed");
        }
        else {
            $this->connection->prepare($query)->execute();
        }
        $this->connection->close();
    }
    public function getConnection(){
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword);
        return $this->connection;
    }

    public function insertInTable($dbname, $query){
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword, $dbname);
        if(!$this->connection){
            var_dump("Connection failed");
            return false;
        }
        else{
            $this->connection->prepare($query)->execute();
            $this->connection->close();
            return true;
        }

    }
    public function check($query){
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword, "portal");;
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $statement->store_result();
        if($statement->num_rows != 0){
            $this->connection->close();
            return true;
        }

        else
        {
            $this->connection->close();
            return false;
        }
    }
    public function getId($username){
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword, 'portal');
        $id = mysqli_fetch_all(mysqli_query($this->connection, "SELECT id FROM users WHERE username='$username'"));
        $this->connection->close();
        return $id[0][0];
    }
    public function getUserById($id){
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword, 'portal');
        $userData = mysqli_fetch_array(mysqli_query($this->connection, "SELECT * FROM users WHERE id='$id'"));
        return $userData;
    }
    public function getUserInfoById($id){
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword, 'portal');
        $userInfo = mysqli_fetch_array(mysqli_query($this->connection, "SELECT * FROM user_info WHERE userId='$id'"));
        return $userInfo;
    }
    public function getUsers($myQuery){
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword, 'portal');
        $query = mysqli_query($this->connection, $myQuery);
        $results = array();
        while($line = mysqli_fetch_array($query)){
            $results[] = $line;
        }
        return $results;
    }

    public function getUsersLastWeek($query){
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword, 'portal');
        $users = mysqli_fetch_array(mysqli_query($this->connection, $query));
        return $users;
    }
    public function encryptSSL($data){
        $encryptionMethod = "AES-256-CBC";
        $secretHash = "25c6c7ff35b9979b151f2136cd13b0ff";
        $encryptedMessage = openssl_encrypt($data, $encryptionMethod, $secretHash, 0, $this->iv);
        return $encryptedMessage . ':' . $this->iv;
    }
    public function decryptSSL($data, $iv){
        $encryptionMethod = "AES-256-CBC";
        $secretHash = "25c6c7ff35b9979b151f2136cd13b0ff";
        $decryptedMessage = openssl_decrypt($data, $encryptionMethod, $secretHash, 0,  $iv);
        return $decryptedMessage;
    }
    public function getPassword($query){
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword, 'portal');
        $password = mysqli_fetch_array(mysqli_query($this->connection, $query));
        return $password['password'];
    }

}
