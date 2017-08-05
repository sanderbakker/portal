<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 30-7-2017
 * Time: 07:58
 */
include '../classes/Database.php';

$database = new Database("localhost", "root", "" , openssl_random_pseudo_bytes(16));

