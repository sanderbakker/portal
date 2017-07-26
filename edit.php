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
include "navbar.php";
include "AlertBuilder.php";
include "FormBuilder.php";

$edit = $_GET['edit'];
$id = $_SESSION['id'];
$database = new Database('localhost', 'root', '');
$formBuilder = new FormBuilder();

$formBuilder->submitEditForm('editName', 'newName');
$formBuilder->submitEditForm('editSurname', 'newSurname');
$formBuilder->submitEditForm('editEmail', 'newEmail');

$formBuilder->submitEditForm('editUsername', 'newUsername');

$formBuilder->submitEditForm('editAddress', 'newAddress');
$formBuilder->submitEditForm('editZipcode', 'newZipcode');
$formBuilder->submitEditForm('editCity', 'newCity');

switch ($edit){
    case 'name':
        echo $formBuilder->buildEditForm("name", $_SESSION['name'], "New Name", "newName", "editName");
        break;
    case 'surname':
        echo $formBuilder->buildEditForm("surname", $_SESSION['surname'], "New Surname", "newSurname", "editSurname");
        break;
    case 'email':
        echo $formBuilder->buildEditForm("email", $_SESSION['email'], "New Email", "newEmail", "editEmail");
        break;
    case 'username':
        echo $formBuilder->buildEditForm("username", $_SESSION['username'], "New Username", "newUsername", "editUsername");
        break;
    case 'address':
        echo $formBuilder->buildEditForm("address", $_SESSION['address'], "New Address", "newAddress", "editAddress");
        break;
    case 'zipcode':
        echo $formBuilder->buildEditForm("zipcode", $_SESSION['zipcode'], "New Zipcode", "newZipcode", "editZipcode");
        break;
    case 'city':
        echo $formBuilder->buildEditForm("city", $_SESSION['city'], "New City", "newCity", "editCity");
        break;
    default: {
        echo "404";
    }
}
?>