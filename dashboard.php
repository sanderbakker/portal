<?php
include "navbar.php";
    $userData = $database->getUserById($_SESSION['id']);
    $userInfo = $database->getUserInfoById($_SESSION['id']);
    $_SESSION['other'] = $userInfo['other'];
    $_SESSION['availability'] = $userInfo['availability'];
    $_SESSION['skills'] = $userInfo['skills'];
    $_SESSION['region'] = $userInfo['region'];
    $_SESSION['name'] = $userData['name'];
    $_SESSION['surname'] = $userData['surname'];
    $_SESSION['username'] = $userData['username'];
    $_SESSION['email'] = $userData['email'];
    $_SESSION['role'] = $userData['role'];
    $_SESSION['address'] = $userData['address'];
    $_SESSION['zipcode'] = $userData['zipcode'];
    $_SESSION['city'] = $userData['city'];

?>
