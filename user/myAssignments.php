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

</style>
<div class="container">
    <h3>My Assignments</h3>

    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Description</th>
            <th>Time added</th>
            <th>State</th>
            <th>More</th>
        </tr>
        </thead>
        <tbody>
        <?php
        
        $id = mysqli_real_escape_string($database->getConnection(), $_SESSION['id']);
        $assignments = $database->getDataAsArray("SELECT * FROM assignments WHERE userId = $id");
        foreach($assignments as $assignment){
            $description = $assignment ['description'];
            $time_added = $assignment['time_added'];
            $state = $assignment['stateId'];
            $id = $assignment['id'];
            echo "<tr>
                    <td>$description</td>
                    <td>$time_added</td>
                    <td>$state</td>
                    <td><a href='../admin/assignmentInfo.php?id=$id' class='btn btn-sm btn-info'><i class='fa fa-info'></i></a></td>
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
