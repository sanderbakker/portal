<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 23-7-2017
 * Time: 20:54
 */
include '../includes/navbar.php';

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
    .btn{
        color: black;
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
                            <td><a class="btn btn-info btn-sm " href="edit.php?edit=name" ><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">Surname:</th>
                            <td><?php echo $_SESSION['surname']?></td>
                            <td><a class="btn btn-info btn-sm" href="edit.php?edit=surname"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">Username:</th>
                            <td><?php echo $_SESSION['username']?></td>
                            <td><a class="btn btn-info btn-sm" href="edit.php?edit=username"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">Email:</th>
                            <td><?php echo $_SESSION['email']?></td>
                            <td><a class="btn btn-info btn-sm" href="edit.php?edit=email"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">Phone:</th>
                            <td><?php echo $_SESSION['phone']?></td>
                            <td><a class="btn btn-info btn-sm" href="edit.php?edit=phone"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">Address:</th>
                            <td><?php echo $_SESSION['address']?></td>
                            <td><a class="btn btn-info btn-sm"href="edit.php?edit=address"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">Zipcode:</th>
                            <td><?php echo $_SESSION['zipcode']?></td>
                            <td><a class="btn btn-info btn-sm" href="edit.php?edit=zipcode"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">City:</th>
                            <td><?php echo $_SESSION['city']?></td>
                            <td><a class="btn btn-info btn-sm" href="edit.php?edit=city"><i class="fa fa-pencil"></i></a></td>
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
                    <table class="table">
                        <tbody>
                        <tr>
                            <th scope="row">Availability:</th>
                            <td><?php if(!empty($_SESSION['availability'])){
                                                echo $_SESSION['availability'] . " hours a week";
                                }
                                else {
                                    echo 'No Record';
                                }?></td>
                            <td><a class="btn btn-info btn-sm " href="edit.php?edit=availability" ><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">Skills:</th>
                            <td><?php if(!empty($_SESSION['skills'])){
                                    echo $_SESSION['skills'];
                                }
                                else {
                                    echo 'No Record';
                                }?></td>
                            <td><a class="btn btn-info btn-sm" href="edit.php?edit=skills"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">Region:</th>
                            <td><?php if(!empty($_SESSION['region'])){
                                    echo $_SESSION['region'];
                                }
                                else {
                                    echo 'No Record';
                                }?></td>
                            <td><a class="btn btn-info btn-sm" href="edit.php?edit=region"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">Other:</th>
                            <td><?php if(!empty($_SESSION['other'])){
                                    echo $_SESSION['other'];
                                }
                                else {
                                    echo 'No Record';
                                }?></td>
                            <td><a class="btn btn-info btn-sm" href="edit.php?edit=other"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card">
                <div class="card-header">
                    Change Password
                </div>
                <div class="card-block" style="height:78px; ">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th scope="row">Password:</th>
                            <td>*****************************************</td>
                            <td><a class="btn btn-info btn-sm " href="edit.php?edit=password" ><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
