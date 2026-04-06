<?php
if (!isset($_SESSION["admin_online"])) {
    $_SESSION["errormsg"] = "You have to be logged in as an admin";
    header("location:ad_login.php");
    exit;
}
