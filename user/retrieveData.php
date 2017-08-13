<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 12-8-2017
 * Time: 20:03
 */
include '../includes/includeDatabase.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $data =  $database->getDataAsArray("SELECT * FROM messages WHERE id=$id");
    echo json_encode($data);
}