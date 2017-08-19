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
        case 'retrieveData':
            retrieveData($database, $id);
            break;
        case 'accept':
            accept($database, $id);
            break;
        case 'reject':
            reject($database, $id);
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
function retrieveData($db, $id){
    /* @var $db Database */
    $data = $db->getDataAsArray("SELECT  count(closerequests.id) as requests, closerequests.reason, users.surname, users.name, assignments.description, assignments.id FROM closerequests LEFT JOIN assignments ON assignments.id = closerequests.assignmentId 
                                                                     LEFT JOIN users ON assignments.userId = users.id  
WHERE closerequests.assignmentId = '$id' and closerequests.accepted IS NULL");
    echo json_encode($data);
}

function accept($db, $id){
    /* @var $db Database */
    $db->executeQuery('portal', "UPDATE closerequests SET accepted = 1 WHERE assignmentId = '$id'");
    $db->executeQuery('portal', "UPDATE assignments SET closed = 1, stateId = 8 WHERE id='$id'");
}
function reject($db, $id){
    /* @var $db Database */
    $db->executeQuery('portal', "UPDATE closerequests SET accepted = 0 WHERE assignmentId = '$id'");
    $db->executeQuery('portal', "UPDATE assignments SET requestClose = null, stateId = 1 WHERE id='$id'");

}