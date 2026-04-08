<?php
require_once 'classes/Buyer.php';
require_once 'classes/Cart.php';
require_once 'classes/Logistics.php';
require_once 'classes/Farmer.php';

$b = new Buyer();
$c = new Cart();
$l = new Logistics();
$f = new Farmer();

$buyer    = isset($_SESSION['buyer_online'])   ? $b->get_buyer_details($_SESSION['buyer_online'])   : [];
$current_farmer = isset($_SESSION['farmer_online']) ? $f->get_farmer_details($_SESSION['farmer_online']) : [];
$logistic = isset($_SESSION['logistic_online']) ? $l->get_logistics_details($_SESSION['logistic_online']) : [];

$cart_count = isset($_SESSION['buyer_online']) ? $c->count_buyer_cart($_SESSION['buyer_online']) : 0;
?>

<nav class="navbar navbar-expand-lg fixed-top shadow-sm glass-navbar">
    <div class="container-fluid px-3 px-md-4 px-lg-5">

        <!-- LOGO -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= BASE_URL ?>index.php">
            <img src="<?= BASE_URL ?>assets/images/logo.png" width="42" height="42">
            <span class="fw-bold fs-5 text-success d-none d-md-inline">AgriLink</span>
        </a>

        <!-- TOGGLER -->
        <button class="navbar-toggler border-0 shadow-none" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- NAV CONTENT -->
        <div class="collapse navbar-collapse" id="navbarContent">

            <!-- CENTER LINKS -->
            <ul class="navbar-nav mx-auto text-center gap-2 gap-lg-4">
                <li class="nav-item"><a class="nav-link bar-link" href="<?= BASE_URL ?>index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link bar-link" href="<?= BASE_URL ?>farmers/farmers.php">Farmers</a></li>
                <li class="nav-item"><a class="nav-link bar-link" href="<?= BASE_URL ?>products.php">Products</a></li>
                <?php if (isset($_SESSION['buyer_online'])): ?>
                    <li class="nav-item"><a class="nav-link bar-link" href="<?= BASE_URL ?>buyers/buyer_orders.php">Orders</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link bar-link" href="<?= BASE_URL ?>logistics.php">Logistics</a></li>
                <li class="nav-item"><a class="nav-link bar-link" href="<?= BASE_URL ?>contact.php">Contact</a></li>
            </ul>

            <!-- RIGHT SIDE -->
            <div class="nav-actions d-flex flex-column flex-lg-row align-items-center gap-3 mt-3 mt-lg-0 w-100 w-lg-auto">

                <?php if (isset($current_farmer['farmer_fullname'])):
                    $split = explode(' ', $current_farmer['farmer_fullname']);
                    $fname = end($split);
                    $avatar = !empty($current_farmer['farmer_avatarurl'])
                        ? BASE_URL . 'uploads/' . $current_farmer['farmer_avatarurl']
                        : BASE_URL . 'assets/images/default-avatar.png';
                ?>

                    <!-- USER DROPDOWN -->
                    <div class="dropdown w-100 w-lg-auto">
                        <a class="btn btn-outline-success dropdown-toggle d-flex align-items-center justify-content-center justify-content-lg-start gap-2 w-100"
                            href="#" data-bs-toggle="dropdown">

                            <img src="<?= $avatar ?>" width="34" height="34"
                                class="rounded-circle" style="object-fit: cover;">

                            <span class="d-lg-inline small">
                                <?= htmlspecialchars($fname) ?>
                            </span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end w-100 w-lg-auto">
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>profile.php">My Profile</a></li>
                            <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>process/process_logout.php">Logout</a></li>
                        </ul>
                    </div>

                <?php elseif (isset($buyer['buyer_fullname'])): ?>

                    <!-- BUYER -->
                    <div class="dropdown w-100 w-lg-auto">
                        <a class="btn btn-outline-success dropdown-toggle w-100"
                            href="#" data-bs-toggle="dropdown">
                            <?= htmlspecialchars($buyer['buyer_fullname']) ?>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end w-100 w-lg-auto">
                            <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>process/process_logout.php">Logout</a></li>
                        </ul>
                    </div>

                    <!-- CART -->
                    <a href="<?= BASE_URL ?>cart.php" class="position-relative text-success fs-5">
                        <i class="fas fa-shopping-cart"></i>
                        <?php if ($cart_count > 0): ?>
                            <span class="badge bg-success position-absolute top-0 start-100 translate-middle">
                                <?= $cart_count ?>
                            </span>
                        <?php endif; ?>
                    </a>

                <?php else: ?>

                    <!-- AUTH BUTTONS -->
                    <div class="d-flex flex-column flex-lg-row gap-2 w-100">

                        <div class="dropdown w-100">
                            <button class="btn btn-outline-success dropdown-toggle w-100" data-bs-toggle="dropdown">
                                Register
                            </button>
                            <ul class="dropdown-menu w-100">
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>farmers/sign_farmer.php">Farmer</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>buyers/sign_buyer.php">Buyer</a></li>
                            </ul>
                        </div>

                        <div class="dropdown w-100">
                            <button class="btn btn-success dropdown-toggle w-100" data-bs-toggle="dropdown">
                                Login
                            </button>
                            <ul class="dropdown-menu w-100">
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>farmers/login_farmer.php">Farmer</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>buyers/login_buyer.php">Buyer</a></li>
                            </ul>
                        </div>

                    </div>

                <?php endif; ?>

            </div>
        </div>
    </div>
</nav>

<style>
    .glass-navbar {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
    }

    /* Links */
    .bar-link {
        color: #1a2e1f;
        font-weight: 500;
    }

    .bar-link:hover {
        color: #1fa97a !important;
    }

    /* Dropdown */
    .dropdown-menu {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    /* MOBILE MAGIC */
    @media (max-width: 768px) {

        .navbar-nav {
            margin-top: 15px;
        }

        .nav-actions {
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .dropdown-menu {
            width: 100%;
        }

        .btn {
            width: 100%;
        }
    }
</style>