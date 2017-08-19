<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 16-8-2017
 * Time: 20:54
 */
include '../includes/navbar.php';
include '../classes/AlertBuilder.php';
if(isset($_GET['id']) && $_GET['id'] != ''){
    $id = mysqli_real_escape_string($database->getConnection(), $_GET['id']);
    $userId = mysqli_real_escape_string($database->getConnection(), $_SESSION['id']);
    $assignment = $database->getData("SELECT * FROM assignments WHERE id=$id");
    $customerId = $assignment['customerId'];
    $customerInfo = $database->getData("SELECT * FROM customers WHERE id='$customerId'");

    if(!$database->check("SELECT * FROM assignments WHERE userId ='$userId' AND customerId= $customerId")){
        header('location: ../404.php');
    }

}
else{
    $assignment = null;
    header('location: ../404.php');
}
$alertBuilder = new AlertBuilder();
if(isset($_POST['requestClosing'])){
    if($_POST['reason'] != null){
        if($assignment['requestClose'] == null){
            $assignmentId = $assignment['id'];
            $reason = $_POST['reason'];
            $database->executeQuery('portal', "INSERT into closerequests (assignmentId, reason, accepted) VALUES ('$assignmentId' , '$reason', NULL)");

            $closeState = $database->getData('SELECT * FROM state WHERE code=300')['id'];

            $requestClose = $database->getData("SELECT * FROM closerequests WHERE assignmentId = $assignmentId")['id'];

            $database->executeQuery('portal', "UPDATE assignments SET stateId = $closeState, requestClose = $requestClose WHERE id=$assignmentId");
            echo $alertBuilder->createAlert('Added close request', 'success');
        }
        else{
            echo $alertBuilder->createAlert("Closing request already exists", 'danger');
        }
    }
    else{
        echo $alertBuilder->createAlert('Reason can not be empty', 'danger');
    }
}


?>

<style>
    .form-control{
        font-size: 14px !important;
    }
</style>
<div class="container">
    <div class="card">
        <div class="card-header">
            Close assignment
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-md-6">
                    <h5>Closing a assignment</h5>
                    <p>Before closing this assignment ask your self the following questions (in case of a not responding customer):</p>
                    <ul>
                        <li>Did you call and email <?php echo $customerInfo['name'] . ' ' . $customerInfo['surname'] . '?';?></li>
                        <li>Did you check your spambox for any responses of the customer?</li>
                        <li>Have you try numerous times to get contact with the customer?</li>
                    </ul>
                    <p>Reasons to close a assignment:</p>
                    <ul>
                        <li>Customer didn't response on email or phone calls</li>
                        <li>Customer already solved the problem by it self</li>
                        <li>Customer is going to solve the problem by it self</li>
                        <li>Other reasons, please give a detailed description on why you want to close this assignment</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5>Concerning assignment #<?php echo $_GET['id'];?></h5>
                    <form action='' method='post'>
                        <fieldset>
                            <div class='form-group'>
                                <label>Customer:</label>
                                <input class='form-control' placeholder='' name='customer' type='text' readonly value='<?php echo $customerInfo['name'] . ' ' . $customerInfo['surname'];?>'>
                            </div>
                            <div class='form-group'>
                                <label>Assignment:</label>
                                <input class='form-control' placeholder='' name='assignment' type='text' readonly value='<?php echo $assignment['description'];?>'>
                            </div>
                            <div class='form-group'>
                                <label>Reason:</label>
                                <textarea class='form-control' rows='2'  placeholder='Give a specific reason why this assignment should be closed' name='reason'></textarea>
                            </div>
                            <input class='btn btn-info btn-sm' name='requestClosing' type='submit' value='Request closing'>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
