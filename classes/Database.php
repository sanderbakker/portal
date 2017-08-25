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
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword, 'portal');
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
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword, 'portal');
        return $this->connection;
    }

    public function executeQuery($preparedQuery){
        if(!$this->connection){
            return false;
        }
        else{
            $preparedQuery->execute();
            $this->connection->close();
            return true;
        }

    }

    public function getId($username){
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword, 'portal');
        $id = mysqli_fetch_all(mysqli_query($this->connection, "SELECT id FROM users WHERE username='$username'"));
        $this->connection->close();
        return $id[0][0];
    }

    public function getData($preparedQuery, $name = null){
        $preparedQuery->execute();
        $data = $preparedQuery->get_result()->fetch_array();
        if($name != null) {
            return $data[$name];
        }
        else{
            return $data;
        }
    }

    public function check($preparedQuery){
        $preparedQuery->execute();
        $preparedQuery->store_result();
        if($preparedQuery->num_rows != 0){
            $this->connection->close();
            return true;
        }

        else
        {
            $this->connection->close();
            return false;
        }
    }

    public function getDataAsArray($preparedQuery){
        $preparedQuery->execute();
        $result = $preparedQuery->get_result();
        $results = array();
        while($line = $result->fetch_array()){
            $results[] = $line;
        }
        return $results;
    }

    public function encryptSSL($data){
        $encryptionMethod = "AES-256-CBC";
        $secretHash = "25c6c7ff35b9979b151f2136cd13b0ff";
        $encryptedMessage = openssl_encrypt($data, $encryptionMethod, $secretHash, 0, $this->iv);
        return $encryptedMessage . '||' . $this->iv;
    }
    public function decryptSSL($data, $iv){
        $encryptionMethod = "AES-256-CBC";
        $secretHash = "25c6c7ff35b9979b151f2136cd13b0ff";
        $decryptedMessage = openssl_decrypt($data, $encryptionMethod, $secretHash, 0,  $iv);
        return $decryptedMessage;
    }
    public function getCustomer($id, $attribute){
        $statement = $this->connection->prepare("SELECT * FROM customers WHERE $attribute = ?");
        $statement->bind_param('i', $id);
        return $this->getData($statement);

    }
    public function getAssignment($id, $attribute){
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword, 'portal');
        $statement = $this->connection->prepare("SELECT * FROM assignments WHERE $attribute = ?");
        $statement->bind_param('i', $id);
        return $this->getData($statement);
    }

    public function getState($id, $attribute){
        $statement = $this->connection->prepare("SELECT * FROM state WHERE $attribute = ?");
        $statement->bind_param('i', $id);
        return $this->getData($statement);
    }
    public function getUserById($id){
        $statement = $this->getConnection()->prepare("SELECT * FROM users WHERE id = ?");
        $statement->bind_param('i', $id);
        return $this->getData($statement);
    }
    public function getUserInfoById($id){
        $statement = $this->getConnection()->prepare("SELECT * FROM user_info WHERE userId =?");
        $statement->bind_param('i', $id);
        return $this->getData($statement);
    }
}
