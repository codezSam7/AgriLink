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

$farmers = $a->fetch_farmers();
$buyers = $a->fetch_buyers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Farmers & Buyers | AgriLink Admin</title>
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
            min-height: 100vh;
        }

        /* Page specific styles only */
        .page-title {
            font-weight: 600;
            color: var(--brand-green);
        }

        .search-bar {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .search-bar input {
            border-radius: 10px;
            border: 1px solid #ccc;
            padding: 0.6rem 1rem;
            width: 100%;
            max-width: 280px;
        }

        .farmer-card, .buyer-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: 0.3s ease;
        }
        .farmer-card:hover, .buyer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.12);
        }
        .farmer-info, .buyer-info {
            padding: 1.2rem;
        }

        /* Fix for mobile - no horizontal scroll */
        @media (max-width: 767px) {
            .main-content {
                padding: 1rem !important;
                padding-top: 80px !important;
            }
            .search-bar {
                flex-direction: column;
                align-items: stretch;
            }
            .search-bar input {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

    <?php require_once 'admin_sidebar.php'; ?>

    <main class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h3 class="page-title">Manage Farmers</h3>
            <div class="search-bar">
                <input type="text" id="searchFarmerInput" placeholder="Search farmer name...">
                <button class="btn btn-success" onclick="filterFarmers()">Search</button>
            </div>
        </div>

        <?php require_once ROOT_PATH . "common/alert.php"; ?>

        <div class="row g-4" id="farmerContainer">
            <?php if (!empty($farmers)) { 
                foreach ($farmers as $farmer) { ?>
                    <div class="col-md-4 farmer-card-wrapper">
                        <div class="farmer-card text-center p-3">
                            <div class="farmer-info">
                                <?php
                                $avatar = (!empty($farmer) && !empty($farmer['farmer_avatarurl']))
                                    ? BASE_URL . 'uploads/' . $farmer['farmer_avatarurl']
                                    : BASE_URL . 'assets/images/default-avatar.png';
                                ?>
                                <img src="<?= $avatar ?>" alt="avatar" width="60" height="60" class="rounded-circle mb-3" style="object-fit: cover;">
                                <h6 class="text-success fw-semibold mb-2"><?= htmlspecialchars($farmer['farmer_fullname']); ?></h6>
                                <p class="mb-1"><i class="fas fa-map-marker-alt me-1 text-muted"></i> <?= htmlspecialchars($farmer['state_name'] ?? ''); ?></p>
                                <p class="mb-1"><i class="fas fa-envelope me-1 text-muted"></i> <?= htmlspecialchars($farmer['farmer_email'] ?? ''); ?></p>
                                <p class="mb-3"><i class="fas fa-phone me-1 text-muted"></i> <?= htmlspecialchars($farmer['farmer_phone'] ?? ''); ?></p>

                                <form action="process/update_farmer_status.php" method="post" class="d-inline-block mb-2">
                                    <select name="status" class="form-select form-select-sm d-inline-block w-auto">
                                        <option value="active" <?= $farmer['farmer_status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?= $farmer['farmer_status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-success ms-1">Update</button>
                                </form>
                                <a href="admin_view_profile.php?id=<?= $farmer['farmer_id'] ?>" class="btn btn-success btn-sm px-3">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } 
            } else { ?>
                <div class="text-center text-muted py-5 col-12">
                    <i class="fas fa-user-slash fa-2x mb-3"></i>
                    <p>No farmers found yet.</p>
                </div>
            <?php } ?>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4 mt-5 flex-wrap gap-3">
            <h3 class="page-title">Manage Buyers</h3>
            <div class="search-bar">
                <input type="text" id="searchBuyerInput" placeholder="Search buyer name...">
                <button class="btn btn-success" onclick="filterBuyers()">Search</button>
            </div>
        </div>

        <div class="row g-4" id="buyerContainer">
            <?php if (!empty($buyers)) { 
                foreach ($buyers as $buyer) { ?>
                    <div class="col-md-4 buyer-card-wrapper">
                        <div class="buyer-card text-center p-3">
                            <div class="buyer-info">
                                <h6 class="text-success fw-semibold mb-2"><?= htmlspecialchars($buyer['buyer_fullname']); ?></h6>
                                <p class="mb-1"><i class="fas fa-map-marker-alt me-1 text-muted"></i> <?= htmlspecialchars($buyer['state_name'] ?? ''); ?></p>
                                <p class="mb-1"><i class="fas fa-envelope me-1 text-muted"></i> <?= htmlspecialchars($buyer['buyer_email'] ?? ''); ?></p>
                                <p class="mb-3"><i class="fas fa-phone me-1 text-muted"></i> <?= htmlspecialchars($buyer['buyer_phone'] ?? ''); ?></p>
                                <a href="#" class="btn btn-success btn-sm px-3"><i class="fas fa-eye"></i> View Details</a>
                            </div>
                        </div>
                    </div>
                <?php } 
            } else { ?>
                <div class="text-center text-muted py-5 col-12">
                    <i class="fas fa-user-slash fa-2x mb-3"></i>
                    <p>No buyers found yet.</p>
                </div>
            <?php } ?>
        </div>
    </main>

    <script src="<?= BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.js"></script>

    <!-- Search Filters -->
    <script>
        function filterFarmers() {
            const input = document.getElementById("searchFarmerInput").value.toLowerCase();
            const cards = document.querySelectorAll(".farmer-card-wrapper");
            cards.forEach(card => {
                const name = card.querySelector("h6").textContent.toLowerCase();
                card.style.display = name.includes(input) ? "block" : "none";
            });
        }

        function filterBuyers() {
            const input = document.getElementById("searchBuyerInput").value.toLowerCase();
            const cards = document.querySelectorAll(".buyer-card-wrapper");
            cards.forEach(card => {
                const name = card.querySelector("h6").textContent.toLowerCase();
                card.style.display = name.includes(input) ? "block" : "none";
            });
        }
    </script>

    <!-- Hamburger Sidebar Script -->
    <script>
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }

        if (hamburgerBtn) hamburgerBtn.addEventListener('click', toggleSidebar);
        if (overlay) overlay.addEventListener('click', toggleSidebar);

        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    sidebar.classList.remove('open');
                    if (overlay) overlay.classList.remove('show');
                }
            });
        });
    </script>
</body>
</html>