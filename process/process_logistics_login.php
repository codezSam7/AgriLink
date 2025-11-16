<?php

session_start();
require_once '../classes/Logistics.php';
$l = new Logistics;

if (isset($_POST['btn'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($fullname) || empty($email) || empty($password)) {
        $_SESSION['errormsg'] = 'All fields are required';
        header('location:../logistics_login.php');
        exit;
    }

    $response = $l->login_logistics($fullname, $email, $password);

    if ($response) {
        $_SESSION['msg'] = "$fullname, You are logged in successfully";
        header('location:../logistics.php');
        exit;
    } else {
        $_SESSION['errormsg'] = 'Error occured, please try again';
        header('location:../logistics_login.php');
        exit;
    }

} else {
    $_SESSION['errormsg'] = 'Please complete the form';
    header('location:../logsitics_login.php');
    exit;
}
