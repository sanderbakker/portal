<?php
include "../includes/navbar.php";
    $id = $_SESSION['id'];
    $userData = $database->getData("SELECT * FROM users WHERE id='$id'");
    $userInfo = $database->getData("SELECT * FROM user_info WHERE userId='$id'");
    $_SESSION['other'] = $userInfo['other'];
    $_SESSION['availability'] = $userInfo['availability'];
    $_SESSION['skills'] = $userInfo['skills'];
    $_SESSION['region'] = $userInfo['region'];
    $_SESSION['name'] = $userData['name'];
    $_SESSION['surname'] = $userData['surname'];
    $_SESSION['username'] = $userData['username'];
    $_SESSION['email'] = $userData['email'];
    $_SESSION['role'] = $userData['role'];
    $_SESSION['address'] = $userData['address'];
    $_SESSION['zipcode'] = $userData['zipcode'];
    $_SESSION['city'] = $userData['city'];
    $_SESSION['phone'] = $userData['phone'];

?>
<style>
    .card{
        margin-top: 15px;
        font-size: 14px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Introduction
                </div>
                <div class="card-block">
                    Welcome to SPortal <?php echo $_SESSION['name'];?>! In here you can find your assignments, upcoming salary and more.
                    <br><br>
                    Having trouble understanding how all of this works? Don't worry! There is comprehensive <a href="wiki.php">Wiki</a> which explains a lot about this portal.
                    <br><br>
                    Please read it before asking questions!
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Profile overview
                </div>
                <div class="card-block">

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Salary
                </div>
                <div class="card-block">

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Latest messages
                </div>
                <div class="card-block">

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Upcoming appointments
                </div>
                <div class="card-block">

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Contact
                </div>
                <div class="card-block">

                </div>
            </div>
        </div>
    </div>

</div>
