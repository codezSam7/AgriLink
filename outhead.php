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

<nav class="navbar navbar-expand-lg fixed-top shadow-sm" style="background: rgba(255,255,255,0.97); backdrop-filter: blur(12px); border-bottom: 1px solid #e0e7e0;">
    <div class="container-fluid px-3 px-md-4 px-lg-5">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= BASE_URL ?>index.php">
            <img src="<?= BASE_URL ?>assets/images/logo.png" alt="AgriLink" width="48" height="48" style="filter: brightness(1.05);">
            <span class="fw-bold fs-4 text-success d-none d-md-inline">AgriLink</span>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mx-auto gap-3 gap-lg-5 align-items-center">
                <li class="nav-item"><a class="nav-link bar-link fw-medium" href="<?= BASE_URL ?>index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link bar-link fw-medium" href="<?= BASE_URL ?>farmers/farmers.php">Farmers</a></li>
                <li class="nav-item"><a class="nav-link bar-link fw-medium" href="<?= BASE_URL ?>products.php">Products</a></li>
                <?php if (isset($_SESSION['buyer_online'])): ?>
                    <li class="nav-item"><a class="nav-link bar-link fw-medium" href="<?= BASE_URL ?>buyers/buyer_orders.php?buyer_id=<?= $_SESSION['buyer_online'] ?>">My Orders</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link bar-link fw-medium" href="<?= BASE_URL ?>logistics.php">Logistics</a></li>
                <li class="nav-item"><a class="nav-link bar-link fw-medium" href="<?= BASE_URL ?>contact.php">Contact</a></li>
            </ul>

            <div class="d-flex align-items-center gap-3 gap-lg-4 mt-3 mt-lg-0">
                <?php if (isset($current_farmer['farmer_fullname'])):
                    $split = explode(' ', $current_farmer['farmer_fullname']);
                    $fname = end($split);
                ?>
                    <div class="dropdown">
                        <?php $avatar = !empty($current_farmer['farmer_avatarurl'])
                            ? BASE_URL . 'uploads/' . $current_farmer['farmer_avatarurl']
                            : BASE_URL . 'assets/images/default-avatar.png'; ?>
                        <a class="btn btn-outline-success dropdown-toggle d-flex align-items-center gap-2 py-2 px-3" href="#" data-bs-toggle="dropdown">
                            <img src="<?= $avatar ?>"
                                alt="avatar"
                                width="35"
                                height="35"
                                class="rounded-circle"
                                style="object-fit: cover;">
                            <span class="d-none d-md-inline">Farmer <?= htmlspecialchars($fname) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>profile.php">My Profile</a></li>
                            <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>process/process_logout.php">Logout</a></li>
                        </ul>
                    </div>

                <?php elseif (isset($logistic['name'])): ?>
                    <div class="dropdown">
                        <a class="btn btn-outline-success dropdown-toggle d-flex align-items-center gap-2 py-2 px-3" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle fs-5"></i>
                            <span><?= htmlspecialchars($logistic['name']) ?> (Logistics)</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>process/process_logout.php">Logout</a></li>
                        </ul>
                    </div>

                <?php elseif (isset($buyer['buyer_fullname'])): ?>
                    <div class="dropdown">
                        <a class="btn btn-outline-success dropdown-toggle d-flex align-items-center gap-2 py-2 px-3" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle fs-5"></i>
                            <span class="d-none d-md-inline"><?= htmlspecialchars($buyer['buyer_fullname']) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>process/process_logout.php">Logout</a></li>
                        </ul>
                    </div>

                    <a href="<?= BASE_URL ?>cart.php" class="position-relative text-success fs-4" aria-label="Cart" style="transition: all 0.2s;">
                        <i class="fas fa-shopping-cart"></i>
                        <?php if ($cart_count > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success px-2 py-1 text-white fs-6">
                                <?= $cart_count ?>
                            </span>
                        <?php endif; ?>
                    </a>

                <?php else: ?>
                    <div class="d-flex gap-2">
                        <div class="dropdown">
                            <button class="btn btn-outline-success dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                                Register
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>farmers/sign_farmer.php">As Farmer</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>buyers/sign_buyer.php">As Buyer</a></li>
                            </ul>
                        </div>

                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                                Login
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>farmers/login_farmer.php">As Farmer</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>buyers/login_buyer.php">As Buyer</a></li>
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
        background: rgba(255, 255, 255, 0.96) !important;
        backdrop-filter: blur(14px);
    }

    .bar-link {
        color: #1a2e1f;
        font-weight: 500;
        transition: all 0.25s ease;
    }

    .bar-link:hover,
    .bar-link.active {
        color: var(--accent-2, #1fa97a) !important;
    }

    .navbar .dropdown-menu {
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        border-radius: 12px;
    }
</style>