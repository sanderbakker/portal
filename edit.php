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
$formBuilder = new FormBuilder();

$formBuilder->submitEditForm('editName', 'newName', "name");
$formBuilder->submitEditForm('editSurname', 'newSurname', "surname");
$formBuilder->submitEditForm('editEmail', 'newEmail', "email");

$formBuilder->submitUsername('editUsername', 'newUsername');

$formBuilder->submitEditForm('editAddress', 'newAddress', "address");
$formBuilder->submitEditForm('editZipcode', 'newZipcode', "zipcode");
$formBuilder->submitEditForm('editCity', 'newCity', "city");

$formBuilder->submitUserInfo('editSkills', 'newSkills', 'skills');
$formBuilder->submitUserInfo('editOther', 'newOther', 'other');
$formBuilder->submitUserInfo('editAvailability', 'newAvailability', 'availability');
$formBuilder->submitUserInfo('editRegion', 'newRegion', 'region');

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
    case 'availability':
        echo $formBuilder->buildEditForm("availability", $_SESSION['availability'], 'New Availability', "newAvailability", 'editAvailability');
        break;
    case 'skills':
        echo $formBuilder->buildCommentForm("skills", $_SESSION['skills'], "Write down some of your computer skills", "newSkills", "editSkills");
        break;
    case 'other':
        echo $formBuilder->buildCommentForm("other", $_SESSION['other'], "Write down some other things like your hobby or things we need to know", "newOther", "editOther");
        break;
    case 'region':
        echo $formBuilder->buildEditForm("region", $_SESSION['region'], "Enter one main region", "newRegion", "editRegion");
        break;
    default: {
        echo "404";
    }

    // QUERY SOON "SELECT * FROM user_info WHERE userId='$userId'"
}
?>