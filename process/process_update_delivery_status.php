<?php

session_start();
require_once '../classes/Logistics.php';

$l = new Logistics;

isset($_SESSION['logistic_online']) ? $l->get_logistics_details($_SESSION['logistic_online']) : [];

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

header('location: ../logistics.php');
exit;
