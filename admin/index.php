<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 27-7-2017
 * Time: 15:44
 */

include "../includes/includes.php";
include "../includes/navbar.php";
include "../includes/adminCheck.php";
?>
<style>
    .card{
        margin-top: 25px;
        height: 35%;
    }
    p{
        margin: 0;
    }
</style>
<script type="text/javascript">

</script>
<head>
    <meta http-equiv="refresh" content="300">
</head>
<div id="#users">
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header card-warning">
                    All users:
                </div>

                <div class="card-block">
                    <h4 class="card-title">All Users</h4>
                    <p class="card-text">Last update: <?php echo date('d-m-Y H:i:s')?> <a href="?update=true"><i class="fa fa-refresh"></i></a></p>
                    <?php
                    $date = date('d-m-y', strtotime("-1 week")); ?>
                    <p class="card-text card-margin">New users since <?php echo $date . ': ' . $database->getData("SELECT count(id) number FROM users WHERE reg_date >= $date")[0]?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="allUsers.php" class="card-link mx-auto">Show</a>
                    </li>
                </ul>

            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header card-warning">
                    New registrations:
                </div>
                <div class="card-block">
                    <h4 class="card-title">New users to approve</h4>
                    <p class="card-text">Last update: <?php echo date('d-m-Y H:i:s')?> <a href="?update=true"><i class="fa fa-refresh"></i></a></p>
                    <?php
                    $date = date('d-m-y', strtotime("-1 week")); ?>
                    <p class="card-text">Users to approve: <?php echo $database->getData("SELECT count(id) number FROM users WHERE approved = false")[0]?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="newUser.php" class="card-link mx-auto">Show</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header card-warning">
                    Add, remove & disable users:
                </div>
                <div class="card-block">
                    <h4 class="card-title">User actions</h4>
                    <p class="card-text">Multiple actions can be used here like: adding, removing or disabling a user.</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="userAction.php" class="card-link mx-auto">Show</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header card-warning">
                    Locations Users:
                </div>
                <div class="card-block">
                    <h4 class="card-title">Locations users</h4>
                    <p class="card-text">All the locations of our users. Fliters can be applied to this option </p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="userLocations.php" class="card-link mx-auto">Show</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
<div id="customers">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header card-success">
                        All customers:
                    </div>

                    <div class="card-block">
                        <h4 class="card-title">All Customers</h4>
                        <p class="card-text">Last update: <?php echo date('d-m-Y H:i:s')?> <a href="?update=true"><i class="fa fa-refresh"></i></a></p>
                        <?php
                        $date = date('d-m-y', strtotime("-1 week")); ?>
                        <p class="card-text card-margin">New customers since <?php echo $date . ': ' . $database->getData("SELECT count(id) number FROM customers WHERE reg_date >= $date")[0]?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="allCustomers.php" class="card-link mx-auto">Show</a>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header card-success">
                        Customer actions:
                    </div>

                    <div class="card-block">
                        <h4 class="card-title">Customer actions</h4>
                        <p class="card-text">Multiple actions can be executed here like: adding, removing, editing a customer</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="#" class="card-link mx-auto">Show</a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

    </div>
</div>

