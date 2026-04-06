<?php
session_start();
require_once '../config/constants.php';
require_once '../classes/Buyer.php';

if (!isset($_SESSION['buyer_online'])) {
    header("location: " . BASE_URL . "login_buyer.php");
    exit;
}

$b = new Buyer();
$buyer_id = $_SESSION['buyer_online'];

$orders = $b->get_buyer_orders($buyer_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Orders - AgriLink</title>
    <link rel="icon" href="<?= BASE_URL ?>assets/images/logo.png" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/animate.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/fontawesome/css/all.css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

        .order-card {
            border-left: 5px solid #1fa97a;
        }
    </style>
</head>

<body>

    <?php require_once ROOT_PATH . "outhead.php"; ?>

    <div class="container py-5">
        <h2 class="mb-4 text-success">My Orders</h2>

        <?php if (!empty($orders)): ?>
            <div class="row g-4">
                <?php foreach ($orders as $order): ?>
                    <div class="col-12">
                        <div class="card order-card shadow-sm">
                            <div class="card-body d-flex justify-content-between align-items-center flex-wrap">

                                <div>
                                    <h5 class="mb-1">Order #<?= $order['order_id'] ?></h5>
                                    <small class="text-muted">
                                        <?= date('F j, Y', strtotime($order['order_date'])) ?>
                                    </small>
                                </div>

                                <div>
                                    <span class="badge bg-success">
                                        <?= $order['delivery_status'] ?>
                                    </span>
                                    <span class="badge bg-secondary">
                                        <?= $order['pay_status'] ?? 'Pending' ?>
                                    </span>
                                </div>

                                <div>
                                    <strong class="text-success">
                                        ₦<?= number_format($order['total_amount']) ?>
                                    </strong>
                                </div>

                                <div>
                                    <a href="<?= BASE_URL ?>buyers/buyer_order_details.php?id=<?= $order['order_id'] ?>"
                                        class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-eye"></i> View Details
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div class="alert alert-info">You have not placed any orders yet.</div>
        <?php endif; ?>
    </div>

    <script src="<?= BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>