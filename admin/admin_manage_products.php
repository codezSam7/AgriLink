<?php
session_start();
require_once 'admin_guard.php';
require_once 'classes/Admin.php';
require_once __DIR__ . '/../classes/Farmer.php';
require_once __DIR__ . '/../config/constants.php';

$a = new Admin;
$f = new Farmer;

if (isset($_SESSION['admin_online'])) {
    $admin = $a->get_admin_details($_SESSION['admin_online']);
} else {
    header('Location: login.php');
    exit();
}

$products = $f->fetch_products();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Products | AgriLink</title>
    <link rel="icon" href="<?= BASE_URL ?>assets/images/logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/fontawesome/css/all.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-green: #1fa97a;
            --card-bg: #ffffff;
            --soft-bg: #f5fff7;
            --brand-green: #1fa97a;
            --light-green: rgba(31, 169, 122, 0.08);
        }

        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(180deg, #f3fff8 0%, #e8f5e9 100%);
            margin: 0;
            padding: 0;
        }

        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: linear-gradient(180deg, #f3fff8 0%, #e6fff2 100%);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1.5rem;
        }

        .sidebar-content {
            width: 100%;
            text-align: center;
        }

        .brand-header {
            margin-bottom: 2rem;
        }

        .icon-circle {
            width: 52px;
            height: 52px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: var(--light-green);
            color: var(--brand-green);
            margin-bottom: 0.6rem;
        }

        .brand {
            font-weight: 600;
            color: var(--brand-green);
        }

        .nav {
            padding-left: 0;
            width: 100%;
        }

        .nav-link {
            color: #0a3b2c;
            padding: 0.8rem 0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        .nav-link:hover {
            background: var(--light-green);
            color: var(--brand-green);
            transform: translateX(5px);
            text-decoration: none;
        }

        .nav-link.active {
            background: var(--brand-green);
            color: #fff !important;
        }

        .btn-green {
            background-color: var(--brand-green);
            border: none;
            border-radius: 12px;
            padding: 0.65rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-green:hover {
            background-color: #188e66;
            transform: translateY(-2px);
        }

        .logout-btn {
            width: 100%;
            margin-top: 2rem;
        }

        .logout-btn a {
            text-decoration: none;
            color: #fff;
            display: block;
            text-align: center;
            font-weight: 600;
        }


        /* Main content */
        .admin-wrapper {
            margin-left: 280px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .page-title {
            font-weight: 600;
            color: var(--brand-green);
        }

        /* Product cards */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 1.5rem;
        }

        .product-card {
            background: var(--card-bg);
            border-radius: 14px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.12);
        }

        .product-card img {
            border-top-left-radius: 14px;
            border-top-right-radius: 14px;
            object-fit: cover;
            height: 160px;
            width: 100%;
        }

        .product-card .card-body {
            padding: 1rem;
        }

        .product-card h6 {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .product-card p {
            margin-bottom: 0.25rem;
            font-size: 0.875rem;
        }

        .product-card .btn {
            font-size: 0.85rem;
            padding: 0.35rem 0.5rem;
        }

        .product-card .admin-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
    </style>
</head>

<body>
    <?php require_once 'admin_sidebar.php' ?>

    <div class="main-content">
        <h3 class="page-title">Manage Products</h3>
        <?php require_once ROOT_PATH . 'common/alert.php' ?>
        <section class="products-grid">
            <?php foreach ($products as $product) {
                $image = $product['product_image'];
                $pname = $product['product_name'];
                $avail = $product['product_quantityavailable'];
                $unit = $product['product_unit'];
                $price = number_format($product['product_price']);
                $fname = $product['farmer_fullname'];
                $name = explode(' ', $fname);
                $show = end($name);
                $state = $product['state_name'];
            ?>
                <div class="product-card">
                    <img src="<?= BASE_URL ?>uploads/<?php echo $image; ?>" alt="<?php echo $pname ?>" />
                    <div class="card-body">
                        <h6><?php echo $pname; ?></h6>
                        <p class="text-success fw-bold">&#8358; <?php echo $price; ?></p>
                        <p class="small text-muted">From: Farmer <?php echo $show; ?></p>
                        <p class="small text-muted">In: <?php echo $state; ?></p>
                        <div class="admin-actions">
                            <a class="btn btn-outline-danger btn-sm" href="process/process_delete_product.php?id=<?php echo $product['product_id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                            <a class="btn btn-outline-success btn-sm" href="product_details.php?id=<?php echo $product['product_id']; ?>">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </section>
    </div>

    <script src="<?= BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.js"></script>
    <script>
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }

        hamburgerBtn.addEventListener('click', toggleSidebar);

        overlay.addEventListener('click', toggleSidebar);

        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('show');
                }
            });
        });
    </script>
</body>

</html>