<?php
session_start();
require_once("../classes/Cart.php");
if (!isset($_GET["id"]) || !isset($_SESSION["buyer_online"])) {
    $_SESSION["errormsg"] = "Invalid action";
    header("location:../products.php");
    exit;
}

$product_id = $_GET["id"];
$buyer_id = $_SESSION["buyer_online"];
$carts = new Cart;

$recipe_dey_before = $carts->check_if_added_before($product_id, $buyer_id);
if ($recipe_dey_before == false) {
    $added = $carts->add_to_cart($product_id, $buyer_id, 1);
} else {
    $added = $carts->update_cart_item($product_id, $buyer_id, $recipe_dey_before);
}

if ($added) {
    $_SESSION["msg"] = "Product added to cart successfully" . "✔";
    header("location:../products.php");
    exit;
} else {
    $_SESSION["errormsg"] = "Something went wrong" . "😢" . "," . "try again";
    header("location:../products.php");
    exit;
}
