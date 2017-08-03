<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 24-7-2017
 * Time: 21:39
 */
if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}
if(isset($_SESSION['loggedIn']) &&    $_SESSION['loggedIn']==false){
    header("location: ../login/login.php");
}