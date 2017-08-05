<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 29-7-2017
 * Time: 10:44
 */
if($_SESSION['role'] != 'admin'){
    header("location: ../user/index.php");
}