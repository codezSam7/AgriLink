<?php
session_start();
require_once 'classes/Farmer.php';
require_once 'classes/Buyer.php';
require_once 'config/constants.php';

$f = new Farmer();
$b = new Buyer();

$farmer = isset($_SESSION['farmer_online']) ? $f->get_farmer_details($_SESSION['farmer_online']) : [];
$buyer  = isset($_SESSION['buyer_online']) ? $b->get_buyer_details($_SESSION['buyer_online']) : [];

if (!isset($_GET['id'])) {
    header('location: index.php');
    exit;
}

$product_id = $_GET['id'];
$product = $f->get_product_by_id($product_id);

if (!$product) {
    header('location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo.png" />
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/animate.min.css" />
    <link rel="stylesheet" href="assets/fontawesome/css/all.css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <title><?= htmlspecialchars($product['product_name']) ?> - AgriLink</title>

    <style>
        :root {
            --brand: #1fa97a;
        }

        body {
            font-family: 'Poppins', system-ui, sans-serif;
            background: linear-gradient(135deg, #f8faf9 0%, #e8f5e9 100%);
            padding-top: 90px;
            min-height: 100vh;
        }

        .product-wrapper {
            max-width: 1100px;
            margin: 2.5rem auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(15, 81, 50, 0.10);
            overflow: hidden;
        }

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-content {
            padding: 2.8rem 3rem;
        }

        .product-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.1rem;
            color: var(--brand);
            margin-bottom: 0.6rem;
        }

        .price {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0c7a52;
        }

        .unit {
            color: #666;
            font-size: 1rem;
            font-weight: 400;
        }

        .farmer-info {
            background: #f8faf9;
            padding: 1.25rem;
            border-radius: 12px;
            margin-top: 2rem;
        }

        .btn-add-cart {
            background: var(--brand);
            border: none;
            padding: 0.85rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .btn-add-cart:hover {
            background: #1a8f66;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <?php require_once ROOT_PATH . 'outhead.php'; ?>

    <div class="container">
        <div class="product-wrapper row g-0">
            <div class="col-lg-5">
                <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($product['product_image']) ?>"
                    alt="<?= htmlspecialchars($product['product_name']) ?>"
                    class="product-img">
            </div>

            <div class="col-lg-7">
                <div class="product-content">
                    <h1 class="product-title"><?= htmlspecialchars($product['product_name']) ?></h1>

                    <div class="mb-4">
                        <span class="price">₦<?= number_format($product['product_price']) ?></span>
                        <span class="unit">/ <?= htmlspecialchars($product['product_unit'] ?? 'unit') ?></span>
                    </div>

                    <p class="lead text-muted">
                        <?= nl2br(htmlspecialchars($product['product_description'] ?? 'No description available.')) ?>
                    </p>

                    <div class="row">
                        <div class="col-sm-6">
                            <p><strong>Available Quantity:</strong><br>
                                <?= htmlspecialchars($product['product_quantityavailable'] ?? 'N/A') ?></p>
                        </div>
                    </div>

                    <div class="farmer-info">
                        <p class="mb-2">
                            <i class="fas fa-user text-success"></i>
                            Sold by:
                            <a href="<?= BASE_URL ?>farmers/farmer_profile_view.php?id=<?= $product['product_farmer_id'] ?>"
                                class="text-success fw-medium">
                                <?= htmlspecialchars($product['farmer_fullname']) ?>
                            </a>
                        </p>
                        <p>
                            <i class="fas fa-map-marker-alt text-success"></i>
                            Location: <?= htmlspecialchars($product['state_name'] ?? 'Nigeria') ?>
                        </p>
                    </div>

                    <div class="mt-5">
                        <?php if (isset($_SESSION['buyer_online'])): ?>
                            <a href="<?= BASE_URL ?>process/process_addtocart.php?id=<?= $product['product_id'] ?>"
                                class="btn btn-add-cart btn-lg text-white">
                                <i class="fas fa-cart-plus me-2"></i> Add to Cart
                            </a>
                        <?php elseif (isset($_SESSION['farmer_online'])): ?>
                            <a href="#"
                                class="btn btn-outline-success btn-lg">
                                <i class="fas fa-edit me-2"></i> Update This Product
                            </a>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>buyers/login_buyer.php"
                                class="btn btn-outline-success btn-lg">
                                <i class="fas fa-user me-2"></i> Login to Buy
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="mt-2">
                        <a href="products.php" class="btn btn-outline-secondary">Back to Products</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once ROOT_PATH . 'footer.php'; ?>

    <script src="<?= BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>