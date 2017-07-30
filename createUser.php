<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 29-7-2017
 * Time: 10:37
 */
include "includes.php";
include 'navbar.php';
include "adminCheck.php";
function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}
$password = random_str(32);
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
            <p>As admin you can a users in this section, keep the following in mind:</p>
                <ul>
                <li>All fields are required</li>
                <li>When you create an account here, this account is automatically approved</li>
                <li>Roles can be change in the section user actions and should not be defined here</li>
                <li>Password is automatically generated, but can also be defined by the creator</li>
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
