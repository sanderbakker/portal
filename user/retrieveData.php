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
    $statement = $database->getConnection()->prepare("SELECT * FROM messages WHERE id=?");
    $statement->bind_param('i', $id);
    $data =  $database->getDataAsArray($statement);
    echo json_encode($data);
}