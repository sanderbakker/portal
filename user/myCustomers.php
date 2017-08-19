<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 10-8-2017
 * Time: 11:15
 */
include '../includes/navbar.php';

?>
<style>
    .container {
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .pull-right{
        margin-right: 15px;
    }
    h3{
        margin-left: 15px;
    }

</style>
<div class="container">
    <h3>My Customers<a class="btn btn-sm btn-success pull-right" href="#">Add</a></h3>

    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
        $customers = $database->getDataAsArray("SELECT customers.* FROM assignments LEFT JOIN customers ON assignments.customerId = customers.id WHERE userId = '$id'");
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
            $('#table').DataTable({
                "pageLength" : 10,
                "ordering" : false,
                "bLengthChange": false,
                "bInfo": false
            });
        } );
    </script>
</div>
