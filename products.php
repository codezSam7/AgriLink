<?php
session_start();
require_once 'classes/Farmer.php';
require_once 'admin/classes/Category.php';
require_once 'classes/Buyer.php';
require_once 'config/constants.php';

$f = new Farmer();
$b = new Buyer();
$c = new Category();

$farmer = isset($_SESSION['farmer_online']) ? $f->get_farmer_details($_SESSION['farmer_online']) : [];
$buyer  = isset($_SESSION['buyer_online']) ? $b->get_buyer_details($_SESSION['buyer_online']) : [];

$page = $_GET['page'] ?? 1;
$page = (int)$page;

$limit = 6;
$offset = ($page - 1) * $limit;

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$location = $_GET['location'] ?? '';

$products = $f->fetch_products($search, $category, $location, $limit, $offset);
$cats     = $c->fetch_all_categories();

$total_products = $f->count_products($search, $category, $location);
$total_pages = ceil($total_products / $limit);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="assets/images/logo.png" />
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/animate.min.css" />
    <link rel="stylesheet" href="assets/fontawesome/css/all.css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <title>All Products - AgriLink</title>

    <style>
        :root {
            --brand: #1fa97a;
            --brand-dark: #0f5132;
        }

        body {
            font-family: 'Poppins', system-ui, sans-serif;
            background: linear-gradient(135deg, #f8faf9 0%, #e8f5e9 100%);
            padding-top: 90px;
            min-height: 100vh;
        }

        .page-header {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(15, 81, 50, 0.08);
            padding: 2rem;
            margin-bottom: 3rem;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            color: var(--brand-dark);
            font-size: 2.4rem;
            margin-bottom: 1.5rem;
        }

        .product-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(15, 81, 50, 0.08);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(15, 81, 50, 0.15);
        }

        .product-card img {
            height: 210px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .product-card:hover img {
            transform: scale(1.05);
        }

        .product-card .card-body {
            padding: 1.25rem 1.4rem;
            display: flex;
            flex-direction: column;
        }

        .product-card .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.4rem;
            line-height: 1.3;
        }

        .product-price {
            font-size: 1.35rem;
            font-weight: 700;
            color: #0c7a52;
        }

        .unit {
            font-size: 0.95rem;
            color: #666;
        }

        .badge-available {
            font-size: 0.8rem;
            padding: 0.35em 0.75em;
        }

        .add-to-cart-btn {
            background: var(--brand);
            border: none;
            font-weight: 600;
        }

        .add-to-cart-btn:hover {
            background: #1a8f66;
        }
    </style>
</head>

