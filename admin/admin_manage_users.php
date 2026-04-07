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

// "<pre>";
// var_dump($farmer['farmer_avatarurl']);
// "</pre>";

$farmers = $a->fetch_farmers();
$buyers = $a->fetch_buyers();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Farmers | AgriLink Admin</title>
    <link rel="icon" href="<?= BASE_URL ?>assets/images/logo.png" />
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
        }

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

        .page-content {
            margin-left: 260px;
            padding: 2rem;
            width: calc(100% - 260px);
            min-height: 100vh;
        }

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
            width: 250px;
        }

        .farmer-card,
        .buyer-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: 0.3s ease;
        }

        .farmer-card:hover,
        .buyer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.12);
        }

        .farmer-info,
        .buyer-info {
            padding: 1.2rem;
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


        .btn-view:hover {
            background: #178e65;
        }

        @media(max-width: 768px) {
            body {
                flex-direction: column;
            }

            .admin-sidebar {
                position: relative;
                width: 100%;
                height: auto;
                flex-direction: row;
                justify-content: space-around;
            }

            .page-content {
                margin-left: 0;
                width: 100%;
            }

            .nav {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <aside class="admin-sidebar">
        <div class="sidebar-content">
            <div class="brand-header">
                <div class="icon-circle"><i class="fas fa-chart-line"></i></div>
                <div>
                    <h6 class="brand mb-0">AgriLink Admin</h6>
                    <small class="text-muted">Dashboard</small>
                </div>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="admin.php">
                        <i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_manage_products.php">
                        <i class="fas fa-box"></i> Manage Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_manage_users.php">
                        <i class="fas fa-users"></i> Manage Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_manage_orders.php">
                        <i class="fas fa-shopping-cart"></i> Manage Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_manage_category.php">
                        <i class="fas fa-layer-group"></i> Manage Categories</a>
                </li>
            </ul>
            <button class="btn btn-green logout-btn">
                <a href="process/process_logout_admin.php"> Logout</a>
            </button>
        </div>
    </aside>


    <main class="page-content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="page-title">Manage Farmers</h3>
            <div class="search-bar">
                <input type="text" id="searchFarmerInput" placeholder="Search farmer name...">
                <button class="btn btn-success" onclick="filterFarmers()">Search</button>
            </div>
        </div>

        <?php require_once ROOT_PATH . "common/alert.php"; ?>

        <div class="row g-4 mt-2" id="farmerContainer">
            <?php if (! empty($farmers)) { ?>
                <?php foreach ($farmers as $farmer) { ?>
                    <div class="col-md-4 farmer-card-wrapper">
                        <div class="farmer-card text-center p-3">
                            <div class="farmer-info">
                                <?php
                                $avatar = (!empty($farmer) && !empty($farmer['farmer_avatarurl']))
                                    ? BASE_URL . 'uploads/' . $farmer['farmer_avatarurl']
                                    : BASE_URL . 'assets/images/default-avatar.png';
                                ?>
                                <img src="<?= $avatar ?>" alt="avatar" width="35" height="35" class="rounded-circle" style="object-fit: cover;">
                                <h6 class="text-success fw-semibold mb-2"><?= $farmer['farmer_fullname']; ?></h6>
                                <p class="mb-1"><i class="fas fa-map-marker-alt me-1 text-muted"></i> <?php echo $farmer['state_name']; ?></p>
                                <p class="mb-1"><i class="fas fa-envelope me-1 text-muted"></i> <?php echo $farmer['farmer_email']; ?></p>
                                <p class="mb-2"><i class="fas fa-phone me-1 text-muted"></i> <?php echo $farmer['farmer_phone']; ?></p>
                                <form action="process/update_farmer_status.php" method="post" class="d-inline-block mb-2">
                                    <select name="status" class="form-select form-select-sm d-inline-block w-auto">
                                        <option value="active" <?php echo $farmer['farmer_status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo $farmer['farmer_status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-success ms-1">Update</button>
                                </form>
                                <a href="admin_view_profile.php?id=<?php echo $farmer['farmer_id']; ?>" class="btn btn-success btn-sm px-3"><i class="fas fa-eye"></i> View Details</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="text-center text-muted py-5">
                    <i class="fas fa-user-slash fa-2x mb-3"></i>
                    <p>No farmers found yet.</p>
                </div>
            <?php } ?>
        </div>


        <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
            <h3 class="page-title">Manage Buyers</h3>
            <div class="search-bar">
                <input type="text" id="searchBuyerInput" placeholder="Search buyer name...">
                <button class="btn btn-success" onclick="filterBuyers()">Search</button>
            </div>
        </div>

        <div class="row g-4 mt-2" id="buyerContainer">
            <?php if (! empty($buyers)) { ?>
                <?php foreach ($buyers as $buyer) { ?>
                    <div class="col-md-4 buyer-card-wrapper">
                        <div class="buyer-card text-center p-3">
                            <div class="buyer-info">
                                <h6 class="text-success fw-semibold mb-2"><?= htmlspecialchars($buyer['buyer_fullname']); ?></h6>
                                <p class="mb-1"><i class="fas fa-map-marker-alt me-1 text-muted"></i> <?= htmlspecialchars($buyer['state_name']); ?></p>
                                <p class="mb-1"><i class="fas fa-envelope me-1 text-muted"></i> <?= htmlspecialchars($buyer['buyer_email']); ?></p>
                                <p class="mb-3"><i class="fas fa-phone me-1 text-muted"></i> <?= htmlspecialchars($buyer['buyer_phone']); ?></p>
                                <a href="#" class="btn btn-success btn-sm px-3"><i class="fas fa-eye"></i> View Details</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="text-center text-muted py-5">
                    <i class="fas fa-user-slash fa-2x mb-3"></i>
                    <p>No buyers found yet.</p>
                </div>
            <?php } ?>
        </div>
    </main>

    <script>
        function filterFarmers() {
            const input = document.getElementById("searchFarmerInput").value.toLowerCase();
            const farmers = document.querySelectorAll(".farmer-card-wrapper");
            farmers.forEach(card => {
                const name = card.querySelector("h6").textContent.toLowerCase();
                card.style.display = name.includes(input) ? "block" : "none";
            });
        }

        function filterBuyers() {
            const input = document.getElementById("searchBuyerInput").value.toLowerCase();
            const buyers = document.querySelectorAll(".buyer-card-wrapper");
            buyers.forEach(card => {
                const name = card.querySelector("h6").textContent.toLowerCase();
                card.style.display = name.includes(input) ? "block" : "none";
            });
        }
    </script>
</body>

</html>