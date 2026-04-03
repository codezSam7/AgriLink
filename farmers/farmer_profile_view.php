<?php
session_start();
require_once '../config/constants.php';
require_once '../classes/Farmer.php';

$f = new Farmer();

// ✅ Get ID from URL
if (!isset($_GET['id'])) {
  $_SESSION['errormsg'] = "Invalid farmer selected.";
  header('location: ' . BASE_URL);
  exit;
}

$farmer_id = (int) $_GET['id'];

// ✅ Fetch correct farmer
$farmer = $f->get_farmer_details($farmer_id);

if (!$farmer) {
  $_SESSION['errormsg'] = "Farmer not found.";
  header('location: ' . BASE_URL);
  exit;
}

$products = $f->fetch_farmer_products($farmer_id);
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

  <title><?= htmlspecialchars($farmer['farmer_fullname']) ?> - AgriLink</title>

  <style>
    :root {
      --brand: #1fa97a;
    }

    body {
      font-family: 'Poppins', system-ui, sans-serif;
      background: linear-gradient(135deg, #f8faf9 0%, #e8f5e9 100%);
      padding-top: 90px;
      min-height: 100vh;
    }

    .farmer-hero {
      background: linear-gradient(rgba(15, 81, 50, 0.85), rgba(31, 169, 122, 0.8));
      color: white;
      padding: 5rem 0 4rem;
      text-align: center;
    }

    .profile-pic-large {
      width: 160px;
      height: 160px;
      object-fit: cover;
      border: 6px solid white;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>

<body>

  <?php require_once ROOT_PATH . "outhead.php"; ?>
  <?php require_once ROOT_PATH . 'common/alert.php'; ?>

  <section class="farmer-hero">
    <div class="container">
      <img src="<?= !empty($farmer['farmer_avatarurl'])
                  ? BASE_URL . 'uploads/' . htmlspecialchars($farmer['farmer_avatarurl'])
                  : BASE_URL . 'assets/images/farmer-placeholder.jpg' ?>"
        alt="<?= htmlspecialchars($farmer['farmer_fullname']) ?>"
        class="profile-pic-large rounded-circle mb-4">

      <h1 class="display-5 fw-bold"><?= htmlspecialchars($farmer['farmer_fullname']) ?></h1>
      <p class="lead mb-1"><?= htmlspecialchars($farmer['farmer_farm_name'] ?? 'Dedicated Farmer') ?></p>
      <p><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($farmer['state_name'] ?? 'Nigeria') ?></p>
    </div>
  </section>

  <div class="container py-5">
    <div class="row g-5">
      <div class="col-lg-5">
        <h3 class="text-success mb-4">About the Farmer</h3>
        <p class="lead text-muted">
          <?= nl2br(htmlspecialchars($farmer['farmer_bio'] ?? 'No bio available.')) ?>
        </p>

        <div class="mt-5">
          <strong class="d-block mb-2 text-success">Primary Produce</strong>
          <p class="fs-5"><?= htmlspecialchars($farmer['farmer_primary_produce'] ?? 'Various crops') ?></p>
        </div>

        <div class="mt-4">
          <strong class="d-block mb-2 text-success">Contact</strong>
          <p><?= htmlspecialchars($farmer['farmer_phone'] ?? 'Not provided') ?></p>
        </div>
      </div>

      <div class="col-lg-7">
        <h3 class="text-success mb-4">Products from this Farm</h3>
        <?php if (!empty($products)): ?>
          <div class="row g-4">
            <?php foreach ($products as $p): ?>
              <div class="col-6 col-md-4">
                <div class="card h-100">
                  <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($p['product_image'] ?? 'placeholder.jpg') ?>"
                    style="height:160px; object-fit:cover;" class="card-img-top">
                  <div class="card-body text-center">
                    <h6><?= htmlspecialchars($p['product_name']) ?></h6>
                    <p class="text-success fw-bold">
                      ₦<?= number_format($p['product_price']) ?>
                      <small>/ <?= htmlspecialchars($p['product_unit'] ?? '') ?></small>
                    </p>
                    <a href="<?= BASE_URL ?>product_details.php?id=<?= $p['product_id'] ?>"
                      class="btn btn-outline-success btn-sm w-100">View Details</a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p class="text-muted">This farmer has not listed any products yet.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script src="<?= BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>