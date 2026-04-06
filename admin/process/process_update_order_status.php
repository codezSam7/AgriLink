<?php

session_start();
require_once '../classes/Admin.php';

$a = new Admin;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? null;
    $status = $_POST['status'] ?? null;

    if ($order_id && $status) {
        $updated = $a->update_order_status($order_id, $status);

        if ($updated) {
            $_SESSION['msg'] = "Order #$order_id status updated to '" . $status . "' successfully!";
        } else {
            $_SESSION['errormsg'] = 'Failed to update order status.';
        }
    } else {
        $_SESSION['errormsg'] = 'Invalid input.';
    }
} else {
    header('location: ../admin_manage_orders.php');
    exit;
}
header('location: ../admin_manage_orders.php');
exit;
