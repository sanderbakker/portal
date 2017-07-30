<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 28-7-2017
 * Time: 21:40
 */
include 'navbar.php';
include "adminCheck.php";
//
//if(isset($_GET['approved']) && $_GET['approved'] == 'true' ){
//    $userId = $_GET['id'];
//    $database->insertInTable('portal', "UPDATE Users
//                                                     SET approved=true
//                                                     WHERE id='$userId'");
//
//}
//elseif(isset($_GET['approved']) && $_GET['approved'] == 'false'){
//    $userId = $_GET['id'];
//    $database->insertInTable('portal', "DELETE FROM Users
//                                                     WHERE id='$userId'");
//}
?>
<style>
    .container{
        margin-top: 25px;
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
    <a href="#" class="btn btn-sm btn-success a-btn">Add</a>
    <a href="#" class="btn btn-sm btn-info a-btn pull-right"><i class="fa fa-info"></i></a>
    <table class="table mx-auto">
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
        $users = $database->getUsers("SELECT * FROM users");
        foreach($users as $user) {
            $name = $user ['name'];
            $surname = $user['surname'];
            $email = $user['email'];
            $phone = $user['phonenumber'];
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
                    <td><a href='#' class='btn btn-sm btn-warning ' onclick=\"return confirm('Are you sure to delete $name from SPortal');\">
                          <i class='fa fa-minus'></i>
                          </a>
                        <a href='#'class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure to ban $name from SPortal');\">
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
                    <td><a href='#' class='btn btn-sm btn-warning ' onclick=\"return confirm('Are you sure to delete $name from SPortal');\">
                          <i class='fa fa-minus'></i>
                          </a>
                        <a href='#'class='btn btn-sm btn-success' onclick=\"return confirm('Are you sure to ban $name from SPortal');\">
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
</div>