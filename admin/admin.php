<?php
session_start();
require_once 'admin_guard.php';
require_once 'classes/Admin.php';
require_once __DIR__ . '/../config/constants.php';

$a = new Admin;
$admin = isset($_SESSION['admin_online']) ? $a->get_admin_details($_SESSION['admin_online']) : [];

$product_count = $a->fetch_products();
$farmer_count = $a->fetch_farmers();
$order_count = $a->fetch_orders();

// echo '<pre>';
// print_r($order_count);
// echo '<pre>';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | AgriLink</title>
    <link rel="icon" href="<?= BASE_URL ?>assets/images/logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/fontawesome/css/all.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-green: #1fa97a;
            --soft-green: #e8f8f0;
            --card-bg: rgba(255, 255, 255, 0.85);
            --sidebar-bg: linear-gradient(180deg, #f3fff8 0%, #e6fff2 100%);
            --glass: rgba(255, 255, 255, 0.55);
        }

        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            background: linear-gradient(180deg, #f3fff8 0%, #e8f5e9 100%);
            min-height: 100vh;
        }

        .container-fluid.con {
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        /* Main content */
        .main-content {
            flex: 1;
            padding: 2rem;
        }

        /* Cards */
        .stat-card {
            border-left: 6px solid rgba(31, 169, 122, 0.16);
            border-radius: 12px;
            color: #083;
            background: var(--card-bg);
            box-shadow: 0 6px 18px rgba(17, 24, 39, 0.05);
        }

        .stat-card .h4 {
            color: rgba(0, 0, 0, 0.7);
        }

        .badge-status {
            padding: .45rem .6rem;
            border-radius: 10px;
            font-weight: 600;
        }

        /* Utilities */
        .icon-circle {
            width: 52px;
            height: 52px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: rgba(31, 169, 122, 0.08);
        }

        @media(max-width:767px) {
            .container-fluid.con {
                flex-direction: column;
            }

            .admin-sidebar {
                width: 100%;
                flex-direction: row;
                justify-content: space-around;
                padding: 1.5rem;
            }

            .main-content {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid con">
        <?php require_once 'admin_sidebar.php' ?>

        <main class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Dashboard</h4>
                <div class="small text-muted">Admin | Overview</div>
            </div>

            <?php require_once ROOT_PATH . 'common/alert.php' ?>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card stat-card p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div>Total orders</div>
                                <div class="h4"><?php echo count($order_count) ?></div>
                            </div>
                            <div class="icon-circle"><i class="bi bi-cart-fill"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card stat-card p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div>Active farmers</div>
                                <div class="h4"><?php echo count($farmer_count) ?></div>
                            </div>
                            <div class="icon-circle"><i class="bi bi-people-fill"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card stat-card p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div>Products listed</div>
                                <div class="h4"><?php echo count($product_count); ?></div>
                            </div>
                            <div class="icon-circle"><i class="bi bi-box-seam"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h6>Recent orders</h6>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Buyer</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($order_count as $order) {
                                $status = $order['delivery_status'];

                                if ($status === 'pending') {
                                    $badgeStyle = 'background:#fff3cd; color:#856404;border:1px solid rgba(0,0,0,0.1)';
                                } elseif ($status === 'assigned') {
                                    $badgeStyle = 'background:#d4edda; color:#155724;border:1px solid rgba(0,0,0,0.1)';
                                } elseif ($status === 'picked-up') {
                                    $badgeStyle = 'background:#f8d7da; color:#721c24;border:1px solid rgba(0,0,0,0.1)';
                                } else {
                                    $badgeStyle = 'background:#e2e3e5; color:#383d41;border:1px solid rgba(0,0,0,0.1)';
                                }
                            ?>
                                <tr>
                                    <td>#<?php echo $order['order_id'] ?></td>
                                    <td><?php echo $order['buyer_fullname'] ?></td>
                                    <td>
                                        <span class="badge badge-status"
                                            style="<?php echo $badgeStyle ?>">
                                            <?php echo $status ?></span>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="<?= BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>