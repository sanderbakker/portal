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
        $this->connection = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword);
    }
    public function createDatabase($dbName){
        if(!$this->connection){
            var_dump("Connection failed");
        }
        else {
            mysqli_query($this->connection, "CREATE DATABASE IF NOT EXISTS " . $dbName);
        }
    }
    public function createTable($query){
        if(!$this->connection){
            var_dump("Connection failed");
        }
        else {
            mysqli_query($this->connection, $query);
        }
    }
    public function getConnection(){
        return $this->connection;
    }
}