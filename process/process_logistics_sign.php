<?php

session_start();
require_once __DIR__ . '/../classes/Logistics.php';
$l = new Logistics;

if (isset($_POST['btn'])) {
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['cpassword'];
    $address = $_POST['address'];

    if (empty($fullname) || empty($phone) || empty($email) || empty($password) || empty($address)) {
        $_SESSION['errormsg'] = 'All the fields are required';
        header('location:../logistics_sign.php');
        exit;
    }
    if ($password != $confirm_password) {
        $_SESSION['errormsg'] = 'The two passwords must match';
        header('location:../logistics_sign.php');
        exit;
    }

    $rsp = $l->register_logistics($fullname, $phone, $email, $password, $address);
    if ($rsp) {
        $_SESSION['msg'] = 'An account has been created for you';
        header('location:../logistics_login.php');
        exit;
    } else {
        $_SESSION['errormsg'] = 'Error in creating account, try again later';
        header('location:../logistics_sign.php');
        exit;
    }
} else {
    header('location:../logistics_sign.php');
    exit;
}
