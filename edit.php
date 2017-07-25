<style>
    .alerts {
        left: 120px;
        right: 85px;
        top: 60px;
    }
    .alert{
        border-radius: 0; !important;
    }
    .container{
        margin-top: 15px;
    }
    .panel-body{
        margin-top: 15px;
    }

</style>
<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 24-7-2017
 * Time: 21:46
 */
include "includes.php";
include "AlertBuilder.php";
include "navbar.php";
$edit = $_GET['edit'];
$id = $_SESSION['id'];
$database = new Database('localhost', 'root', '');
$alertBuilder = new AlertBuilder();
if(isset($_POST['editName'])){
    $newName = $_POST['newName'];
    if(!empty($newName) && ctype_alpha($newName)) {
        $query = "UPDATE Users
              SET firstname='$newName'
              WHERE id='$id'";
        if($database->insertInTable("portal", $query)) {
            $_SESSION['name'] = $newName;
            echo $alertBuilder->createAlert( "Changed name successfully in $newName", 'succes');
        }
        else{
            echo $alertBuilder->createAlert("Failed to change name", "danger");
        }
    }
    else{
        echo $alertBuilder->createAlert("Name can not be empty or contain numbers", "danger");
    }
}
if(isset($_POST['editSurname'])){
    $newValue = $_POST['newSurname'];
    if(!empty($newValue) && ctype_alpha($newValue)) {
        $query = "UPDATE Users
              SET lastname='$newValue'
              WHERE id='$id'";
        if ($database->insertInTable("portal", $query)) {
            $_SESSION['surname'] = $newValue;
            echo $alertBuilder->createAlert("Changed surname successfully in $newValue", 'succes');
        } else {
            echo $alertBuilder->createAlert("Failed to change surname", "danger");
        }
    }
    else{
        echo $alertBuilder->createAlert("Surname can not be empty or contain numbers", "danger");
    }
}
if(isset($_POST['editEmail'])){
    $newValue = $_POST['newEmail'];
    if(!empty($newValue)) {
        $query = "UPDATE Users
              SET lastname='$newValue'
              WHERE id='$id'";
        if ($database->insertInTable("portal", $query)) {
            $_SESSION['email'] = $newValue;
            echo $alertBuilder->createAlert("Changed email successfully in $newValue", 'succes');
        } else {
            echo $alertBuilder->createAlert("Failed to change email", "danger");
        }
    }
    else{
        echo $alertBuilder->createAlert("Email can not be empty", "danger");
    }
}
if(isset($_POST['editUsername'])){
    $newValue = $_POST['newUsername'];
    if(!empty($newValue)) {
        $query = "UPDATE Users
              SET lastname='$newValue'
              WHERE id='$id'";
        if ($database->insertInTable("portal", $query)) {
            $_SESSION['username'] = $newValue;
            echo $alertBuilder->createAlert("Changed username successfully in $newValue", 'succes');
        } else {
            echo $alertBuilder->createAlert("Failed to username email", "danger");
        }
    }
    else{
        echo $alertBuilder->createAlert("Username can not be empty", "danger");
    }
}
if(isset($_POST['editAddress'])){
    $newValue = $_POST['newAddress'];
    if(!empty($newValue)) {
        $query = "UPDATE Users
              SET lastname='$newValue'
              WHERE id='$id'";
        if ($database->insertInTable("portal", $query)) {
            $_SESSION['address'] = $newValue;
            echo $alertBuilder->createAlert("Changed address successfully in $newValue", 'succes');
        } else {
            echo $alertBuilder->createAlert("Failed to change address", "danger");
        }
    }
    else{
        echo $alertBuilder->createAlert("Address can not be empty", "danger");
    }
}
if(isset($_POST['editZipcode'])){
    $newValue = $_POST['newZipcode'];
    if(!empty($newValue)) {
        $query = "UPDATE Users
              SET lastname='$newValue'
              WHERE id='$id'";
        if ($database->insertInTable("portal", $query)) {
            $_SESSION['zipcode'] = $newValue;
            echo $alertBuilder->createAlert("Changed zipcode successfully in $newValue", 'succes');
        } else {
            echo $alertBuilder->createAlert("Failed to change zipcode", "danger");
        }
    }
    else{
        echo $alertBuilder->createAlert("Zipcode can not be empty", "danger");
    }
}
if(isset($_POST['editCity'])){
    $newValue = $_POST['newCity'];
    if(!empty($newValue) && ctype_alpha($newValue)) {
        $query = "UPDATE Users
              SET lastname='$newValue'
              WHERE id='$id'";
        if ($database->insertInTable("portal", $query)) {
            $_SESSION['city'] = $newValue;
            echo $alertBuilder->createAlert("Changed city successfully in $newValue", 'succes');
        } else {
            echo $alertBuilder->createAlert("Failed to change city", "danger");
        }
    }
    else{
        echo $alertBuilder->createAlert("City can not be empty or contain numbers", "danger");
    }
}
switch ($edit){
    case 'name':
        ?>
        <div class="container">
        <div class="col-md-4 mx-auto">
            <div class="panel panel-default">
                <div class="panel-header">
                    <h4>Edit name</h4>
                </div>
                <div class="panel-body">
                    <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="" name="name" type="text" readonly value=<?php echo $_SESSION['name']?>>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="New Name" name="newName" type="text">
                            </div>
                            <input class="btn btn-info btn-block" name="editName" type="submit" value="Edit">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <?php
        break;
    case 'surname':
        ?>
        <div class="container">
            <div class="col-md-4 mx-auto">
                <div class="panel panel-default">
                    <div class="panel-header">
                        <h4>Edit surname</h4>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="" name="name" type="text" readonly value=<?php echo $_SESSION['surname']?>>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="New Surname" name="newSurname" type="text">
                                </div>
                                <input class="btn btn-info btn-block" name="editSurname" type="submit" value="Edit">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        break;
    case 'email':
        ?>
        <div class="container">
            <div class="col-md-4 mx-auto">
                <div class="panel panel-default">
                    <div class="panel-header">
                        <h4>Edit email</h4>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="" name="name" type="text" readonly value=<?php echo $_SESSION['email']?>>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="New Email" name="newEmail" type="text">
                                </div>
                                <input class="btn btn-info btn-block" name="editEmail" type="submit" value="Edit">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        break;
    case 'username':
        ?>
        <div class="container">
            <div class="col-md-4 mx-auto">
                <div class="panel panel-default">
                    <div class="panel-header">
                        <h4>Edit username</h4>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="" name="name" type="text" readonly value=<?php echo $_SESSION['username']?>>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="New Username" name="newUsername" type="text">
                                </div>
                                <input class="btn btn-info btn-block" name="editUsername" type="submit" value="Edit">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        break;
    case 'address':
        ?>
        <div class="container">
            <div class="col-md-4 mx-auto">
                <div class="panel panel-default">
                    <div class="panel-header">
                        <h4>Edit address</h4>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="" name="name" type="text" readonly value=<?php echo $_SESSION['address']?>>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="New Address" name="newAddress" type="text">
                                </div>
                                <input class="btn btn-info btn-block" name="editAddress" type="submit" value="Edit">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        break;
    case 'zipcode':
        ?>
        <div class="container">
            <div class="col-md-4 mx-auto">
                <div class="panel panel-default">
                    <div class="panel-header">
                        <h4>Edit zipcode</h4>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="" name="name" type="text" readonly value=<?php echo $_SESSION['zipcode']?>>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="New Zipcode" name="newZipcode" type="text">
                                </div>
                                <input class="btn btn-info btn-block" name="ediZipcode" type="submit" value="Edit">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        break;
    case 'city':
        ?>
        <div class="container">
            <div class="col-md-4 mx-auto">
                <div class="panel panel-default">
                    <div class="panel-header">
                        <h4>Edit city</h4>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="" name="name" type="text" readonly value=<?php echo $_SESSION['city']?>>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="New City" name="newCity" type="text">
                                </div>
                                <input class="btn btn-info btn-block" name="editCity" type="submit" value="Edit">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        break;
    default: {
        echo "404";
    }
}
?>