<?php
session_start();
require_once 'classes/Logistics.php';
require_once 'classes/Buyer.php';
require_once 'config/constants.php';

$l = new Logistics();
$b = new Buyer();

if (!isset($_SESSION['logistic_online'])) {
    $_SESSION['errormsg'] = 'You have to be logged in first';
    header('location: logistics_login.php');
    exit;
}

$logistic = $l->get_logistics_details($_SESSION['logistic_online']);

if (!$logistic || !isset($logistic['logistics_id'])) {
    $_SESSION['errormsg'] = 'Invalid logistics account. Please login again.';
    header('location: logistics_login.php');
    exit;
}

$logistics_id = $logistic['logistics_id'];
$orders = $l->fetch_assigned_orders($logistics_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logistics Dashboard | AgriLink</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.css">
    <link rel="icon" href="assets/images/logo.png" />
    <link rel="stylesheet" href="assets/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand: #1fa97a;
        }

        body {
            font-family: 'Poppins', system-ui, sans-serif;
            background: linear-gradient(135deg, #f8faf9 0%, #e8f5e9 100%);
            min-height: 100vh;
            padding-top: 90px;
        }

        .dashboard-header {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(15, 81, 50, 0.08);
            padding: 1.75rem 2rem;
            margin-bottom: 2rem;
        }

        .order-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(15, 81, 50, 0.07);
            transition: all 0.3s ease;
        }

        .order-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(15, 81, 50, 0.12);
        }

        .status-badge {
            font-size: 0.85rem;
            padding: 0.35rem 0.9rem;
            border-radius: 50px;
        }

        .btn-update {
            background: var(--brand);
            border: none;
            font-weight: 600;
        }

        .btn-update:hover {
            background: #1a8f66;
        }
    </style>
</head>

<body>

    <?php require_once ROOT_PATH . 'outhead.php'; ?>

    <div class="container py-4">
        <div class="dashboard-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="mb-1 text-success fw-semibold">My Assigned Orders</h2>
                <p class="text-muted mb-0">Manage deliveries and update status in real-time</p>
            </div>
            <div class="text-end">
                <span class="badge bg-success px-3 py-2 fs-6">
                    <i class="fas fa-truck me-2"></i>
                    <?= htmlspecialchars($logistic['name'] ?? 'Logistics Partner') ?>
                </span>
            </div>
        </div>

        <?php require_once ROOT_PATH . 'common/alert.php'; ?>

        <?php if (!empty($orders)): ?>
            <div class="row g-4">
                <?php foreach ($orders as $order):
                    $order_id = $order['order_id'];
                    $buyer = $order['buyer_fullname'] ?? 'N/A';
                    $status = $order['delivery_status'] ?? 'pending';
                    $date = date('M j, Y', strtotime($order['order_date']));

                    $badge_class = match ($status) {
                        'pending'   => 'bg-secondary',
                        'assigned'  => 'bg-info',
                        'picked-up' => 'bg-warning text-dark',
                        'delivered' => 'bg-success',
                        default     => 'bg-light text-dark'
                    };
                ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card order-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="mb-0">Order #<?= htmlspecialchars($order_id) ?></h5>
                                    <span class="status-badge <?= $badge_class ?>">
                                        <?= ucfirst(htmlspecialchars($status)) ?>
                                    </span>
                                </div>

                                <p class="mb-2"><strong>Buyer:</strong> <?= htmlspecialchars($buyer) ?></p>
                                <p class="mb-3"><strong>Placed:</strong> <?= $date ?></p>

                                <!-- Update Status Form -->
                                <form method="POST" action="process/process_update_delivery_status.php">
                                    <input type="hidden" name="order_id" value="<?= htmlspecialchars($order_id) ?>">

                                    <select name="delivery_status" class="form-select mb-3">
                                        <option value="pending" <?= $status == 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="assigned" <?= $status == 'assigned' ? 'selected' : '' ?>>Assigned</option>
                                        <option value="picked-up" <?= $status == 'picked-up' ? 'selected' : '' ?>>Picked Up</option>
                                        <option value="delivered" <?= $status == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                    </select>

                                    <button type="submit" class="btn btn-update btn-success w-100">
                                        <i class="fas fa-sync-alt me-2"></i> Update Status
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
                <h4 class="text-muted">No orders assigned yet</h4>
                <p class="text-muted">New delivery requests will appear here once assigned to you.</p>
            </div>
        <?php endif; ?>
    </div>

    <script src="<?= BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>