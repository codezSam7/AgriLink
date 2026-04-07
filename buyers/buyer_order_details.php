<?php
session_start();
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../classes/Buyer.php';

if (!isset($_SESSION['buyer_online'])) {
    header("location: " . BASE_URL . "login_buyer.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("location: " . BASE_URL . "buyers/buyer_orders.php");
    exit;
}

$b = new Buyer();
$order_id = (int) $_GET['id'];

$order_items = $b->fetch_order($order_id);

if (empty($order_items)) {
    echo "Order not found.";
    exit;
}

$order_status = $order_items[0]['delivery_status'];
$payment_status = $order_items[0]['pay_status'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Details - AgriLink</title>

    <link rel="stylesheet" href="<?= BASE_URL ?>assets/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/fontawesome/css/all.css">

    <style>
        :root {
            --brand: #1fa97a;
            --brand-dark: #0f5132;
        }

        body {
            font-family: 'Poppins', system-ui, sans-serif;
            background: linear-gradient(135deg, #f8faf9 0%, #e8f5e9 100%);
            min-height: 100vh;
            padding-top: 90px;
        }

        .product-img {
            height: 80px;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <?php require_once ROOT_PATH . "outhead.php"; ?>

    <div class="container py-5">
        <h2 class="text-success mb-4">Order Details</h2>

        <div class="mb-4">
            <span class="badge bg-success"><?= $order_status ?></span>
            <span class="badge bg-secondary"><?= $payment_status ?></span>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th></th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $grand_total = 0; ?>

                        <?php foreach ($order_items as $item):
                            $total = $item['product_price'] * $item['detail_qty'];
                            $grand_total += $total;
                        ?>
                            <tr>
                                <td>
                                    <img src="<?= BASE_URL ?>uploads/<?= $item['product_image'] ?>"
                                        class="product-img rounded">
                                </td>

                                <td><?= htmlspecialchars($item['product_name']) ?></td>

                                <td>₦<?= number_format($item['product_price']) ?></td>

                                <td><?= $item['detail_qty'] ?></td>

                                <td class="text-success fw-bold">
                                    ₦<?= number_format($total) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="text-end mt-4">
                    <h4 class="text-success">
                        Grand Total: ₦<?= number_format($grand_total) ?>
                    </h4>
                </div>

            </div>
        </div>

        <a href="<?= BASE_URL ?>buyers/buyer_orders.php" class="btn btn-outline-secondary mt-4">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>

    <script src="<?= BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>