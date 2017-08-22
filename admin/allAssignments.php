<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 6-8-2017
 * Time: 15:38
 */
include '../includes/navbar.php';
include '../includes/adminCheck.php';?>
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
    <h3>All assignments</h3>
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
        $statement = $database->getConnection()->prepare("SELECT * FROM assignments");
        $assignments = $database->getDataAsArray($statement);
        foreach($assignments as $assignment){
            $description = $assignment['description'];
            $timeAdded = $assignment['time_added'];
            $completed = $assignment['completed'];
            $stateId = $assignment['stateId'];
            $state= $database->getData("SELECT * FROM state WHERE id= $stateId", 'name');
            $closed = $assignment['closed'];
            $id = $assignment['id'];
            echo "<tr>
                    <td>$id</td>
                    <td>$description</td>
                    <td>$timeAdded</td>
                    <td>$state</td>
                    <td>$completed</td>
                    <td>$closed</td>
                    <td><a href='assignmentInfo.php?id=$id' class='btn btn-sm btn-info'><i class='fa fa-info'></i></a></td>
                
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