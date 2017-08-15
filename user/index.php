<?php
include "../includes/navbar.php";
    $id = $_SESSION['id'];
    $userData = $database->getData("SELECT * FROM users WHERE id='$id'");
    $userInfo = $database->getData("SELECT * FROM user_info WHERE userId='$id'");
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

    $assignments = $database->getDataAsArray("SELECT * FROM assignments WHERE userId = '$id'");
    $currentDate = date('Y-m-d H:i:s');
    foreach ($assignments as $assignment){
        $assignmentAdded = $assignment['time_added'];
        $days = (strtotime($currentDate) - strtotime($assignmentAdded)) / 86400;

        if($days >= 1 && $assignment['stateId'] == 1){
             $time_date = date('Y-m-d H:i:s', strtotime($assignment['time_added']) + 86400);
             $customerId = $assignment['customerId'];
             $getCustomerName = $database->getData("SELECT customers.name FROM assignments LEFT JOIN customers ON assignments.customerId = customers.id WHERE customerId = $customerId")['name'];
             $assignmentId = $assignment['id'];
             $messageSubject = 'Concerning assignment #' . $assignment['id'] . ' (' . $assignment['description'] . ')';
             if(!$database->check("SELECT * FROM messages WHERE subject='$messageSubject'")){
                 $message = 'Customer ' . $customerId . " (". $getCustomerName. ") is already waiting more than 24 hours for your responding";
                 $database->executeQuery('portal', "INSERT into messages (userId, message, customerId, messageRead, messageTrash, messageDeleted, time_added, subject, assignmentId) VALUES(
                                                            '$id', '$message', '$customerId', 0, 0, 0, '$time_date', '$messageSubject', '$assignmentId')");
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
                </div>
                <div class="card-block">
                    <table class='table' id="table">
                        <?php
                        $latestMessages= $database->getDataAsArray("SELECT * FROM messages WHERE userId='$id' AND messageDeleted = 0 AND messageTrash = 0 AND messageRead= 0 ORDER BY time_added LIMIT 3");
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