<body>

    <?php require_once ROOT_PATH . 'outhead.php'; ?>

    <div class="container">
        <?php if (isset($_SESSION['farmer_online'])): ?>
            <div class="page-header">
                <h2 class="section-title text-center mb-4">Add New Product</h2>

                <?php require_once ROOT_PATH . 'common/alert.php'; ?>

                <form action="<?= BASE_URL ?>process/process_add_product.php" method="post" enctype="multipart/form-data" class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Product Name (e.g. Fresh Tomatoes)" required />
                    </div>
                    <div class="col-md-6">
                        <select name="category" class="form-select" required>
                            <option value="">Select Category</option>
                            <?php foreach ($cats as $cat): ?>
                                <option value="<?= htmlspecialchars($cat['category_id']) ?>">
                                    <?= htmlspecialchars($cat['category_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12">
                        <textarea name="desc" class="form-control" rows="2" placeholder="Product Description" required></textarea>
                    </div>

                    <div class="col-md-4">
                        <input type="text" name="unit" class="form-control" placeholder="Unit (e.g. kg, bunch, crate)" required />
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="price" class="form-control" placeholder="Price (₦)" step="0.01" required />
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="qtyavail" class="form-control" placeholder="Quantity Available" required />
                    </div>

                    <div class="col-12">
                        <input type="file" name="file" class="form-control" accept="image/*" />
                        <small class="text-muted">Upload product image (optional)</small>
                    </div>

                    <div class="col-12 d-grid">
                        <button type="submit" name="add" class="btn btn-success btn-lg">
                            <i class="fas fa-plus me-2"></i> Add Product to Marketplace
                        </button>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <section class="py-4">
            <h2 class="section-title text-center">All Fresh Products</h2>

            <?php require_once ROOT_PATH . 'common/alert.php'; ?>

            <form method="GET" class="row g-2 mb-4">

                <div class="col-md-4">
                    <input type="text" name="search" class="form-control"
                        placeholder="Search products..."
                        value="<?= $_GET['search'] ?? '' ?>">
                </div>

                <div class="col-md-3">
                    <select name="category" class="form-control">
                        <option value="">All Categories</option>
                        <?php foreach ($cats as $cat): ?>
                            <option value="<?= $cat['category_id'] ?>"
                                <?= (($_GET['category'] ?? '') == $cat['category_id']) ? 'selected' : '' ?>>
                                <?= $cat['category_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="text" name="location" class="form-control"
                        placeholder="Enter state..."
                        value="<?= $_GET['location'] ?? '' ?>">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-success w-100">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>

            </form>

            <?php if (empty($products)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <p class="text-muted">No products available at the moment.</p>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($products as $product):
                        $farmer_name = 'Farmer';
                        $image = $product['product_image'] ?? 'placeholder.jpg';
                        $pname = htmlspecialchars($product['product_name']);
                        $price = number_format($product['product_price']);
                        $unit  = htmlspecialchars($product['product_unit'] ?? 'unit');
                        $avail = $product['product_quantityavailable'];
                        if (!empty($product['farmer_fullname'])) {
                            $parts = explode(' ', trim($product['farmer_fullname']));
                            $farmer_name = end($parts);
                        }
                        $product_state = htmlspecialchars($product['state_name'] ?? 'Nigeria');
                    ?>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                            <div class="card product-card h-100">
                                <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($image) ?>"
                                    class="card-img-top"
                                    alt="<?= $pname ?>">

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= $pname ?></h5>

                                    <p class="text-muted small mb-2">
                                        By Farmer <?= htmlspecialchars($farmer_name) ?><br>
                                        <?= $product_state ?>
                                    </p>

                                    <p class="mb-2">
                                        <span class="badge bg-success badge-available">
                                            <?= $avail ?> available
                                        </span>
                                    </p>

                                    <div class="mt-auto">
                                        <p class="product-price mb-1">
                                            ₦<?= $price ?>
                                            <span class="unit">/ <?= $unit ?></span>
                                        </p>

                                        <div class="d-flex gap-2 mt-3">
                                            <?php if (isset($_SESSION['buyer_online'])): ?>
                                                <a href="<?= BASE_URL ?>process/process_addtocart.php?id=<?= $product['product_id'] ?>"
                                                    class="btn add-to-cart-btn btn-sm flex-grow-1 text-white">
                                                    <i class="fas fa-cart-plus"></i> Add
                                                </a>
                                            <?php endif; ?>

                                            <a href="<?= BASE_URL ?>product_details.php?id=<?= $product['product_id'] ?>"
                                                class="btn btn-outline-success btn-sm flex-grow-1">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($total_pages > 1): ?>
                    <nav class="mt-5">
                        <ul class="pagination justify-content-center">

                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link"
                                    href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>&category=<?= $category ?>&location=<?= urlencode($location) ?>">
                                    Prev
                                </a>
                            </li>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                    <a class="page-link"
                                        href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&category=<?= $category ?>&location=<?= urlencode($location) ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                                <a class="page-link"
                                    href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>&category=<?= $category ?>&location=<?= urlencode($location) ?>">
                                    Next
                                </a>
                            </li>

                        </ul>
                    </nav>
                <?php endif; ?>

            <?php endif; ?>
        </section>
    </div>

    <?php require_once ROOT_PATH . 'footer.php'; ?>

    <script src="<?= BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>