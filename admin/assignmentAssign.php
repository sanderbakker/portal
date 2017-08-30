<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 30-8-2017
 * Time: 13:57
 */
include '../includes/navbar.php';
include '../includes/adminCheck.php';
?>
<style>
    .container{
        margin-top: 15px;
    }

    a {
        color: black;
    }
    h3{
        margin-left: 10px;
    }

</style>
<div class="container mx-auto">
    <h3>Assignments to assign</h3>
    <table class="table mx-auto" id="table">
        <thead>
        <tr>
            <th>Number</th>
            <th>Description</th>
            <th>Added At</th>
            <th>State</th>
            <th>Completed</th>
            <th>Closed</th>
            <th>More</th>

        </tr>
        </thead>
        <tbody>
        <?php
        $statement = $database->getConnection()->prepare("SELECT * FROM assignments WHERE userId IS NULL");
        $assignments = $database->getDataAsArray($statement);
        foreach($assignments as $assignment){
            $description = $assignment['description'];
            $timeAdded = $assignment['time_added'];
            $completed = $assignment['completed'];
            $stateId = $assignment['stateId'];
            $state= $database->getState($stateId, 'id')['name'];
            $closed = $assignment['closed'];
            $id = $assignment['id'];
            echo "<tr>
                    <td>$id</td>
                    <td>$description</td>
                    <td>$timeAdded</td>
                    <td>$state</td>
                    <td>$completed</td>
                    <td>$closed</td>
                    <td><a href='assignAssignment.php?id=$id' class='btn btn-sm btn-info'><i class='fa fa-info'></i></a></td>
                
                  </tr>";
        }
        ?>
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "pageLength" : 7,
                "bLengthChange": false
            });
        } );
    </script>
</div>