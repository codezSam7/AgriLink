<?php
session_start();
require_once 'classes/Farmer.php';
require_once 'config/constants.php';

// User Guard - Protect the page
if (!isset($_SESSION['farmer_online'])) {
    $_SESSION['errormsg'] = "Please login to access your profile.";
    header('location: login_farmer.php');
    exit;
}

$f = new Farmer();
$farmer = $f->get_farmer_details($_SESSION['farmer_online']);

if (!$farmer) {
    $_SESSION['errormsg'] = "Unable to load profile. Please login again.";
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

    <title>Update Profile - AgriLink</title>

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

        .profile-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(15, 81, 50, 0.10);
            max-width: 680px;
            margin: 0 auto;
            overflow: hidden;
        }

        .profile-header {
            background: linear-gradient(135deg, var(--brand), #1a8f66);
            color: white;
            padding: 2rem 1.5rem;
            text-align: center;
        }

        .profile-pic {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            border: 1.5px solid #e0e7e0;
            padding: 0.85rem 1.1rem;
            font-size: 1.02rem;
        }

        .form-control:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(31, 169, 122, 0.15);
        }

        .btn-update {
            background: var(--brand);
            border: none;
            font-weight: 600;
            padding: 0.95rem;
            border-radius: 12px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .btn-update:hover {
            background: #1a8f66;
            transform: translateY(-2px);
        }

        .section-label {
            font-weight: 500;
            color: #444;
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<body>

    <?php require_once ROOT_PATH . 'outhead.php'; ?>

    <div class="container py-4">
        <div class="profile-card">

            <!-- Header -->
            <div class="profile-header">
                <img src="<?= !empty($farmer['farmer_avatarurl'])
                                ? BASE_URL . 'uploads/' . htmlspecialchars($farmer['farmer_avatarurl'])
                                : BASE_URL . 'assets/images/default_dp.png' ?>"
                    alt="Profile Picture"
                    class="profile-pic rounded-circle mb-3">

                <h3 class="mb-1"><?= htmlspecialchars($farmer['farmer_fullname']) ?></h3>
                <p class="mb-0 opacity-90">Update your farmer profile</p>
            </div>

            <div class="card-body p-4 p-lg-5">
                <?php require_once ROOT_PATH . 'common/alert.php'; ?>

                <form action="<?= BASE_URL ?>process/process_farmer_profile_update.php"
                    method="post"
                    enctype="multipart/form-data">

                    <div class="row g-4">
                        <!-- Full Name -->
                        <div class="col-md-12">
                            <label class="section-label">Full Name</label>
                            <input type="text"
                                name="fullname"
                                class="form-control"
                                value="<?= htmlspecialchars($farmer['farmer_fullname'] ?? '') ?>"
                                required>
                        </div>

                        <!-- Farm Name -->
                        <div class="col-md-12">
                            <label class="section-label">Farm Name</label>
                            <input type="text"
                                name="farmname"
                                class="form-control"
                                value="<?= htmlspecialchars($farmer['farmer_farm_name'] ?? '') ?>"
                                required>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <label class="section-label">Phone Number</label>
                            <input type="tel"
                                name="phone"
                                class="form-control"
                                value="<?= htmlspecialchars($farmer['farmer_phone'] ?? '') ?>"
                                required>
                        </div>

                        <!-- Primary Produce -->
                        <div class="col-md-6">
                            <label class="section-label">Primary Produce</label>
                            <input type="text"
                                name="primary_produce"
                                class="form-control"
                                value="<?= htmlspecialchars($farmer['farmer_primary_produce'] ?? '') ?>"
                                placeholder="e.g. Tomatoes, Maize, Cassava"
                                required>
                        </div>

                        <!-- Bio -->
                        <div class="col-12">
                            <label class="section-label">Bio / About Your Farm</label>
                            <textarea name="status"
                                class="form-control"
                                rows="4"
                                placeholder="Tell buyers about your farm and produce..."><?= htmlspecialchars($farmer['farmer_bio'] ?? '') ?></textarea>
                        </div>

                        <!-- Profile Picture Upload -->
                        <div class="col-12">
                            <label class="section-label">Change Profile Picture</label>
                            <input type="file"
                                name="cover"
                                class="form-control"
                                accept="image/*">
                            <small class="text-muted">Recommended: Square image (JPG or PNG)</small>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 mt-4">
                            <button type="submit"
                                name="updateprofilebtn"
                                class="btn btn-update btn-success w-100">
                                <i class="fas fa-save me-2"></i> Update Profile
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>