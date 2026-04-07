<?php
session_start();
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../classes/Farmer.php';

$f = new Farmer();

$farmer = $f->get_farmer_details($_SESSION['farmer_online']);

if (!isset($_SESSION['farmer_online'])) {
    $_SESSION['errormsg'] = "Please login to access your profile.";
    header('location: login_farmer.php');
    exit;
}

if (!$farmer) {
    $_SESSION['errormsg'] = "Profile could not be loaded. Please try logging in again.";
    header('location: login_farmer.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= BASE_URL ?>assets/images/logo.png" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/animate.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/fontawesome/css/all.css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <title>My Profile - <?= htmlspecialchars($farmer['farmer_fullname']) ?> | AgriLink</title>

    <style>
        :root {
            --brand: #1fa97a;
            --brand-dark: #0f5132;
        }

        body {
            font-family: 'Poppins', system-ui, sans-serif;
            background: linear-gradient(135deg, #f8faf9 0%, #e8f5e9 100%);
            min-height: 100vh;
            padding-top: 90px;
        }

        .profile-container {
            max-width: 820px;
            margin: 2rem auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(15, 81, 50, 0.10);
            overflow: hidden;
        }

        .profile-header {
            background: linear-gradient(135deg, var(--brand), #1a8f66);
            color: white;
            text-align: center;
            padding: 3rem 2rem 2rem;
        }

        .profile-pic {
            width: 130px;
            height: 130px;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .profile-details {
            padding: 2.5rem 2.5rem 3rem;
        }

        .detail-item {
            margin-bottom: 1.8rem;
        }

        .detail-item label {
            color: var(--brand);
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
        }

        .detail-item p {
            font-size: 1.05rem;
            color: #1b4332;
            background: #f8faf9;
            padding: 12px 16px;
            border-radius: 10px;
            margin: 0;
        }

        .btn-edit {
            background: var(--brand);
            border: none;
            font-weight: 600;
            padding: 0.9rem 2.5rem;
            border-radius: 50px;
        }

        .btn-edit:hover {
            background: #1a8f66;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <?php require_once ROOT_PATH . "outhead.php"; ?>
    <?php require_once ROOT_PATH . "common/alert.php"; ?>

    <div class="container">
        <div class="profile-container">
            <div class="profile-header">
                <img src="<?= !empty($farmer['farmer_avatarurl'])  ? BASE_URL . 'uploads/' . htmlspecialchars($farmer['farmer_avatarurl']) : BASE_URL . 'assets/images/default_dp.png' ?>"
                    alt="Profile Picture"
                    class="profile-pic rounded-circle mb-3">

                <h2 class="fw-bold mb-1"><?= htmlspecialchars($farmer['farmer_fullname']) ?></h2>
                <p class="mb-0 fs-5"><?= htmlspecialchars($farmer['farmer_farm_name'] ?? 'Farm Owner') ?></p>
            </div>

            <div class="profile-details">
                <form id="farmerForm" action="<?= BASE_URL ?>process/process_farmer_profile_update.php" method="post" enctype="multipart/form-data">

                    <div class="row g-4">
                        <div class="col-md-6 detail-item">
                            <label><i class="bi bi-person-fill"></i> Full Name</label>
                            <p><?= htmlspecialchars($farmer['farmer_fullname'] ?? 'N/A') ?></p>
                        </div>

                        <div class="col-md-6 detail-item">
                            <label><i class="bi bi-shop"></i> Farm Name</label>
                            <p><?= htmlspecialchars($farmer['farmer_farm_name'] ?? 'N/A') ?></p>
                        </div>

                        <div class="col-md-6 detail-item">
                            <label><i class="bi bi-telephone-fill"></i> Phone Number</label>
                            <p><?= htmlspecialchars($farmer['farmer_phone'] ?? 'N/A') ?></p>
                        </div>

                        <div class="col-md-6 detail-item">
                            <label><i class="bi bi-envelope-fill"></i> Email</label>
                            <p><?= htmlspecialchars($farmer['farmer_email'] ?? 'N/A') ?></p>
                        </div>

                        <div class="col-md-6 detail-item">
                            <label><i class="bi bi-geo-alt-fill"></i> State</label>
                            <p><?= htmlspecialchars($farmer['state_name'] ?? $farmer['farmer_state'] ?? 'N/A') ?></p>
                        </div>

                        <div class="col-md-6 detail-item">
                            <label><i class="bi bi-house-door-fill"></i> Address</label>
                            <p><?= htmlspecialchars($farmer['farmer_address'] ?? 'N/A') ?></p>
                        </div>

                        <div class="col-12 detail-item">
                            <label><i class="bi bi-seedling"></i> Primary Produce</label>
                            <p><?= htmlspecialchars($farmer['farmer_primary_produce'] ?? 'Not specified') ?></p>
                        </div>

                        <div class="col-12 detail-item">
                            <label><i class="bi bi-card-text"></i> Bio</label>
                            <p><?= nl2br(htmlspecialchars($farmer['farmer_bio'] ?? 'No bio added yet.')) ?></p>
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <a href="update_profile.php" class="btn btn-edit btn-success">
                            <i class="bi bi-pencil-square me-2"></i> Update Profile
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>