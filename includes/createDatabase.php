<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 5-8-2017
 * Time: 14:14
 */

include 'classes/Database.php';

$database = new Database("localhost", "root", "" , openssl_random_pseudo_bytes(16));

//Creates a database called portal if this doesn't exists
$database->createDatabase("portal");
//Create table in database
$database->createTable("CREATE TABLE Users (
                                  id INT(6) AUTO_INCREMENT PRIMARY KEY, 
                                  name VARCHAR(30) NOT NULL,
                                  surname VARCHAR(30) NOT NULL,
                                  password VARCHAR(255) NOT NULL, 
                                  username VARCHAR(30) NOT NULL, 
                                  phone VARCHAR(255) NOT NULL, 
                                  email VARCHAR(50) NOT NULL,
                                  role VARCHAR(50) NOT NULL,
                                  address VARCHAR(50) NOT NULL, 
                                  zipcode VARCHAR (50) NOT NULL,
                                  city VARCHAR (50) NOT NULL, 
                                  approved BOOLEAN NOT NULL, 
                                  reg_date TIMESTAMP,
                                  banned BOOLEAN
                                  )", "portal");

$database->createTable("CREATE TABLE user_info (
                                  id int(6) AUTO_INCREMENT NOT NULL,
                                  userId int(6) NOT NULL,
                                  availability int(2), 
                                  skills varchar(255), 
                                  region varchar(255),
                                  other varchar(255), 
                                  PRIMARY KEY (id),
                                  FOREIGN KEY (userId) REFERENCES users(id)
                                  );", "portal");

$database->createTable("CREATE TABLE customers (
                                    id int(6)  AUTO_INCREMENT PRIMARY KEY NOT NULL,
                                    name varchar(255) NOT NULL,
                                    surname varchar(255) NOT NULL,
                                    zipcode varchar(255) NOT NULL,
                                    city varchar(255) NOT NULL,
                                    address varchar(255) NOT NULL,
                                    phone varchar(255) NOT NULL, 
                                    company varchar(255),
                                    reg_date TIMESTAMP,
                                    email varchar(255) NOT NULL);", 'portal');

$database->createTable("create table state ( id int(6) AUTO_INCREMENT NOT NULL PRIMARY KEY, name varchar(255), code int(3) )", 'portal');

$database->createTable("CREATE table assignments (
    id int(6)  AUTO_INCREMENT PRIMARY KEY,
    userId int(6), 
    customerId int(6) NOT NULL,
    description varchar(255),
    time_added timestamp, 
	stateId int(6) NOT NULL, 
    completed boolean NOT NULL,
    closed boolean NOT NULL, 
    requestClose int(6),
    FOREIGN KEY (requestClose) REFERENCES assignments(id), 
    FOREIGN KEY (userId) REFERENCES users(id),
    FOREIGN KEY (stateId) REFERENCES state(id),
    FOREIGN KEY (customerId) REFERENCES customers(id)
	)", 'portal');

$database->createTable("CREATE TABLE messages (
	id int(6) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    userId int(6) NOT NULL,
    assignmentId int(6),
    message varchar(255) NOT NULL,
    customerId int(6),
    messageRead boolean,
    messageTrash boolean,
    messageDeleted boolean, 
    subject varchar(255) NOT NULL, 
    time_added TIMESTAMP,
    FOREIGN KEY (assignmentId) REFERENCES assignments(id), 
    FOREIGN KEY (userId) REFERENCES users(id),
    FOREIGN KEY (customerId) REFERENCES customers(id)
);", 'portal');

$database->createTable("CREATE TABLE closeRequests 
	(
        id int (6) AUTO_INCREMENT PRIMARY KEY,
        assignmentId int(6) NOT NULL, 
       	reason varchar(255) NOT NULL,
        accepted boolean, 
    	FOREIGN KEY (assignmentId) REFERENCES assignments(id)
    )", 'portal');