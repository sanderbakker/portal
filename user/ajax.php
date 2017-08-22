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
    $statement = $db->getConnection()->prepare("SELECT  count(closerequests.id) as requests, closerequests.reason, users.surname, users.name, assignments.description, assignments.id FROM closerequests LEFT JOIN assignments ON assignments.id = closerequests.assignmentId 
                                                                     LEFT JOIN users ON assignments.userId = users.id  
WHERE closerequests.assignmentId = ? and closerequests.accepted IS NULL");
    $statement->bind_param('i', $id);
    $data = $db->getDataAsArray($statement);
    echo json_encode($data);
}

function accept($db, $id){
    /* @var $db Database */
    $db->executeQuery('portal', "UPDATE closerequests SET accepted = 1 WHERE assignmentId = '$id'");
    $db->executeQuery('portal', "UPDATE assignments SET closed = 1, stateId = 8 WHERE id='$id'");

    $assignment = $db->getData("SELECT * FROM assignments WHERE id=$id");
    $user = $assignment['userId'];
    $customer = $assignment['customerId'];
    $assignmentId = $assignment['id'];
    $assignmentName = $assignment['description'];

    $currentDate = date('Y-m-d H:i:s');

    $subject = 'Close request for assignment #' . $assignmentId . ' has been accepted';
    $message = 'The close request for assignment #' . $assignmentId . ' ('. $assignmentName. ') is accepted. 
                Please do not pay any attention to this assignment anymore';

    $db->executeQuery('portal', "INSERT INTO messages (userId, message, customerId, messageRead, messageTrash, messageDeleted, time_added, subject, assignmentId) VALUES(
                                                            '$user', '$message', '$customer', 0, 0, 0, '$currentDate', '$subject', '$assignmentId')");

}
function reject($db, $id){
    /* @var $db Database */
    $db->executeQuery('portal', "UPDATE closerequests SET accepted = 0 WHERE assignmentId = '$id'");
    $db->executeQuery('portal', "UPDATE assignments SET requestClose = null, stateId = 1 WHERE id='$id'");

    $assignment = $db->getData("SELECT * FROM assignments WHERE id=$id");
    $user = $assignment['userId'];
    $customer = $assignment['customerId'];
    $assignmentId = $assignment['id'];
    $assignmentName = $assignment['description'];

    $currentDate = date('Y-m-d H:i:s');

    $subject = 'Close request for assignment #' . $assignmentId . ' has been rejected';
    $message = 'The close request for assignment #' . $assignmentId . ' ('. $assignmentName. ') is rejected. 
                Try to get in contact with the customer to make an appointment';

    $db->executeQuery('portal', "INSERT INTO messages (userId, message, customerId, messageRead, messageTrash, messageDeleted, time_added, subject, assignmentId) VALUES(
                                                            '$user', '$message', '$customer', 0, 0, 0, '$currentDate', '$subject', '$assignmentId')");

}