<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 5-8-2017
 * Time: 21:57
 */
include '../includes/navbar.php';
if(isset($_GET['action']) && isset($_GET['id'])){
    $action = $_GET['action'];
    $id = mysqli_real_escape_string($database->getConnection(), $_GET['id']);

    if($action == 'read') {
        $database->executeQuery('portal', "UPDATE messages SET messageRead=1 WHERE id='$id'");
    }
    elseif($action == 'trash'){
        $database->executeQuery('portal', "UPDATE messages SET messageTrash=1, messageRead = 1 WHERE id='$id'");
    }
    elseif($action == 'unread'){
        $database->executeQuery('portal', "UPDATE messages SET messageRead=0 WHERE id='$id'");
    }
    elseif($action == 'inbox'){
        $database->executeQuery('portal', "UPDATE messages SET messageTrash=0 WHERE id='$id'");
    }
    elseif($action == 'remove'){
        $database->executeQuery('portal', "UPDATE messages SET messageDeleted = 1 WHERE id='$id'");
    }
    else{
        header('location: ../404.php');
    }
}


if((isset($_GET['messages']) && $_GET['messages'] == 'inbox') || !isset($_GET['messages'])) {
    $id = mysqli_real_escape_string($database->getConnection(), $_SESSION['id']);
    $messages = $database->getDataAsArray("SELECT * FROM messages WHERE userId = $id AND messageTrash = 0 AND messageDeleted = 0 ORDER BY time_added DESC");
}
elseif (isset($_GET['messages']) && $_GET['messages'] == 'trash'){
    $id = mysqli_real_escape_string($database->getConnection(), $_SESSION['id']);
    $messages = $database->getDataAsArray("SELECT * FROM messages WHERE userId = $id AND messageTrash = 1 AND messageDeleted = 0 ORDER BY time_added DESC");
}
else{
    $messages = null;
    header('location: ../404.php');
}
?>
<style>

    .table-link{
        text-decoration: none;
        color: red;
    }
    a, a:hover, a:active, a:visited, a:focus {
        text-decoration:none;
    }
    .card-block{
        padding: 0; !important;
    }
    .table{
        margin-bottom: 0; !important;
    }

    #table_wrapper{
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .dropdown-item{
        width: auto;
    }
    h5{
        font-size: 20px;
    }
    .card-header{
        padding: 0.75em; !important;
    }

    a:visited{
        color:black;
        text-decoration: none;
    }
    .table-active{
        font-weight: bold;
    }
    #buttonAlignment{
        margin-right: 5px;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div id="accordion" role="tablist" aria-multiselectable="true">
                <div class="card">
                    <div class="card-header" role="tab" id="headingOne">
                        <h5 class="mb-0">
                            Message options
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-block">
                            <table class="table">
                                <tr>
                                    <td>
                                        <a href="?messages=inbox"><i class="fa fa-inbox"></i> Inbox</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="?messages=trash"><i class="fa fa-trash"></i> Trash</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <?php
                if((!isset($_GET['messages']) || $_GET['messages'] == 'inbox'))
                    if($messages != null) {
                        echo '<div class="card-header">
                    Messages<button class="btn btn-sm btn-success pull-right actionButton" title="Mark all as read" value="readAll"><i class="fa fa-envelope-open"></i></button>
                    <button class="btn btn-sm btn-default pull-right actionButton" id="buttonAlignment" value="unreadAll" title="Mark all as unread"><i class="fa fa-envelope"></i></button>
                </div>';
                    }
                    else{
                        echo '<div class="card-header">
                    Messages</div>';
                    }
                else{
                    if($messages != null){
                    echo '<div class="card-header">
                    Messages<button class="btn btn-sm btn-danger pull-right actionButton" value="removeAll" title="Remove all"><i class="fa fa-trash"></i></button>
                </div>';}
                    else{
                        echo '<div class="card-header">
                    Messages</div>'; 
                    }
                }
                ?>

                <div class="card-block">
                    <table class="table mx-auto" id="table">
                        <thead>
                        <tr>
                            <th>Number</th>
                            <th>Subject</th>
                            <th>Time added</th>
                            <th>More</th>
                        </tr>
                        </thead>
                </div>
                <?php
                if(!$messages && (!isset($_GET['messages']) || $_GET['messages'] == 'inbox')){
                    echo '<tr>       
                          <td colspan="4" style="text-align: center">No new messages in the inbox</td>    
                          </tr>';
                }
                elseif (!$messages && $_GET['messages'] = 'trash') {
                    echo '<tr>       
                          <td colspan="4" style="text-align: center">No messages in trash</td>    
                          </tr>';
                }
                elseif(!isset($_GET['messages']) || $_GET['messages'] == 'inbox'){
                    foreach ($messages as $message){
                        $messageType = 'inbox';
                        $number = $message['id'];

                        $dropdownUnread = "<td>
                                        <div class='dropdown'>
                                            <button class='btn btn-secondary btn-sm ' type='button' id='dropdownMenu2' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                <i class='fa fa-ellipsis-v'></i>
                                            </button>
                                            <div class='dropdown-menu dropdown-menu-left' aria-labelledby='dropdownMenu2'>
                                                <button class='dropdown-item' data-toggle='modal' data-number='$number' data-target='#messageModal'>Preview</button> 
                                                <a class='dropdown-item' href='?messages=$messageType&action=read&id=$number'>Mark as read</a>
                                                <a class='dropdown-item' href='?messages=$messageType&action=trash&id=$number'>Move to trash</a>
                                            </div>
                                        </div>
                                      </td>";

                        $dropdownRead = "<td>
                                        <div class='dropdown'>
                                            <button class='btn btn-secondary btn-sm ' type='button' id='dropdownMenu2' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                <i class='fa fa-ellipsis-v'></i>
                                            </button>
                                            <div class='dropdown-menu dropdown-menu-left' aria-labelledby='dropdownMenu2'>
                                                <button class='dropdown-item' data-toggle='modal' data-number='$number' data-target='#messageModal'>Preview</button> 
                                                <a class='dropdown-item' href='?messages=$messageType&action=unread&id=$number'>Mark as unread</a>
                                                <a class='dropdown-item' href='?messages=$messageType&action=trash&id=$number'>Move to trash</a>
                                            </div>
                                        </div>
                                      </td>";

                        $subject = $message['subject'];
                        $time_added = $message['time_added'];
                        if($message['messageRead'] == 0){
                            echo "<tr class='table-active'>
                                  <td><a href='showMessage.php?id=$number' class='table-link'>$number</a></td>
                                  <td>$subject</td>
                                  <td>$time_added</td>
                                  $dropdownUnread
                                 
                                  </tr>";
                        }
                        else{
                            echo "<tr>
                              <td><a href='showMessage.php?id=$number' class='table-link'>$number</a></td>
                              <td>$subject</td>
                              <td>$time_added</td>
                              $dropdownRead
                              </tr>";
                        }
                    }
                }
                else{
                    foreach ($messages as $message){
                        $number = $message['id'];
                        $subject = $message['subject'];
                        $time_added = $message['time_added'];
                        $messageType = $_GET['messages'];

                        $dropdownTrash = "<td>
                                        <div class='dropdown'>
                                            <button class='btn btn-secondary btn-sm ' type='button' id='dropdownMenu2' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                <i class='fa fa-ellipsis-v'></i>
                                            </button>
                                            <div class='dropdown-menu dropdown-menu-left' aria-labelledby='dropdownMenu2'>
                                                <button class='dropdown-item' data-toggle='modal' data-number='$number' data-target='#messageModal'>Preview</button> 
                                                <a class='dropdown-item' href='?messages=$messageType&action=inbox&id=$number'>Move to inbox</a>
                                                <a class='dropdown-item' href='?messages=$messageType&action=remove&id=$number'>Remove</a>
                                            </div>
                                        </div>
                                      </td>";


                        if($message['deleted'] = 1){
                            $dropdown = $dropdownTrash;
                        }
                        else{
                            $dropdown = null;
                        }
                        echo "<tr>
                                <td><a href='showMessage.php?id=$number' class='table-link'>$number</a></td>
                                <td>$subject</td>
                                <td>$time_added</td>
                                $dropdown 
                              </tr>";
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Modal -->
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
                <div class="modal-footer">
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
            $.ajax({
                type: 'POST',
                url: 'retrieveData.php',
                data: {
                    'id': number
                },
                dataType: 'json',
                success: [ function(data){
                    $('#modalTitle').html('#' + data[0]['id']);

                    $('#modalBody').html('<b>Subject:</b><br> ' + data[0]['subject'] + '<br><br>' + '<b>Message:</b> <br> ' +  data[0]['message']);
                    console.log(data[0]['id']);
                }],
                error: [function(error){
                    alert(error);
                }]
            });
        });

        $('.actionButton').click(function(){
            var buttonValue = $(this).val();
            var userId = '<?php echo $_SESSION['id']; ?>';
            console.log(userId);
            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: {
                    'action': buttonValue,
                    'id' : userId
                },
                dataType: 'json',
                success: [ location.reload()]
            });
        });

    </script>
</div>
