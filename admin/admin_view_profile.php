    <?php
    session_start();
    require_once 'admin_guard.php';
    require_once 'classes/Admin.php';
    require_once __DIR__ . '/../config/constants.php';

    $a = new Admin;

    if (isset($_SESSION['admin_online'])) {
        $admin = $a->get_admin_details($_SESSION['admin_online']);
    } else {
        header('Location: login.php');
        exit();
    }

    $farmer_id = isset($_GET['id']) ? $_GET['id'] : null;
    if (! $farmer_id) {
        header('location: admin_manage_users.php');
        exit();
    }

    $farmerRecord = $a->fetch_farmers_by_id($farmer_id);

    $farmer = null;
    if (is_array($farmerRecord)) {
        if (isset($farmerRecord[0]) && is_array($farmerRecord[0])) {
            $farmer = $farmerRecord[0];
        } elseif (isset($farmerRecord['farmer_id'])) {
            $farmer = $farmerRecord;
        }
    } else {
        $farmer = $farmerRecord;
    }

    if (! $farmer || ! isset($farmer['farmer_id'])) {
        header('location: admin_manage_users.php?msg=farmer_not_found');
        exit();
    }

    $title = isset($farmer['farmer_fullname']) ? $farmer['farmer_fullname'] . ' | AgriLink Admin' : 'Farmer Profile | AgriLink Admin';
    $description = isset($farmer['farmer_bio']) ? $farmer['farmer_bio'] : 'Farmer profile on AgriLink';
    $keywords = isset($farmer['farmer_primary_produce']) ? $farmer['farmer_primary_produce'] : '';
    $avatar = isset($farmer['farmer_avatarurl']) && $farmer['farmer_avatarurl'] ? '../uploads/' . $farmer['farmer_avatarurl'] : '../assets/images/logo.png';
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?php echo htmlspecialchars($title); ?></title>
        <meta name="description" content="<?php echo htmlspecialchars($description); ?>">
        <meta name="keywords" content="<?php echo htmlspecialchars($keywords); ?>">
        <meta name="author" content="<?php echo isset($farmer['farmer_fullname']) ? htmlspecialchars($farmer['farmer_fullname']) : 'AgriLink'; ?>">
        <meta property="og:title" content="<?php echo htmlspecialchars($title); ?>">
        <meta property="og:description" content="<?php echo htmlspecialchars($description); ?>">
        <meta property="og:image" content="<?php echo htmlspecialchars($avatar); ?>">
        <link rel="icon" href="<?= BASE_URL ?>assets/images/logo.png" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= BASE_URL ?>assets/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="<?= BASE_URL ?>assets/fontawesome/css/all.css" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
        <style>
            :root {
                --brand-green: #1fa97a;
                --light-green: rgba(31, 169, 122, 0.08);
            }

            body {
                font-family: "Poppins", sans-serif;
                background: linear-gradient(180deg, #f3fff8 0%, #e8f5e9 100%);
                margin: 0;
                display: flex;
                min-height: 100vh;
                overflow: hidden;
            }

            /* Sidebar (kept as requested) */
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
                z-index: 10;
            }

            .sidebar-content {
                width: 100%;
                text-align: center;
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
                text-decoration: none;
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

            .page-content {
                margin-left: 260px;
                padding: 2rem;
                width: calc(100% - 260px);
                min-height: 100vh;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            .page-title {
                font-weight: 600;
                color: var(--brand-green);
                margin-bottom: 1rem;
            }

            .profile-card {
                background: #fff;
                border-radius: 12px;
                box-shadow: 0 6px 20px rgba(10, 30, 20, 0.06);
                padding: 1.5rem;
            }

            .farmer-avatar {
                width: 160px;
                height: 160px;
                object-fit: cover;
                border-radius: 12px;
                border: 4px solid #f3fff8;
                background: #f7f7f7;
            }

            .meta-badge {
                display: inline-block;
                background: var(--light-green);
                color: var(--brand-green);
                padding: 6px 10px;
                border-radius: 999px;
                font-weight: 600;
                margin-right: 0.5rem;
                margin-bottom: 0.5rem;
            }
        </style>
    </head>

    <body>
        <?php require_once 'admin_sidebar.php' ?>

        <main class="main-content">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="page-title">Farmer Profile</h4>
                    <a href="admin_manage_users.php" class="btn btn-outline-secondary">Back to Farmers</a>
                </div>

                <div class="profile-card">
                    <div class="row g-3">
                        <div class="col-md-3 text-center">
                            <img src="<?php echo htmlspecialchars($avatar); ?>" alt="<?php echo htmlspecialchars($farmer['farmer_fullname']); ?>" class="farmer-avatar mb-3">
                            <h5 class="mb-0"><?php echo htmlspecialchars($farmer['farmer_fullname']); ?></h5>
                            <small class="text-muted"><?php echo htmlspecialchars($farmer['state_name'] ?? ''); ?></small>
                        </div>
                        <div class="col-md-9">
                            <div class="mb-2">
                                <span class="meta-badge"><i class="fas fa-seedling"></i> <?php echo htmlspecialchars($farmer['farmer_primary_produce'] ?? ''); ?></span>
                                <span class="meta-badge"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($farmer['farmer_email'] ?? ''); ?></span>
                                <span class="meta-badge"><i class="fas fa-phone"></i> <?php echo htmlspecialchars($farmer['farmer_phone'] ?? ''); ?></span>
                            </div>

                            <hr>

                            <h6 class="mb-2">About</h6>
                            <p class="text-muted"><?php echo nl2br(htmlspecialchars($farmer['farmer_bio'] ?? 'No biography provided.')); ?></p>

                            <div class="mt-3">
                                <a href="admin_manage_users.php" class="btn btn-outline-secondary">Back</a>
                                <a href="mailto:<?php echo htmlspecialchars($farmer['farmer_email'] ?? ''); ?>" class="btn btn-success ms-2">Email Farmer</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
	
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