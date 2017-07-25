<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script><link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/>
<link rel="stylesheet" href="css/style.css" type="text/css">


    <h2>Welcome to SPortal <button class="btn btn-info btn-circle"><i class="fa fa-info"></i></button></h2>
    <img class="mainPageLogo" src="assets/logo.png" alt="SB">
    <div class="buttons">
        <a href="login.php" role="button" class="btn btn-info"><i class="fa fa-sign-in"></i> Login</a>
        <a href="register.php" role="button" class="btn btn-info"><i class="fa fa-envelope-o"></i> Register</a>
    </div>
<?php
include 'Database.php';
$database = new Database("localhost", "root", "");
//Creates a database called portal if this doesn't exists
$database->createDatabase("portal");
//Create table in database
$database->createTable("CREATE TABLE Users (
                                  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                                  firstname VARCHAR(30) NOT NULL,
                                  lastname VARCHAR(30) NOT NULL,
                                  password VARCHAR(30) NOT NULL, 
                                  username VARCHAR(30) NOT NULL, 
                                  email VARCHAR(50) NOT NULL,
                                  role VARCHAR(50) NOT NULL,
                                  address VARCHAR(50) NOT NULL, 
                                  zipcode VARCHAR (50) NOT NULL,
                                  city VARCHAR (50) NOT NULL, 
                                  approved BOOLEAN NOT NULL, 
                                  reg_date TIMESTAMP
                                  )", "portal");
?>