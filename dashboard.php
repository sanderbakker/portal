<?php
include "navbar.php";
    $userData = $database->getUserById($_SESSION['id']);
    $_SESSION['name'] = $userData['firstname'];
    $_SESSION['surname'] = $userData['lastname'];
    $_SESSION['username'] = $userData['username'];
    $_SESSION['email'] = $userData['email'];
    $_SESSION['role'] = $userData['role'];
    $_SESSION['address'] = $userData['address'];
    $_SESSION['zipcode'] = $userData['zipcode'];
    $_SESSION['city'] = $userData['city'];
?>
