<style>
    #selectFontSize{
        font-size: 14px; !important;
    }
    #selectFontSize option{
        margin-left: 15px;
    }
</style>
<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 21-8-2017
 * Time: 18:46
 */
include "../includes/includes.php";
include '../includes/navbar.php';
include "../classes/alertBuilder.php";

$alertBuilder = new AlertBuilder();
if(isset($_POST['createAssignment'])){
    if(!empty($_POST['description']) && !empty($_POST['selectValue'])){
        $description= $_POST['description'];
        $customerId = $_POST['selectValue'];
        $currentDate = date('Y-m-d H:i:s');
        if($_SESSION['role'] == 'admin') {
            $id = null;
        }
        else{
            $id = $_SESSION['id'];
        }
        $database->executeQuery('portal', "INSERT INTO assignments (customerId, description, stateId, completed, closed, requestClose, userId) VALUES ($customerId, '$description', 1, 0, 0, NULL, $id)");
        echo $alertBuilder->createAlert('Created assignment for customer #' . $customerId, 'success');
    }
    else{
        echo $alertBuilder->createAlert("Not all fields are filled in", "danger");
    }

}

?>

<style>
    h3{
        font-family: 'Roboto', sans-serif;
        margin-top: 15px;
    }
    form{
        margin-top: 15px;
    }


</style>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h3>Adding an assignment</h3>
            <p>Assignments can be added by filling in the form on the right, please keep to following in mind:</p>
            <ul>
                <li>Not all fields are required</li>
                <li>The state of this new assignment will be Open (100)</li>
                <?php if ($_SESSION['role'] == 'admin'){
                    echo '<li>When you create an assignment the default assignee will be nobody.</li>';
                }
                ?>
            </ul>

        </div>
        <div class="col-md-6">
            <h3>Assignment details</h3>
            <form method="post">
                <fieldset>
                    <div class="form-group">
                        <textarea class="form-control" placeholder="Enter a detailed description of the assignment" style="font-size: 14px" name="description" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <select name="selectValue" class="form-control" id="selectFontSize">
                            <option value="">-- Select a customer --</option>
                            <?php
                            if($_SESSION['role'] == 'admin'){
                                $customers = $database->getDataAsArray('SELECT * FROM customers ORDER BY name ASC');
                            }
                            else{
                                $id = $_SESSION['id'];
                                $customers = $database->getDataAsArray("SELECT customers.* FROM assignments LEFT JOIN customers ON assignments.customerId = customers.id WHERE userId = '$id'");
                            }
                            foreach($customers as $customer){
                                $id = $customer['id'];
                                $name = $customer['name'];
                                echo "<option value=$id>$name</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <input class="btn btn-info btn-block" name="createAssignment" type="submit" value="Create">
                </fieldset>
            </form>

        </div>
    </div>
</div>