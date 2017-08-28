<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 28-8-2017
 * Time: 20:39
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
    <h3>My Activities</h3>

    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Description</th>
            <th>Time added</th>
            <th>State</th>
            <th>Customer</th>
        </tr>
        </thead>
        <tbody>
        <?php

        $id = $_SESSION['id'];

        $assignmentStatement = $database->getConnection()->prepare("SELECT * FROM assignments WHERE userId = ? AND closed = 1 OR completed = 1");
        $assignmentStatement->bind_param('i', $id);

        $assignments = $database->getDataAsArray($assignmentStatement);
        foreach($assignments as $assignment){
            $description = $assignment ['description'];
            $time_added = $assignment['time_added'];

            $stateStatement = $database->getConnection()->prepare("SELECT * FROM state WHERE id= ?");
            $stateStatement->bind_param('i', $stateId);

            $stateId = $assignment['stateId'];
            $state = $database->getData($stateStatement);

            $stateName = $state['name'];
            $stateCode = $state['code'];

            $id = $assignment['id'];

            $customerId = $assignment['customerId'];

            $customerStatement = $database->getConnection()->prepare('SELECT * FROM customers WHERE id = ?');
            $customerStatement->bind_param('i', $customerId);

            $customer = $database->getData($customerStatement);
            $customerName = $customer['name'] . ' ' . $customer['surname'];

            echo "<tr>
                    <td>$description</td>
                    <td>$time_added</td>
                    <td>$stateName</td>
                    <td><a href='../admin/customerInfo.php?id=$customerId'>$customerName</a></td>
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