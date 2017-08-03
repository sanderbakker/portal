<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 23-7-2017
 * Time: 16:03
 */
session_start();
session_destroy();
header("location: login.php?status=loggedOut");
