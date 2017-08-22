<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 27-7-2017
 * Time: 20:55
 */
include '../includes/navbar.php';
include "../includes/adminCheck.php";
?>
<style>
    .container{
        margin-top: 15px;
        margin-bottom: 15px;
    }

    a {
        color: black;
    }
</style>
<div class="container mx-auto">
    <!--Add class table-responsive for responsive table -->
    <table class="table mx-auto" id="example">
        <thead>
        <tr>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Zipcode</th>
            <th>City</th>
            <th>Role</th>
            <th>Approved</th>
            <th>More</th>

        </tr>
        </thead>
        <tbody>
        <?php
        $statement = $database->getConnection()->prepare("SELECT * FROM users");
        $users = $database->getDataAsArray($statement);
        foreach($users as $user){
            $name = $user ['name'];
            $surname = $user['surname'];
            $email = $user['email'];
            $phone = $user['phone'];
            $address = $user['address'];
            $zipcode = $user['zipcode'];
            $city = $user['city'];
            $role = $user['role'];
            $id = $user['id'];
            if($user['approved'] == 1){
                $approved = "Yes";
            }
            else{
                $approved = "No";
            }
            echo "<tr>
                    <td>$name</td>
                    <td>$surname</td>
                    <td>$email</td>
                    <td>$phone</td>
                    <td>$address</td>
                    <td>$zipcode</td>
                    <td>$city</td>
                    <td>$role</td>
                    <td>$approved</td>
                    <td><a href='userInfo.php?id=$id' class='btn btn-sm btn-info'><i class='fa fa-info'></i></a></td>
                    
                  </tr>";
        }
        ?>
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "pageLength" : 7,
                "bLengthChange": false
            });
        } );
    </script>
</div>