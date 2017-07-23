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
    public function __construct($host, $dbUsername, $dbPassword)
    {
        $this->dbPassword = $dbPassword;
        $this->dbUsername = $dbUsername;
        $this->host = $host;

    }
    public function createDatabase($dbName){
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword);
        if(!$this->connection){
            var_dump("Connection failed");
        }
        else {
            mysqli_query($this->connection, "CREATE DATABASE IF NOT EXISTS " . $dbName);
        }
        $this->connection->close();
    }
    public function createTable($query, $dbName){
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword, $dbName);
        if(!$this->connection){
            var_dump("Connection failed");
        }
        else {
            $this->connection->query($query);
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
            $this->connection->query($query);
            $this->connection->close();
            return true;
        }

    }
    public function checkUsername($username){
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword, "portal");;
        $query = mysqli_query($this->connection, "SELECT username FROM Users WHERE username='$username'");

        if (mysqli_num_rows($query) != 0)
        {
            $this->connection->close();
           return true;
        }

        else
        {
            $this->connection->close();
            return false;
        }
    }
    public function login($username, $password){
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword, 'portal');
        $query = mysqli_query($this->connection, "SELECT * FROM users WHERE password='$password' AND username='$username'");
        if(mysqli_num_rows($query) != 0){
            $this->connection->close();
            return true;
        }
        else{
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
        $userData = mysqli_fetch_all(mysqli_query($this->connection, "SELECTE * FROM users WHERE id='$id'"));
        return $userData;
    }

}
