<?php
include "../includes/navbar.php";
    $id = $_SESSION['id'];

    $userDataStatement = $database->getConnection()->prepare('SELECT * FROM users WHERE id =? ');
    $userDataStatement->bind_param('i', $id);

    $userData = $database->getData($userDataStatement);

    $userInfoStatement = $database->getConnection()->prepare('SELECT * FROM user_info WHERE userId = ?');
    $userInfoStatement->bind_param('i', $id);

    $userInfo = $database->getData($userInfoStatement);

    $_SESSION['other'] = $userInfo['other'];
    $_SESSION['availability'] = $userInfo['availability'];
    $_SESSION['skills'] = $userInfo['skills'];
    $_SESSION['region'] = $userInfo['region'];
    $_SESSION['name'] = $userData['name'];
    $_SESSION['surname'] = $userData['surname'];
    $_SESSION['username'] = $userData['username'];
    $_SESSION['email'] = $userData['email'];
    $_SESSION['role'] = $userData['role'];
    $_SESSION['address'] = $userData['address'];
    $_SESSION['zipcode'] = $userData['zipcode'];
    $_SESSION['city'] = $userData['city'];
    $_SESSION['phone'] = $userData['phone'];

    //$assignments = $database->getDataAsArray("SELECT * FROM assignments WHERE userId = '$id'");
    $statement = $database->getConnection()->prepare("SELECT * FROM assignments WHERE userId = ?");
    $statement->bind_param('i', $id);
    $assignments = $database->getDataAsArray($statement);

    $currentDate = date('Y-m-d H:i:s');
    foreach ($assignments as $assignment){
        $assignmentAdded = $assignment['time_added'];
        $days = (strtotime($currentDate) - strtotime($assignmentAdded)) / 86400;

        if($days >= 1 && $assignment['stateId'] == 1){
             $time_date = date('Y-m-d H:i:s', strtotime($assignment['time_added']) + 86400);
             $customerId = $assignment['customerId'];

             $customerNameStatement = $database->getConnection()->prepare("SELECT customers.name FROM assignments LEFT JOIN customers ON assignments.customerId = customers.id WHERE customerId = ?");
             $customerNameStatement->bind_param('i', $customerId);

             $getCustomerName = $database->getData($customerNameStatement, 'name');
             $assignmentId = $assignment['id'];
             $messageSubject = 'Concerning assignment #' . $assignment['id'] . ' (' . $assignment['description'] . ')';

             $checkMessageStatement = $database->getConnection()->prepare('SELECT * FROM messages WHERE subject = ?');
             $checkMessageStatement->bind_param('s', $messageSubject);

             if(!$database->check($checkMessageStatement)){
                 $message = 'Customer ' . $customerId . " (". $getCustomerName. ") is already waiting more than 24 hours for your responding";

                 $messageQuery = $database->getConnection()->prepare("INSERT into messages (userId, message, customerId, messageRead, messageTrash, messageDeleted, time_added, subject, assignmentId) 
            VALUES(?, ?, ?, 0, 0, 0, ?, ?, ?)");
                 $messageQuery->bind_param('isissi', $id, $message, $customerId, $time_date, $messageSubject, $assignmentId);
                 $database->executeQuery($messageQuery);
             }
        }

    }

?>
<style>
    .card{
        margin-top: 15px;
        font-size: 14px;
    }
    .table{
        margin-bottom: -20px; !important;
        margin-top: -20px; !important;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Introduction
                </div>
                <div class="card-block">
                    Welcome to SPortal <?php echo $_SESSION['name'];?>! In here you can find your assignments, upcoming salary and more.
                    <br><br>
                    Having trouble understanding how all of this works? Don't worry! There is comprehensive <a href="wiki.php">Wiki</a> which explains a lot about this portal.
                    <br><br>
                    Please read it before asking questions!
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Profile overview
                </div>
                <div class="card-block">

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Salary
                </div>
                <div class="card-block">

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Latest messages
                    <?php
                    $query = $database->getConnection()->prepare('SELECT count(id) FROM messages WHERE messageRead = 0 AND messageTrash = 0 AND userId = ?');
                    $query->bind_param('i', $id);
                    if($database->getData($query)[0] > 0){
                        $messageNumber = $database->getData($query)[0];
                        echo "<span class='badge badge-danger badge-pill pull-right'>$messageNumber</span>";
                    }
                    ?>

                </div>
                <div class="card-block">
                    <table class='table' id="table">
                        <?php

                        $messageStatement = $database->getConnection()->prepare("SELECT * FROM messages WHERE userId=? AND messageDeleted = 0 AND messageTrash = 0 AND messageRead= 0 ORDER BY time_added LIMIT 3");

                        $messageStatement->bind_param('i', $id );

                        $latestMessages= $database->getDataAsArray($messageStatement);

                        if(!$latestMessages){
                            echo "<tr><td colspan='2' style='text-align: center'>No new unread messages</td> </tr>";
                        }
                        foreach($latestMessages as $message){
                            $time_added = $message['time_added'];
                            $number = $message['id'];
                            $subject = $message['subject'];
                            echo "<tr>
                                  <td><a href='showMessage.php?id=$number'>$subject</a></td>
                                  <td>$time_added</td>
                                  </tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Upcoming appointments
                </div>
                <div class="card-block">

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Contact
                </div>
                <div class="card-block">

                </div>
            </div>
        </div>
    </div>

</div>
<script>

</script>