<?php

session_start();
require_once '../classes/Admin.php';

$a = new Admin;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'] ?? null;
    $logistics_id = $_POST['logistics_id'] ?? null;

    if ($order_id && $logistics_id) {
        $success = $a->assign_logistics($order_id, $logistics_id);

        if ($success) {
            $_SESSION['msg'] = 'Logistics assigned successfully!';
        } else {
            $_SESSION['errormsg'] = 'Failed to assign logistics.';
        }
    } else {
        $_SESSION['errormsg'] = 'Please select a rider.';
    }
}

header('location: ../admin_view_orders.php');
exit;
