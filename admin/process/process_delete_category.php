<?php

session_start();
require_once '../classes/Category.php';

$c = new Category;

$cat_id = $_GET['cid'] ?? null;

if ($cat_id) {
    $c->delete_from_category($cat_id);
}

header('location: ../admin_view_category.php');
exit;
