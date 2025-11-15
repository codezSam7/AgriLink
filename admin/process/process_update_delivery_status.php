<?php

session_start();
require_once '../classes/Logistics.php';

if (! isset($_SESSION['logistics_online'])) {
    $_SESSION['errormsg'] = 'Please log in first';
    header('Location: logistics_login.php');
    exit;
}

$l = new Logistics;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'] ?? null;
    $status = $_POST['delivery_status'] ?? null;

    if ($order_id && $status) {
        $success = $l->update_delivery_status($order_id, $status);
        if ($success) {
            $_SESSION['msg'] = 'Delivery status updated successfully!';
        } else {
            $_SESSION['errormsg'] = 'Failed to update delivery status.';
        }
    } else {
        $_SESSION['errormsg'] = 'Invalid request.';
    }
}

header('location: ../logistics_dashboard.php');
exit;
