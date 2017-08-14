<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 14-8-2017
 * Time: 09:41
 */
require_once '../includes/includeDatabase.php';

if(isset($_POST['action'])){
    $id = $_POST['id'];
    switch($_POST['action']){
        case 'removeAll':
            removeAll($database, $id);
            break;
        case 'readAll':
            readAll($database, $id);
            break;
        case 'unreadAll':
            unreadAll($database, $id);
            break;
        default:
            break;
    }
}

function removeAll($db, $id){
    /* @var $db Database */
    $db->executeQuery('portal', "UPDATE messages SET messageDeleted = 1 WHERE userId = $id AND messageTrash = 1");
}
function readAll($db, $id){
    /* @var $db Database */
    $db->executeQuery('portal', "UPDATE messages SET messageRead = 1 WHERE userId = '$id'");
}
function unreadAll($db, $id){
    /* @var $db Database */
    $db->executeQuery('portal', "UPDATE messages SET messageRead = 0 WHERE userId = '$id'");
}