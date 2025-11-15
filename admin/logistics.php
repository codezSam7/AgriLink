<?php
session_start();
require_once 'classes/Logistics.php'; // create this class
require_once '../classes/Buyer.php';
require_once '../classes/Cart.php'; // optional if you want product details

// // Make sure logistics is logged in
// if (! isset($_SESSION['logistics_online'])) {
//     $_SESSION['errormsg'] = 'Please log in first';
//     header('Location: logistics_login.php');
//     exit;
// }

$logistics_id = $_SESSION['logistics_online'];
$l = new Logistics;
$b = new Buyer;

// Fetch all orders assigned to this rider
$orders = $l->fetch_assigned_orders($logistics_id);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Logistics Dashboard | AgriLink</title>
<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="../assets/fontawesome/css/all.css">
</head>
<body>
<div class="container py-5">
    <h3 class="mb-4">My Assigned Orders</h3>

    <?php if (! empty($orders)) { ?>
        <div class="row g-3">
        <?php foreach ($orders as $order) {
            $order_id = $order['order_id'];
            $buyer = $order['buyer_fullname'];
            $status = $order['delivery_status'];
            $date = date('M j, Y', strtotime($order['order_date']));
            ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-sm p-3">
                    <h6>Order #<?php echo $order_id; ?></h6>
                    <p class="mb-1"><strong>Buyer:</strong> <?php echo $buyer; ?></p>
                    <p class="mb-1"><strong>Placed on:</strong> <?php echo $date; ?></p>
                    <p class="mb-1"><strong>Delivery Status:</strong> <?php echo ucfirst($status); ?></p>

                    <!-- Update Delivery Status Form -->
                    <form method="POST" action="process/update_delivery_status.php">
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                        <select name="delivery_status" class="form-select mb-2">
                            <option value="assigned"   <?php if ($status == 'assigned') {
                                echo 'selected';
                            } ?>>Assigned</option>
                            <option value="picked"     <?php if ($status == 'picked') {
                                echo 'selected';
                            } ?>>Picked Up</option>
                            <option value="in-transit" <?php if ($status == 'in-transit') {
                                echo 'selected';
                            } ?>>In Transit</option>
                            <option value="delivered"  <?php if ($status == 'delivered') {
                                echo 'selected';
                            } ?>>Delivered</option>
                        </select>
                        <button class="btn btn-success btn-sm w-100" type="submit">Update Status</button>
                    </form>
                </div>
            </div>
        <?php } ?>
        </div>
    <?php } else { ?>
        <p class="text-muted">No orders assigned yet.</p>
    <?php } ?>
</div>
</body>
</html>
