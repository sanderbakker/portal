<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 14-8-2017
 * Time: 11:28
 */
include '../includes/navbar.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
}
else{
    header('location: ../404.php');
}
$connection = $database->getConnection();

$query = $database->getConnection()->prepare("UPDATE messages SET messageRead = 1 WHERE id=?");
$query->bind_param('i', $id);
$database->executeQuery($query);


$messageStatement = $database->getConnection()->prepare('SELECT * FROM messages WHERE id=?');
$messageStatement->bind_param('i', $id);

$message = $database->getData($messageStatement);

$assignmentId = $message['assignmentId'];

$assignment = $database->getAssignment($assignmentId, 'id');

$customerId = $message['customerId'];

$customerStatement = $database->getConnection()->prepare('SELECT * FROM customers WHERE id = ?');
$customerStatement->bind_param('i', $customerId);

$customer = $database->getData($customerStatement);

$waitingTime = strtotime(date('Y-m-d H:i:s')) - strtotime($assignment['time_added']);
$time = (round($waitingTime/86400, 1));
if($message['userId'] != $_SESSION['id']){
    header('location: ../404.php');
}
?>
<style>
    h5{
        font-size: 14px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <?php
                        echo 'Message '. $message['id'];
                    ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card-block">
                            <h5><b>Subject</b></h5>
                            <?php echo $message['subject'];?>
                            <hr>
                            <h5><b>Message</b></h5>
                            <?php echo $message['message'];?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-block">
                            <h5><b>Customer info</b></h5>
                            <table class="table">
                                <tr>
                                    <th>Name:</th>
                                    <td><?php echo $customer['name']; ?></td>
                                </tr>
                                <tr>
                                    <th>Surname :</th>
                                    <td><?php echo $customer['surname']; ?></td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td><?php echo $customer['phone']; ?></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>

                                    <td><?php echo $customer['email']; ?></td>
                                </tr>
                                <tr>
                                    <th>Waiting since:</th>
                                    <td id="waitingTime"><?php echo $assignment['time_added'] . ' (' . $time . ' days)'  ;?></td>
                                </tr>
                                <script>
                                    function call(){
                                        location.href='tel:' + '<?php echo $customer['phone'];?>';
                                    }
                                    function mail(){
                                        location.href='mailto:' + '<?php echo $customer['email'];?>';
                                    }
                                    function update(){
                                        location.href='updateAssignment.php?id=<?php echo $assignment['id'];?>';
                                    }
                                    function close(){
                                        location.href='updateAssignment.php?id=<?php echo $assignment['id'];?>';
                                    }
                                </script>
                                <?php
                                $stateId = $assignment['stateId'];
                                $stateStatement = $database->getConnection()->prepare("SELECT code FROM state WHERE id= ?");
                                $stateStatement->bind_param('i', $stateId);

                                $stateCode = $database->getData($stateStatement, 'code');

                                if($stateCode != '500' && $stateCode != '300'){
                                    echo '<tr>
                                    <th>Take action!</th>
                                    <td><button title="Call customer" onclick="call()" class="btn btn-sm btn-success">
                                            <i class="fa fa-phone"></i>
                                        </button>
                                        <button title="Mail customer" onclick="mail()" class="btn btn-sm btn-success margin-button">
                                            <i class="fa fa-envelope"></i>
                                        </button>
                                        <button title="Update state" onclick="update()" class="btn btn-sm btn-success margin-button">
                                            <i class="fa fa-flag"></i>
                                        </button>
                                        <button title="Close assignment" onclick="close()" class="btn btn-sm btn-danger margin-button">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>';
                                }
                                ?>



                            </table>
                        </div>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>

    <script>
        var time = "<?php echo $time?>";
        if(time > 1 && time < 3){
            console.log('ff4500');
            $("#waitingTime").css("color", "#ffa500");
        }
        else if(time > 3 && time < 5){
            $("#waitingTime").css("color", "#ff0000");
        }
        else if(time > 5){
            $("#waitingTime").css("color", "#8b0000");
        }
    </script>
    <style>
        .margin-button{
            margin-left: 15px;
        }
    </style>
