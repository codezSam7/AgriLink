<?php
session_start();
require_once("../classes/Farmer.php");
$f = new Farmer;

if (isset($_POST["btn"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $_SESSION["errormsg"] = "All fields are required";
        header("location:../farmers/login_farmer.php");
        exit;
    }

    $response = $f->login_farmer($email, $password);

    if ($response) {
        $_SESSION["msg"] = "You are logged in successfully";
        header("location:../index.php");
        exit;
    } else {
        $_SESSION["errormsg"] = "Error occured, please try again";
        header("location:../farmers/login_farmer.php");
        exit;
    }
} else {
    $_SESSION["errormsg"] = "Please complete the form";
    header("location:../farmers/login_farmer.php");
    exit;
}
