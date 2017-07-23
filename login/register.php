<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script><link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/>
<link rel="stylesheet" href="../css/style.css" type="text/css">
<style>
    img {
        display: block; !important;
        margin: auto; !important;

    }
    .information {
        display: none;
    }
    .vertical-align{
        margin-top: 125px; !important;
    }
    .alerts {
        position: absolute;
        left: 120px;
        right: 85px;
        top: 60px;

        }


</style>
<script>

    $(".alert").alert('close');
</script>
<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 21-7-2017
 * Time: 11:46
 */

require "../database/Database.php";
if(isset($_POST['registerMe'])) {
    $username = $_POST['username'];
    $password = $_POST["password"];
    $rpassword = $_POST["rpassword"];
    $city = $_POST["city"];
    $zipcode = $_POST['zipcode'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $street = $_POST['streetname'];
    $database = new Database("localhost", "root", "");

    if(!empty($username) && !empty($password) && !empty($rpassword) && !empty($zipcode) && !empty($email) && !empty($name) && !empty($street) && !empty($surname) && !empty($city)) {
        if (($rpassword == $password)) {
            if (!$database->checkUsername($username)) {
                $query = "INSERT INTO users (username, password, firstname, lastname, email, address, role, zipcode, city, approved)
              VALUES ('$username', '$password', '$name', '$surname', '$email', '$street', 'user', '$zipcode', '$city', false)";
                //$database->insertInTable("portal", $query);
                if ($database->insertInTable("portal", $query)) {
                    echo "<div class='alerts'>
                <div class='alert alert-success' role='alert'>
                    <strong>Success</strong> Regisitration completed.
                </div>
              </div>";
                } else {
                    echo "<div class='alerts'>
                <div class='alert alert-danger' role='alert'>
                    <strong>Error</strong> Regisitration failed (Database Error).
                </div>
              </div>";
                }
            } else {
                echo "<div class='alerts'>
                <div class='alert alert-danger' role='alert'>
                    <strong>Error</strong> Username already exists.
                </div>
              </div>";
            }
        } else {
            echo "<div class='alerts'>
                <div class='alert alert-danger' role='alert'>
                    <strong>Error</strong> Passwords don't match.
                </div>
              </div>";
        }
    }
    else{
        echo "<div class='alerts'>
                <div class='alert alert-danger' role='alert'>
                    <strong>Error</strong> All fields should be filled in.
                </div>
              </div>";
    }
}
?>
<div class="container"></div>
<h2><!--<a href="../index.php" role="button" class="btn btn-info btn-circle"><i class="fa fa-home"></i></a>--><button class="btn btn-info btn-circle"><i class="fa fa-info"></i></button></h2>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-6 vertical-align">
            <div class="panel-heading">
                <img src="../assets/logo.png">
            </div>
        </div>
        <div class="col-md-6 vertical-align">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Name" name="name" type="text">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Surname" name="surname" type="text">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Username" name="username" type="text">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Email" name="email" type="text">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-control" placeholder="Password" name="password" type="password">
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" placeholder="Repeat Password" name="rpassword" type="password">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="form-control" placeholder="Zipcode" name="zipcode" type="text">
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" placeholder="Streetname" name="streetname" type="text">
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" placeholder="City" name="city" type="text">
                                    </div>
                                </div>
                            </div>
                            <input class="btn btn-info btn-block" name="registerMe" type="submit" value="Register">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>


