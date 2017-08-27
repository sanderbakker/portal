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
        case 'messageData':
            messageData($database, $id);
            break;
        default:
            break;
    }
}

function removeAll($db, $id){
    /* @var $db Database */
    $preparedQuery = $db->getConnection()->prepare("UPDATE messages SET messageDeleted = 1 WHERE userId = ? AND messageTrash = 1");
    $preparedQuery->bind_param('i', $id);
    $db->executeQuery( $preparedQuery);
}
function readAll($db, $id){
    /* @var $db Database */
    $preparedQuery = $db->getConnection()->prepare("UPDATE messages SET messageRead = 1 WHERE userId = ?");
    $preparedQuery->bind_param('i', $id);
    $db->executeQuery($preparedQuery);
}
function unreadAll($db, $id){
    /* @var $db Database */
    $preparedQuery = $db->getConnection()->prepare("UPDATE messages SET messageRead = 0 WHERE userId = ?");
    $preparedQuery->bind_param('i', $id);
    $db->executeQuery($preparedQuery);
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
    $closeRequestQuery = $db->getConnection()->prepare("UPDATE closerequests SET accepted = 1 WHERE assignmentId = ?");
    $closeRequestQuery->bind_param('i', $id);
    $assignmentQuery = $db->getConnection()->prepare("UPDATE assignments SET closed = 1, stateId = 8 WHERE id= ?");
    $assignmentQuery->bind_param('i', $id);

    $db->executeQuery($assignmentQuery);
    $db->executeQuery($closeRequestQuery);


    $assignment = $db->getAssignment($id, 'id');
    $user = $assignment['userId'];
    $customer = $assignment['customerId'];
    $assignmentId = $assignment['id'];
    $assignmentName = $assignment['description'];

    $currentDate = date('Y-m-d H:i:s');

    $subject = 'Close request for assignment #' . $assignmentId . ' has been accepted';
    $message = 'The close request for assignment #' . $assignmentId . ' ('. $assignmentName. ') is accepted. 
                Please do not pay any attention to this assignment anymore';

    $createMessage = $db->getConnection()->prepare("INSERT INTO messages (userId, message, customerId, messageRead, messageTrash, messageDeleted, time_added, subject, assignmentId) 
                        VALUES(?, ?, ?, 0, 0, 0, ?, ?, ?)");
    $createMessage->bind_param('isissi', $user, $message, $customer, $currentDate, $subject, $assignmentId);
    $db->executeQuery($createMessage);

}
function reject($db, $id){
    /* @var $db Database */

    $closeRequestQuery = $db->getConnection()->prepare("UPDATE closerequests SET accepted = 0 WHERE assignmentId = ?");
    $closeRequestQuery->bind_param('i', $id);

    $assignmentQuery = $db->getConnection()->prepare("UPDATE assignments SET appointment = null, requestClose = null, stateId = 1 WHERE id= ?");
    $assignmentQuery->bind_param('i', $id);

    //First this one
    $db->executeQuery($assignmentQuery);
    //Then this one otherwise it won't work
    $db->executeQuery($closeRequestQuery);


    $assignment = $db->getAssignment($id, 'id');
    $user = $assignment['userId'];
    $customer = $assignment['customerId'];
    $assignmentId = $assignment['id'];
    $assignmentName = $assignment['description'];

    $currentDate = date('Y-m-d H:i:s');

    $subject = 'Close request for assignment #' . $assignmentId . ' has been rejected';
    $message = 'The close request for assignment #' . $assignmentId . ' ('. $assignmentName. ') is rejected. 
                Try to get in contact with the customer to make an appointment';

    $createMessage = $db->getConnection()->prepare("INSERT INTO messages (userId, message, customerId, messageRead, messageTrash, messageDeleted, time_added, subject, assignmentId) 
                        VALUES(?, ?, ?, 0, 0, 0, ?, ?, ?)");
    $createMessage->bind_param('isissi', $user, $message, $customer, $currentDate, $subject, $assignmentId);
    $db->executeQuery($createMessage);
}

function messageData($db, $id){
    $statement = $db->getConnection()->prepare("SELECT * FROM messages WHERE id=?");
    $statement->bind_param('i', $id);
    $data =  $db->getDataAsArray($statement);
    echo json_encode($data);
}