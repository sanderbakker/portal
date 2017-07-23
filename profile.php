<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 23-7-2017
 * Time: 20:54
 */
include 'navbar.php';

?>
<style>
    .card {
        margin-top: 25px; !important;
    }
    .table > tbody > tr:first-child > td {
        border: none;
    }
    .table > tbody > tr:first-child > th {
        border: none;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    User Details
                </div>
                <div class="card-block">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th scope="row">Name:</th>
                            <td><?php echo $_SESSION['name']?> </td>
                            <td><a class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">Surname:</th>
                            <td><?php echo $_SESSION['surname']?></td>
                            <td><a class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">Username:</th>
                            <td><?php echo $_SESSION['username']?></td>
                            <td><a class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">Email:</th>
                            <td><?php echo $_SESSION['email']?></td>
                            <td><a class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">Address:</th>
                            <td><?php echo $_SESSION['address']?></td>
                            <td><a class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">Zipcode:</th>
                            <td><?php echo $_SESSION['zipcode']?></td>
                            <td><a class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">City:</th>
                            <td><?php echo $_SESSION['city']?></td>
                            <td><a class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">Role:</th>
                            <td><?php echo $_SESSION['role']?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Additional information
                </div>
                <div class="card-block">

                </div>
            </div>
        </div>
    </div>
</div>
