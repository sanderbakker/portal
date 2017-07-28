<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 27-7-2017
 * Time: 22:37
 */
include 'navbar.php';

if(isset($_GET['approved']) && $_GET['approved'] == 'true' ){
    $userId = $_GET['id'];
    $database->insertInTable('portal', "UPDATE Users 
                                                     SET approved=true
                                                     WHERE id='$userId'");

}
elseif(isset($_GET['approved']) && $_GET['approved'] == 'false'){
    $userId = $_GET['id'];
    $database->insertInTable('portal', "DELETE FROM Users
                                                     WHERE id='$userId'");
}
?>
<style>
    .container{
        margin-top: 25px;
    }

    a {
        color: black;
    }

</style>
<div class="container mx-auto">
    <!--Add class table-responsive for responsive table -->
    <table class="table mx-auto">
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
        $users = $database->getUsers("SELECT * FROM users WHERE approved = 0");
        foreach($users as $user){
            $name = $user ['name'];
            $surname = $user['surname'];
            $email = $user['email'];
            $phone = $user['phonenumber'];
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
                    <td><a href='?id=$id&approved=true' class='btn btn-sm btn-success'><i class='fa fa-check'></i></a><a href='?id=$id&approved=false'class='btn btn-sm btn-danger'><i class='fa fa-minus'></i></a></td>
                    
                  </tr>";
        }

        ?>
        </tbody>
    </table>
</div>