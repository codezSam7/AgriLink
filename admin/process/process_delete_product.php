<?php

session_start();
require_once '../classes/Admin.php';

$a = new Admin;

$pro_id = $_GET['id'] ?? null;

if ($pro_id) {
    $a->delete_from_products($pro_id);
}
$_SESSION["msg"] = "Produce deleted successfully";
header('location: ../admin_manage_products.php');
exit;
