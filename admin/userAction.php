<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 28-7-2017
 * Time: 21:40
 */
include '../includes/navbar.php';
include "../includes/adminCheck.php";

if(isset($_GET['action']) && $_GET['action'] == 'remove'){
    $id = $_GET['id'];
    if($database->getData("SELECT * FROM user_info WHERE userId='$id'") != null){
        $database->deleteFromTable('portal', "DELETE FROM 'user_info' WHERE userId='$id'");
    }
    $database->deleteFromTable('portal', "DELETE FROM users WHERE id='$id'");
}

if(isset($_GET['action']) && $_GET['action'] == 'ban'){
    $id = $_GET['id'];
    $database->executeQuery('portal', "UPDATE users SET banned='1' WHERE id='$id'");
}
elseif(isset($_GET['action']) && $_GET['action'] == 'unban'){
    $id = $_GET['id'];
    $database->executeQuery('portal', "UPDATE users SET banned='0' WHERE id='$id'");
}
?>
<style>
    .container{
        margin-top: 15px;
        margin-bottom: 15px;
    }

    a {
        color: black;

    }

    .a-btn{
        margin-bottom: 10px;
        margin-left: 10px;

    }


</style>
<div class="container mx-auto">
    <!--Add class table-responsive for responsive table -->
    <h3>User actions</h3>
    <table class="table mx-auto" id="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Role</th>
            <th>Approved</th>
            <th>Banned</th>
            <th>More</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $users = $database->getDataAsArray("SELECT * FROM users");
        foreach($users as $user) {
            $name = $user ['name'];
            $surname = $user['surname'];
            $email = $user['email'];
            $phone = $user['phone'];
            $role = $user['role'];
            $id = $user['id'];
            $status = $user['banned'];
            if ($user['approved'] == 1) {
                $approved = "Yes";
            } else {
                $approved = "No";
            }
            if ($status == 1) {
                $status = "Yes";
            } else {
                $status = "No";
            }

                if ($role != 'admin') {
                    if ($status != 'Yes') {
                        echo "<tr>
                    <td>$name</td>
                    <td>$surname</td>
                    <td>$email</td>
                    <td>$phone</td>
                    <td>$role</td>
                    <td>$approved</td>
                    <td>$status</td>
                    <td><a href='?id=$id&action=remove' class='btn btn-sm btn-warning ' onclick=\"return confirm('Are you sure to delete $name from SPortal');\">
                          <i class='fa fa-minus'></i>
                          </a>
                        <a href='?id=$id&action=ban' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure to ban $name from SPortal');\">
                          <i class='fa fa-ban'></i>
                          </a>
                        <a href='#' class='btn btn-sm btn-primary '><i class='fa fa-user'></i></a>
                    </td>
                    
                  </tr>";
                    }
                    else{
                        echo "<tr>
                    <td>$name</td>
                    <td>$surname</td>
                    <td>$email</td>
                    <td>$phone</td>
                    <td>$role</td>
                    <td>$approved</td>
                    <td>$status</td>
                    <td><a href='?id=$id&action=remove' class='btn btn-sm btn-warning ' onclick=\"return confirm('Are you sure to delete $name from SPortal');\">
                          <i class='fa fa-minus'></i>
                          </a>
                        <a href='?id=$id&action=unban' class='btn btn-sm btn-success' onclick=\"return confirm('Are you sure to unlock $name');\">
                          <i class='fa fa-unlock-alt'></i>
                          </a>
                    </td>
                    
                  </tr>";
                    }
                }
                else {

                    echo "<tr>
                    <td>$name</td>
                    <td>$surname</td>
                    <td>$email</td>
                    <td>$phone</td>
                    <td>$role</td>
                    <td>$approved</td>
                    <td>$status</td>
                    <td><a href='#' class='btn btn-sm btn-primary '><i class='fa fa-user'></i></a></td>
                    
                  </tr>";
                }

        }

        ?>
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "pageLength" : 7,
                "ordering": false,
                "bLengthChange": false
            });
        } );
    </script>
</div>