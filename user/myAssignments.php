<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 15-8-2017
 * Time: 16:20
 */
include '../includes/navbar.php';

?>
<style>
    .container {
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .pull-right{
        margin-right: 15px;
    }
    h3{
        margin-left: 15px;
    }

</style>
<div class="container">
    <h3>My Assignments<a class="btn btn-sm btn-success pull-right" href="../admin/createAssignment.php">Add</a></h3>

    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Description</th>
            <th>Time added</th>
            <th>State</th>
            <th>Customer</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        
        $id = mysqli_real_escape_string($database->getConnection(), $_SESSION['id']);
        $assignments = $database->getDataAsArray("SELECT * FROM assignments WHERE userId = $id AND closed = 0 AND completed = 0");
        foreach($assignments as $assignment){
            $description = $assignment ['description'];
            $time_added = $assignment['time_added'];
            $stateId = mysqli_real_escape_string($database->getConnection(), $assignment['stateId']);
            $state = $database->getData("SELECT * FROM state WHERE id='$stateId'");

            $stateName = $state['name'];
            $stateCode = $state['code'];

            $id = $assignment['id'];
            $customerId = mysqli_real_escape_string($database->getConnection(), $assignment['customerId']);
            $customer = $database->getData("SELECT * FROM customers WHERE id='$customerId'");
            $customerName = $customer['name'] . ' ' . $customer['surname'];
            if($stateCode == '120'){
                $salary = "<a title='Register hours' href='#' class='btn btn-sm btn-success'><i class='fa fa-money'></i></a>";
                $close = "<a  title='Close assignment'  href='closeAssignment.php?id=$id' class='btn btn-sm btn-danger'><i class='fa fa-times'></i></a>";
                $update = "<a title='Update assignment' href='#' class='btn btn-sm btn-info'><i class='fa fa-refresh'></i></a>";
            }
            elseif ($stateCode == '300'){
                $salary = '';
                $close = '';
                $update = '';
            }
            else{
                $close = "<a  title='Close assignment'  href='closeAssignment.php?id=$id' class='btn btn-sm btn-danger'><i class='fa fa-times'></i></a>";
                $salary = '';
                $update =  "<a title='Update assignment' href='#' class='btn btn-sm btn-info'><i class='fa fa-refresh'></i></a>";
            }

            echo "<tr>
                    <td>$description</td>
                    <td>$time_added</td>
                    <td>$stateName</td>
                    <td><a href='../admin/customerInfo.php?id=$customerId'>$customerName</a></td>
                    <td>$update
                        $salary           
                        $close
                        <a title='Overview' href='../admin/assignmentInfo.php?id=$id' class='btn btn-sm btn-info'><i class='fa fa-info'></i></a>
                    
                    </td>
                  </tr>";
        }
        ?>
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "pageLength" : 10,
                "ordering" : false,
                "bLengthChange": false,
                "bInfo": false
            });
        } );
    </script>
</div>
