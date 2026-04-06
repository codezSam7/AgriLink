<?php
session_start();
require_once "../classes/Admin.php";
$admin = new Admin;

if (isset($_POST["btn"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        $_SESSION["errormsg"] = "All fields are required";
        header("location:../ad_login.php");
        exit;
    }

    $response = $admin->login_admin($username, $password);

    if ($response) {
        $_SESSION["msg"] = "You have logged in successfully";
        header("location:../admin.php");
        exit;
    } else {
        $_SESSION["errormsg"] = "Error occured, please try again later";
        header("location:../ad_login.php");
        exit;
    }
} else {
    header("location:../ad_login.php");
    exit;
}
