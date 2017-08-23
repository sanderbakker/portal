<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 21-8-2017
 * Time: 19:59
 */
include "../includes/includes.php";
include '../includes/navbar.php';
include "../classes/alertBuilder.php";


$alertBuilder = new AlertBuilder();

if(isset($_POST['createCustomer'])){
    if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['zipcode']) && !empty($_POST['phone'])
        &&!empty($_POST['email']) && !empty($_POST['city']) && !empty($_POST['company'])
        && !empty($_POST['streetname'])){

        $name= $_POST['name'];
        $surname = $_POST['surname'];
        $zipcode = $_POST[ 'zipcode'];
        $phone = $_POST['phone'];
        $city = $_POST['city'];
        $email = $_POST['email'];
        $street = $_POST['streetname'];
        $company = $_POST['company'];

        $checkCustomer = $database->getConnection()->prepare("SELECT * FROM customers WHERE email = ?");
        $checkCustomer->bind_param('s', $email);

        if(!$database->check($checkCustomer)) {

            $query = "INSERT INTO customers 
                        (name, surname, company, phone, email, address, zipcode, city) VALUES 
                        ('$name', '$surname', '$company', '$phone'
                        ,'$email', '$street', '$zipcode', '$city')";
            if ($database->executeQuery("portal", $query))
            {
                echo $alertBuilder->createAlert("Customer successfully added to the system", "success");
            }
            else{
                echo $alertBuilder->createAlert("An error occurred ", "danger");
            }
        }
        else{
            echo $alertBuilder->createAlert("This customer is already registered to SPortal", "danger");
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
            <h3>Adding a customer</h3>
            <p>Customer can be added by filling in the form on the right, please keep to following in mind:</p>
            <ul>
                <li>All fields are required</li>
                <li>Afterwards this customer can directly request assignments or the admin can create on for you</li>
            </ul>

        </div>
        <div class="col-md-6">
            <h3>Customer details</h3>
            <form method="post">
                <fieldset>
                    <div class="form-group">
                        <input class="form-control" placeholder="Name" name="name" type="text">
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Surname" name="surname" type="text">
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Email" name="email" type="text">
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Company" name="company" type="text">
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
                    <input class="btn btn-info btn-block" name="createCustomer" type="submit" value="Create">
                </fieldset>
            </form>

        </div>
    </div>
</div>