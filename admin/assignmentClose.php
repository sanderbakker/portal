<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 17-8-2017
 * Time: 20:35
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
        $assignments = $database->getDataAsArray("SELECT * FROM assignments WHERE requestClose IS NOT NULL AND closed = 0");
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
                    <td><button class='btn btn-sm btn-info' data-toggle='modal' data-action ='retrieveData' data-number='$id' data-target='#messageModal'><i class='fa fa-info'></i></button></td>
                
                  </tr>"


                    ;
        }
        ?>
        </tbody>
    </table>
    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBody">

                </div>
                <div id="assignmentId" style="display: none">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-success actionButton" data-dismiss="modal" value="accept">Accept</button>
                    <button type="button" class="btn btn-sm btn-warning actionButton" data-dismiss="modal" value="reject">Reject</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "pageLength" : 7,
                "bLengthChange": false
            });
        } );
        $('#messageModal').on('show.bs.modal', function(e) {
            var number = $(e.relatedTarget).data('number');
            var buttonAction = $(e.relatedTarget).data('action');
            $.ajax({
                type: 'POST',
                url: '../user/ajax.php',
                data: {
                    'id': number,
                    'action': buttonAction
                },
                dataType: 'json',
                success: [ function(data){
                    $('#modalTitle').html('Concerning assignment #' + data[0]['id']);
                    $('#modalBody').html('<b>Assignment:</b><br> ' + data[0]['description'] + '<br><br>' + '' +
                                          '<b>Reason:</b> <br> ' +  data[0]['reason'] +
                                          '<br><br>' + '<b>Requested by:</b><br>' + data[0]['name'] + ' ' + data[0]['surname'] +
                                          '<br><br>' + '<b>Number of times requested for closing:</b><br>' + data[0]['requests']);
                    $('#assignmentId').val(number);
                }],
                error: [function(error){
                    alert(error);
                }]
            });
        });

        $('.actionButton').click(function(e){
            var assignmentId = $('#assignmentId').val();
            var buttonValue = $(this).val();
            console.log(assignmentId);
            $.ajax({
                type: 'POST',
                url: '../user/ajax.php',
                data: {
                    'action': buttonValue,
                    'id' : assignmentId
                },
                dataType: 'json',
                success: [ location.reload()]
            });
        });


    </script>
</div>