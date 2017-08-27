<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script
        src="https://code.jquery.com/jquery-3.2.1.js"
        integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script><link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/style.css" type="text/css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap4.min.css"/>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/locale/nl.js"></script>

<link rel="stylesheet" type="text/css" href="../css/jquery.datetimepicker.min.css"/ >
<script src="../js/jquery.datetimepicker.full.min.js"></script>
<link rel="stylesheet" href="../css/bootstrap-select.css" type="text/css">

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

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
include_once 'includeDatabase.php';
$id = $_SESSION['id'];

$userDataStatement = $database->getConnection()->prepare('SELECT * FROM users WHERE id =  ?');
$userDataStatement->bind_param('i', $id);
$userData = $database->getData($userDataStatement);
$role = $userData['role'];
if($role == 'admin') {
    echo "<nav class='navbar navbar-toggleable-md navbar-light' style='background-color: #5bc0de;'>
   <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
        <span class='navbar-toggler-icon'></span>
    </button>
    <a class='navbar-brand' href='../user/index.php'>
        <img src='../assets/logo.png' width='30' height='30' alt=''>
    </a>    <div id='navbarNavDropdown' class='navbar-collapse collapse'>
        <ul class='navbar-nav mr-auto'>
            <li class='nav-item active'>
                <a class='nav-link' href='../user/index.php'>Home<span class='sr-only'>(current)</span></a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='../user/myAssignments.php'>Assignments</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='#'>Activities</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='../user/myCustomers.php'>Customers</a>
            </li>

        </ul>
        <ul class='navbar-nav'>
            <li class='nav-item dropdown'>
        <a class='nav-link ' title='Admin' href='http://example.com' id='navbarDropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
          <i class='fa fa-lock'></i> <br>
        </a>
        <div class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'>
          <a class='dropdown-item' href='../admin/index.php#users'>Users</a>
          <a class='dropdown-item' href='../admin/index.php#customers'>Customers</a>  
          <a class='dropdown-item' href='../admin/index.php?#assignments'>Assignments</a>
        </div>
      </li>
            <li class='nav-item'>
                <a class='nav-link' title='Profile' href='../user/profile.php'><i class='fa fa-user'></i> <br></a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' title='Messages' href='../user/messages.php'><i class='fa fa-envelope'></i> <br></a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' title='Settings' href='../user/settings.php'><i class='fa fa-cog'></i> <br></a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' title='Logout' href='../login/logout.php'><i class='fa fa-sign-out'></i> <br></a>
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
    <a class='navbar-brand' href='../user/index.php'>
        <img src='../assets/logo.png' width='30' height='30' alt=''>
    </a>
    <div id='navbarNavDropdown' class='navbar-collapse collapse'>
        <ul class='navbar-nav mr-auto'>
            <li class='nav-item active'>
                <a class='nav-link' href='../user/index.php'>Home<span class='sr-only'>(current)</span></a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='../user/myAssignments.php'>Assignments</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='#'>Activities</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='../user/myCustomers.php'>Customers</a>
            </li>

        </ul>
        <ul class='navbar-nav'>
            <li class='nav-item'>
                <a class='nav-link' title='Profile' href='../user/profile.php'><i class='fa fa-user'></i> <br></a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' title='Messages' href='../user/messages.php'><i class='fa fa-envelope'></i> <br></a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' title='Settings' href='../user/settings.php'><i class='fa fa-cog'></i> <br></a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' title='Logout' href='../login/logout.php'><i class='fa fa-sign-out'></i> <br></a>
            </li>
        </ul>
    </div>
</nav>";
}
?>

