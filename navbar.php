<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script><link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/>
<link rel="stylesheet" href="css/style.css" type="text/css">
<style>
    .navbar-collapse.collapsing,
    .navbar-collapse.in {

        position: absolute;
        background-color: background-color: rgba(91,192,222,0.9);

    }
</style>
<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 23-7-2017
 * Time: 14:07
 */

include 'includes.php';
$database = new Database('localhost', 'root', '');
$userData = $database->getUserById($_SESSION['id']);
$role = $userData['role'];
if($role == 'admin') {
    echo "<nav class='navbar navbar-toggleable-md navbar-light' style='background-color: #5bc0de;'>
   <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
        <span class='navbar-toggler-icon'></span>
    </button>
    <a class='navbar-brand' href='#'>
        <img src='assets/logo.png' width='30' height='30' alt=''> SPortal
    </a>    <div id='navbarNavDropdown' class='navbar-collapse collapse'>
        <ul class='navbar-nav mr-auto'>
            <li class='nav-item active'>
                <a class='nav-link' href='dashboard.php'>Home<span class='sr-only'>(current)</span></a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='#'>Assignments</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='#'>Activities</a>
            </li>

        </ul>
        <ul class='navbar-nav'>
            <li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle' href='http://example.com' id='navbarDropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
          Admin
        </a>
        <div class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'>
          <a class='dropdown-item' href='users.php'>Users</a>
        </div>
      </li>
            <li class='nav-item'>
                <a class='nav-link' href='profile.php'>My Profile</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='logout.php'>Logout</a>
            </li>
        </ul>
    </div>
</nav>";
}
else {
    echo "<nav class='navbar navbar-toggleable-md navbar-light' style='background-color: #5bc0de;'>
    <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
        <span class='navbar-toggler-icon'></span>
    </button>
    <a class='navbar-brand' href='#'>
        <img src='assets/logo.png' width='30' height='30' alt=''> SPortal
    </a>
    <div id='navbarNavDropdown' class='navbar-collapse collapse'>
        <ul class='navbar-nav mr-auto'>
            <li class='nav-item active'>
                <a class='nav-link' href='dashboard.php'>Home<span class='sr-only'>(current)</span></a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='#'>Assignments</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='#'>Activities</a>
            </li>

        </ul>
        <ul class='navbar-nav'>
            <li class='nav-item'>
                <a class='nav-link' href='profile.php'>My Profile</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='logout.php'>Logout</a>
            </li>
        </ul>
    </div>
</nav>";
}
?>

