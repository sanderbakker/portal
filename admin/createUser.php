<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 29-7-2017
 * Time: 10:37
 */
include "../includes/includes.php";
include '../includes/navbar.php';
include "../includes/adminCheck.php";
include "../classes/alertBuilder.php";

function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}
$alertBuilder = new AlertBuilder();
$password = random_str(32);
if(isset($_POST['createUser'])){
    if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['zipcode']) && !empty($_POST['phone'])
            &&!empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['city']) && !empty($_POST['password'])
            && !empty($_POST['streetname'])){
        $username = $_POST['username'];
        $name= $_POST['name'];
        $surname = $_POST['surname'];
        $zipcode = $_POST[ 'zipcode'];
        $phone = $_POST['phone'];
        $city = $_POST['city'];
        $email = $_POST['email'];
        $newPassword = $_POST['password'];
        $street = $_POST['streetname'];
        if(!$database->check("SELECT * FROM users WHERE username='$username'")) {
            $encryptedPassword = $database->encryptSSL($newPassword);
            $query = "INSERT INTO Users 
                                                             (name, surname, password, username, phone, email, role, address, zipcode, city, approved) VALUES 
                                                             ('$name', '$surname', '$encryptedPassword', '$username', '$phone'
                                                             , '$email', 'user', '$street', '$zipcode', '$city', true)";
            if ($database->executeQuery("portal", $query))
            {
                echo $alertBuilder->createAlert("User successfully added to the system", "success");
            }
            else{
                echo $alertBuilder->createAlert("An error occurred ", "danger");
            }
        }
        else{
            echo $alertBuilder->createAlert("Username already in use", "danger");
        }

    }
    else{
        echo $alertBuilder->createAlert("Not all fields are filled in", "danger");
    }

}

?>

<style>
    h3{
        font-family: 'Roboto', sans-serif;
        margin-top: 15px;
    }
    form{
        margin-top: 15px;
    }


</style>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h3>Adding a user</h3>
            <p>As admin you can create users in this section, keep the following in mind:</p>
                <ul>
                <li>All fields are required</li>
                <li>When you create an account here, this account is automatically approved</li>
                <li>Roles can be change in the section user actions and should not be defined here</li>
                <li>Password is automatically generated, but can also be defined by the creator</li>
                <li>After clicking create the password will be encrypted through OpenSSL</li>
                </ul>

        </div>
        <div class="col-md-6">
            <h3>User details</h3>
            <form method="post">
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

                            <input class="form-control" placeholder="Password" name="password" value='<?php echo $password?>' type="text">
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Phone" name="phone" type="text">
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
                    <input class="btn btn-info btn-block" name="createUser" type="submit" value="Create">
                </fieldset>
            </form>

        </div>
    </div>
</div>
