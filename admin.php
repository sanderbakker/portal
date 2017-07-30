<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 27-7-2017
 * Time: 15:44
 */
include "includes.php";
include "navbar.php";
include "adminCheck.php";
?>
<style>
    .card{
        margin-top: 25px;
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
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header card-primary">
                    All users:
                </div>

                <div class="card-block">
                    <h4 class="card-title">All Users</h4>
                    <p class="card-text">Last update: <?php echo date('d-m-Y H:i:s')?> <a href="?update=true"><i class="fa fa-refresh"></i></a></p>
                    <?php
                    $date = date('d-m-y', strtotime("-1 week")); ?>
                    <p class="card-text card-margin">New users since <?php echo $date . ': ' . $database->getUsersLastWeek("SELECT count(id) number FROM users WHERE reg_date >= $date")[0]?></p>
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
                <div class="card-header card-success">
                    New registrations:
                </div>
                <div class="card-block">
                    <h4 class="card-title">New users to approve</h4>
                    <p class="card-text">Last update: <?php echo date('d-m-Y H:i:s')?> <a href="?update=true"><i class="fa fa-refresh"></i></a></p>
                    <?php
                    $date = date('d-m-y', strtotime("-1 week")); ?>
                    <p class="card-text">Users to approve: <?php echo $database->getUsersLastWeek("SELECT count(id) number FROM users WHERE approved = false")[0]?></p>
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
                <div class="card-header card-danger">
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
</div>
