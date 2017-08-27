<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 25-8-2017
 * Time: 15:09
 */
include '../includes/navbar.php';
include '../classes/AlertBuilder.php';
if(isset($_GET['id']) && $_GET['id'] != ''){
    $id = $_GET['id'];
    $userId = $_SESSION['id'];
    $assignment = $database->getAssignment($id, 'id');

    $customerId = $assignment['customerId'];
    $customerInfo = $database->getCustomer($customerId, 'id');

    $checkUserAssignment = $database->getConnection()->prepare("SELECT * FROM assignments WHERE userId = ? AND customerId = ?");
    $checkUserAssignment->bind_param('ii', $userId, $customerId);

    $currentState = $database->getState($assignment['stateId'],'id' );

    if(!$database->check($checkUserAssignment)){
        header('location: ../404.php');
    }
}
else{
    $customerInfo = null;
    $assignment = null;
    header('location: ../404.php');
}

$allStatesQuery = $database->getConnection()->prepare('SELECT * FROM state WHERE code > 99 AND code < 200');

$allStates = $database->getDataAsArray($allStatesQuery);
$date = date('Y-m-d H:i:s');
$alertBuilder = new AlertBuilder();
if(isset($_POST['assignmentUpdate'])){
    if($_POST['selectValue'] != '') {
            $state = $database->getState($_POST['selectValue'], 'id');

            $assignmentId = $_GET['id'];

            if($_POST['selectValue'] == '3' && $_POST['appointmentDate'] != null){
                $checkQuery = $database->getConnection()->prepare('SELECT * FROM appointments WHERE assignmentId = ? AND deleted = 0');
                $checkQuery->bind_param('i', $_GET['id']);

                if(!$database->check($checkQuery)) {

                    $appointmentTime = $_POST['appointmentDate'];
                    $query = $database->getConnection()->prepare('INSERT INTO appointments (assignmentId, time, note, time_added, deleted) VALUES (?, ?, ?, ?, 0)');
                    $query->bind_param('isss', $assignmentId, $appointmentTime, $_POST['note'], $date);

                    $database->executeQuery($query);

                    $appointmentQuery = $database->getConnection()->prepare('SELECT * FROM appointments WHERE assignmentId = ? AND deleted = 0');
                    $appointmentQuery->bind_param('i', $assignmentId);

                    $appointment = $database->getData($appointmentQuery);

                    $updateQuery = $database->getConnection()->prepare('UPDATE assignments SET appointment = ?, stateId = ? WHERE id = ?');
                    $updateQuery->bind_param('iii', $appointment['id'], $_POST['selectValue'], $assignmentId);

                    $database->executeQuery($updateQuery);
                    echo $alertBuilder->createAlert('New appointment at ' . $appointment['time'], 'success');
                }
                else{
                    $updateQuery = $database->getConnection()->prepare('UPDATE appointments SET time = ?, note = ?, time_added = ? WHERE assignmentId = ? AND deleted = 0');
                    $updateQuery->bind_param('sssi', $_POST['appointmentDate'], $_POST['note'], $date ,$_GET['id']);
                    $database->executeQuery($updateQuery);

                    $updateAssignment = $database->getConnection()->prepare('UPDATE assignments SET stateId = ? WHERE id = ?');
                    $updateAssignment->bind_param('ii', $_POST['selectValue'], $assignmentId);

                    $database->executeQuery($updateAssignment);

                    echo $alertBuilder->createAlert('Appointment update', 'success');
                }
            }
            else{
                $query = $database->getConnection()->prepare('INSERT INTO stateupdates (stateId, assignmentId, note, time_added) VALUES (?, ?, ?, ?)');

                $note = $_POST['note'];
                $stateId = $_POST['selectValue'];

                $query->bind_param('iiss', $assignmentId, $stateId, $note, $date);

                $database->executeQuery($query);

                if($assignment['appointment'] != null){
                    $oldAppointment = $assignment['appointment'];

                    $updateAppointment = $database->getConnection()->prepare('UPDATE appointments SET deleted = 1 WHERE id = ?');
                    $updateAppointment->bind_param('i', $oldAppointment);

                    $database->executeQuery($updateAppointment);

                    $updateQuery = $database->getConnection()->prepare('UPDATE assignments SET stateId = ?, appointment = null WHERE id = ?');

                }
                else {
                    $updateQuery = $database->getConnection()->prepare('UPDATE assignments SET stateId = ? WHERE id = ?');
                }
                $updateQuery->bind_param('ii', $stateId, $assignmentId);
                $database->executeQuery($updateQuery);


                echo $alertBuilder->createAlert('State updated', 'success');
            }
        }
}

?>


<style>
    .form-control{
        font-size: 14px !important;
    }
    #datetimepicker{
        display: none;
    }
    #dateLabel{
        display: none;
    }
</style>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Update assignment #<?php echo $assignment['id']; ?>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-md-6">
<!--                            <h5>Updating an assignment</h5>-->
                            <form action='' method="post">
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
                                        <label>Current state:</label>
                                        <input class='form-control' placeholder='' name='assignment' type='text' readonly value='<?php
                                        echo $database->getState($database->getAssignment($_GET['id'], 'id')['stateId'], 'id')['name'];


                                        ?>'>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action='' method='post'>
                                <fieldset>
                                    <div class="form-group">
                                        <label>New state:</label>
                                        <select name="selectValue" class="form-control" id="selectState">
                                            <option value="">-- Select a state --</option>
                                            <?php
                                            foreach($allStates as $state){
                                                $id = $state['id'];
                                                $code = $state['code'];
                                                $name = $state['name'];

                                                echo "<option value=$id>$code - $name</option>";


                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group" id="dateLabel">
                                        <?php
                                        if($assignment['appointment'] != null){
                                            echo '<label style="color: red">Keep in mind this assignment already has an appointment</label><br>';
                                        }
                                        ?>
                                        <label>Date:</label>
                                        <input name='appointmentDate' placeholder="" class='form-control' id="datetimepicker" type="text">
                                    </div>
                                    <div class='form-group'>
                                        <label>Note (not required): </label>
                                        <textarea placeholder="Enter a note" class="form-control" rows="3" name="note"></textarea>
                                    </div>
                                    <input class='btn btn-info btn-sm' name='assignmentUpdate' type='submit' value='Update assignment'>
                                </fieldset>
                            </form>


                            <script>
                                var dateToday = new Date();
                                var dateTimePicker = $('#datetimepicker');
                                var dateLabel = $('#dateLabel');

                                dateTimePicker.datetimepicker(
                                    {
                                        minDate: dateToday
                                    }
                                );


                                $('#selectState').change(function(){
                                    var value = $(this).val();
                                    if(value != 3){
                                        dateTimePicker.hide();
                                        dateLabel.hide();
                                    }
                                    else{
                                        dateTimePicker.show();
                                        dateLabel.show();
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
