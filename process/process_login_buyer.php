<?php
session_start();
require_once __DIR__ . '/../classes/Buyer.php';
$b = new Buyer;

if (isset($_POST["btn"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $_SESSION["errormsg"] = "All fields are required";
        header("location:../buyers/login_buyer.php");
        exit;
    }

    $response = $b->login_buyer($email, $password);

    if ($response) {
        $_SESSION["msg"] = "You are logged in successfully" . "✔";
        header("location:../index.php");
        exit;
    } else {
        $_SESSION["errormsg"] = "Error occured" . "😢" . "," . "try again";
        header("location:../buyers/login_buyer.php");
        exit;
    }
} else {
    $_SESSION["errormsg"] = "Please complete the form";
    header("location:../buyers/login_buyer.php");
    exit;
}
