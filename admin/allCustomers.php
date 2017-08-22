<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 3-8-2017
 * Time: 21:02
 */
include '../includes/navbar.php';
include '../includes/adminCheck.php';?>
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
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Company</th>
            <th>More</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $statement = $database->getConnection()->prepare('SELECT * FROM customers');
        $customers = $database->getDataAsArray($statement);
        foreach($customers as $customer){
            $name = $customer ['name'];
            $surname = $customer['surname'];
            $email = $customer['email'];
            $phone = $customer['phone'];
            $company = $customer['company'];
            $id = $customer['id'];
            echo "<tr>
                    <td>$name</td>
                    <td>$surname</td>
                    <td>$email</td>
                    <td>$phone</td>
                    <td>$company</td>
                    <td><a href='../admin/customerInfo.php?id=$id' class='btn btn-sm btn-info'><i class='fa fa-info'></i></a></td>
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