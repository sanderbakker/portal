<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 24-7-2017
 * Time: 21:46
 */
include "includes.php";
include "navbar.php";
$edit = $_GET['edit'];

switch ($edit){
    case 'name':
        echo $edit;
        break;
    case 'surname':
        echo "surname";
        break;
    case 'email':
        echo "email";
        break;
    case 'username':
        echo 'username';
        break;
    case 'address':
        echo 'address';
        break;
    case 'zipcode':
        echo 'zipcode';
        break;
    case 'city':
        echo 'city';
        break;
    default: {
        echo "404";
    }
}