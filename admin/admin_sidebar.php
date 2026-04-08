<style>
    :root {
        --brand-green: #1fa97a;
        --sidebar-bg: linear-gradient(180deg, #f3fff8 0%, #e6fff2 100%);
    }

    .admin-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 260px;
        background: var(--sidebar-bg);
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        padding: 2rem 1.5rem;
        z-index: 1050;
        transform: translateX(-100%);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .admin-sidebar.open {
        transform: translateX(0);
    }

    /* Desktop: Sidebar always visible */
    @media (min-width: 768px) {
        .admin-sidebar {
            transform: translateX(0);
            position: fixed; /* or relative if you prefer */
            box-shadow: 0 8px 24px rgba(31, 169, 122, 0.06);
        }
    }

    .brand-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .icon-circle {
        width: 52px;
        height: 52px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: rgba(31, 169, 122, 0.08);
        color: var(--brand-green);
        margin-bottom: 0.6rem;
        font-size: 1.6rem;
    }

    .brand {
        font-weight: 800;
        color: var(--brand-green);
        font-size: 1.35rem;
    }

    .nav-link {
        color: #0a3b2c;
        padding: 0.85rem 1rem;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .nav-link:hover {
        background: rgba(31, 169, 122, 0.07);
        color: var(--brand-green);
        transform: translateX(6px);
    }

    .nav-link.active {
        background: var(--brand-green);
        color: #fff !important;
    }

    .logout-btn {
        width: 100%;
        margin-top: auto;
    }

    /* Hamburger Button - Visible only on mobile */
    .hamburger {
        position: fixed;
        top: 15px;
        left: 15px;
        z-index: 1100;
        background: white;
        border: none;
        width: 48px;
        height: 48px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        color: var(--brand-green);
    }

    .hamburger:hover {
        background: #f8f9fa;
    }

    /* Dark overlay when sidebar is open on mobile */
    .sidebar-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.4);
        z-index: 1040;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .sidebar-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    /* Main content adjustment */
    .main-content {
        transition: margin-left 0.4s ease;
    }

    @media (min-width: 768px) {
        .main-content {
            margin-left: 280px;   /* sidebar width + padding */
            padding: 2rem;
        }
    }

    @media (max-width: 767px) {
        .main-content {
            margin-left: 0;
            padding: 1rem;
            padding-top: 75px;
        }
    }
</style>

<aside class="admin-sidebar" id="adminSidebar">
    <div class="brand-header">
        <div class="icon-circle"><i class="bi bi-bar-chart-line-fill"></i></div>
        <h6 class="brand mb-0">AgriLink Admin</h6>
        <small class="text-muted">Dashboard</small>
    </div>
    
    <ul class="nav flex-column w-100">
        <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'admin.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>admin/admin.php">
                <i class="fas fa-home"></i> <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'admin_manage_products.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>admin/admin_manage_products.php">
                <i class="fas fa-box"></i> <span>Manage Products</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'admin_manage_users.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>admin/admin_manage_users.php">
                <i class="fas fa-users"></i> <span>Manage Users</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'admin_manage_orders.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>admin/admin_manage_orders.php">
                <i class="fas fa-shopping-cart"></i> <span>Manage Orders</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'admin_manage_category.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>admin/admin_manage_category.php">
                <i class="fas fa-layer-group"></i> <span>Manage Categories</span>
            </a>
        </li>
    </ul>

    <button class="btn btn-green logout-btn">
        <a class="text-decoration-none" href="<?= BASE_URL ?>admin/process/process_logout_admin.php">Logout</a>
    </button>
</aside>

<!-- Hamburger (mobile only) -->
<button class="hamburger d-md-none" id="hamburgerBtn">
    <i class="fas fa-bars"></i>
</button>

<!-- Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>