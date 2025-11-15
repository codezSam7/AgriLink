<?php

session_start();
require_once '../classes/Shipping.php';
$s = new Shipping;

if (isset($_POST['save_shipping'])) {
    $address = $_POST['address'];
    $state_id = $_POST['state_id'];
    $lga_id = $_POST['lga_id'];
    $method = $_POST['shipping_method'];

    if (empty($address)) {
        $_SESSION['errormsg'] = 'Enter your address';
        header('location:../order_confirm.php');
        exit;
    }
}
