<?php
session_start();
require_once 'classes/Logistics.php';
require_once 'classes/Buyer.php';

$l = new Logistics;
$b = new Buyer;

if (! isset($_SESSION['logistic_online'])) {
    $_SESSION['errormsg'] = 'You have to be logged in first';
    header('location: logistics_login.php');
    exit;
}

$logistic = $l->get_logistics_details($_SESSION['logistic_online']);

if (! $logistic || ! isset($logistic['logistics_id'])) {
    $_SESSION['errormsg'] = 'Invalid logistics account. Please login again.';
    header('location: logistics_login.php');
    exit;
}

$logistics_id = $logistic['logistics_id'];
$orders = $l->fetch_assigned_orders($logistics_id);

// echo '<pre>';
// print_r($logistic);
// echo '</pre>';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logistics Dashboard | AgriLink</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.css">
    <link rel="icon" href="assets/images/logo.png" />
    <link rel="stylesheet" href="assets/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: "Poppins", sans-serif;
            background: linear-gradient(180deg, #f3fff8 0%, #e8f5e9 100%);
            margin: 0;
            padding: 0;
        }

        <?php require_once 'assets/style.php' ?>
        .con {
            margin-top: 3%;
        }
    </style>
</head>
<body>
<div class="container py-5 con my-5">
    <?php require_once 'outhead.php' ?>
    <h3 class="mb-2 mt-5 text-success">My Assigned Orders</h3>

    <?php if (! empty($orders)) { ?>
        <div class="row g-3">
            <?php require_once 'common/alert.php' ?>

            <?php foreach ($orders as $order) {
                $order_id = $order['order_id'];
                $buyer = $order['buyer_fullname'];
                $status = $order['delivery_status'];
                $date = date('M j, Y', strtotime($order['order_date']));

                switch ($status) {
                    case 'pending':
                        $badge = 'bg-secondary';
                        break;
                    case 'assigned':
                        $badge = 'bg-info';
                        break;
                    case 'picked-up':
                        $badge = 'bg-warning text-dark';
                        break;
                    case 'delivered':
                        $badge = 'bg-success';
                        break;
                    default:
                        $badge = 'bg-light';
                }
                ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-sm p-3">
                    <h6>Order #<?php echo $order_id; ?></h6>
                    <p class="mb-1"><strong>Buyer:</strong> <?php echo $buyer; ?></p>
                    <p class="mb-1"><strong>Placed on:</strong> <?php echo $date; ?></p>
                    <p class="mb-1"><strong>Delivery Status:</strong> <?php echo $status; ?></p>

                    <!-- Update Delivery Status Form -->
                    <form method="POST" action="process/process_update_delivery_status.php">
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                        <select name="delivery_status" class="form-select mb-2">
                            <option value="pending" <?php if ($status == 'pending') {
                                echo 'selected';
                            } ?>>Pending</option>
                            <option value="assigned" <?php if ($status == 'assigned') {
                                echo 'selected';
                            } ?>>Assigned</option>
                            <option value="picked-up" <?php if ($status == 'picked-up') {
                                echo 'selected';
                            } ?>>Picked Up</option>
                            <option value="delivered" <?php if ($status == 'delivered') {
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


 <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>
