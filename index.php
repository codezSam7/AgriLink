<?php
session_start();
require_once 'classes/Farmer.php';
require_once 'classes/Buyer.php';
require_once 'config/constants.php';
$f = new Farmer();
$b = new Buyer();
$farmer_online = $_SESSION['farmer_online'] ?? null;
$buyer_online  = $_SESSION['buyer_online'] ?? null;
$current_farmer = $farmer_online ? $f->get_farmer_details($farmer_online) : [];
$current_buyer  = $buyer_online  ? $b->get_buyer_details($buyer_online)  : [];
$featured_farmers = $f->fetch_farmers(8);
$featured_products = $f->fetch_products(12);
?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AgriLink - Fresh From Farm to You</title>
  <link rel="icon" href="<?= BASE_URL ?>assets/images/logo.png" type="image/png" />

  <!-- Bootstrap 5 + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/fontawesome/css/all.min.css" />

  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --accent: #0f5132;
      --accent-2: #1fa97a;
      --accent-light: #e8f5e9;
      --text-dark: #1a2e1f;
      --text-muted: #5c6b5e;
      --bg-light: #f8faf9;
    }

    body {
      font-family: 'Poppins', system-ui, sans-serif;
      color: var(--text-dark);
      background: var(--bg-light);
      line-height: 1.6;
      padding-top: 90px;
    }

    h1,
    h2,
    h3,
    .display-4 {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
    }

    /* HERO */
    .hero {
      background: linear-gradient(rgba(15, 81, 50, 0.72), rgba(31, 169, 122, 0.55)),
        url('assets/images/index.png') center/cover no-repeat;
      color: white;
      min-height: 88vh;
      display: flex;
      align-items: center;
      position: relative;
    }

    .hero-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to bottom, rgba(0, 0, 0, 0.15), rgba(0, 0, 0, 0.5));
    }

    .hero h1 {
      font-size: clamp(2.6rem, 8vw, 4.8rem);
      line-height: 1.05;
      text-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
    }

    .hero p.lead {
      font-size: clamp(1.15rem, 3.5vw, 1.55rem);
      text-shadow: 0 2px 8px rgba(0, 0, 0, 0.45);
    }

    .search-input .form-control {
      border-radius: 50rem 0 0 50rem;
      border: none;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
    }

    .search-input .btn {
      border-radius: 0 50rem 50rem 0;
      padding: 0 2.2rem;
      font-weight: 600;
    }

    /* Cards */
    .product-card,
    .farmer-card {
      border: none;
      border-radius: 20px;
      overflow: hidden;
      transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 8px 25px rgba(15, 81, 50, 0.08);
    }

    .product-card:hover,
    .farmer-card:hover {
      transform: translateY(-12px);
      box-shadow: 0 25px 50px rgba(15, 81, 50, 0.18);
    }

    .product-img {
      height: 235px;
      object-fit: cover;
    }

    .category-chip {
      background: rgba(31, 169, 122, 0.12);
      color: var(--accent-2);
      border-radius: 9999px;
      padding: 0.55rem 1.2rem;
      font-size: 0.95rem;
      font-weight: 500;
      transition: all 0.25s ease;
    }

    .category-chip:hover {
      background: var(--accent-2);
      color: white;
      transform: translateY(-3px);
    }

    .section-title {
      font-size: 2.5rem;
      position: relative;
      display: inline-block;
      margin-bottom: 2.8rem;
    }

    .section-title:after {
      content: '';
      position: absolute;
      bottom: -14px;
      left: 50%;
      transform: translateX(-50%);
      width: 85px;
      height: 5px;
      background: var(--accent-2);
      border-radius: 3px;
    }

    /* Mobile Optimizations */
    @media (max-width: 767px) {
      body {
        padding-top: 78px;
      }

      .hero {
        min-height: 75vh;
        padding-top: 4rem;
      }

      .product-img {
        height: 190px;
      }

      .section-title {
        font-size: 2.1rem;
      }
    }

    .btn-accent {
      background: var(--accent-2);
      border: none;
      font-weight: 600;
      box-shadow: 0 6px 20px rgba(31, 169, 122, 0.3);
    }

    .btn-accent:hover {
      background: #1a8f66;
      transform: translateY(-2px);
    }
  </style>
</head>

<body class="d-flex flex-column min-vh-100">

  <?php require_once ROOT_PATH . 'outhead.php'; ?>

  <!-- HERO -->
  <section class="hero text-center text-white animate__animated animate__fadeIn">
    <div class="hero-overlay"></div>
    <div class="container position-relative z-3">
      <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-9">
          <h1 class="fw-bold mb-4 animate__animated animate__delay-1s">
            Fresh Farm Goodness<br>Direct to Your Door
          </h1>
          <p class="lead mb-5 opacity-90 animate__animated animate__delay-1s">
            Connecting passionate farmers with families who value real, traceable food.
          </p>

          <!-- Search -->
          <div class="row justify-content-center mb-4 mb-md-5">
            <div class="col-11 col-sm-10 col-md-9 col-lg-7 search-input">
              <div class="input-group input-group-lg">
                <input type="search" class="form-control" placeholder="Search vegetables, fruits, farmers..." aria-label="Search">
                <button class="btn btn-accent" type="button">
                  <i class="bi bi-search me-2"></i>Find
                </button>
              </div>
            </div>
          </div>

          <?php if (!$farmer_online && !$buyer_online): ?>
            <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center animate__animated animate__delay-2s mb-5">
              <a href="<?= BASE_URL ?>farmers/sign_farmer.php" class="btn btn-outline-light btn-lg px-5 py-3">Become a Farmer</a>
              <a href="<?= BASE_URL ?>buyers/sign_buyer.php" class="btn btn-accent btn-lg px-5 py-3 shadow">Shop Fresh Now</a>
            </div>
          <?php endif; ?>

          <!-- Category Pills -->
          <div class="d-flex flex-wrap gap-2 gap-sm-3 justify-content-center">
            <a href="<?= BASE_URL ?>vegetables.php" class="category-chip">Vegetables</a>
            <a href="<?= BASE_URL ?>fruits.php" class="category-chip">Fruits</a>
            <a href="<?= BASE_URL ?>grains_legumes.php" class="category-chip">Grains & Legumes</a>
            <a href="<?= BASE_URL ?>livestock.php" class="category-chip">Poultry & Meat</a>
            <a href="#" class="category-chip">Organic Picks</a>
            <a href="#" class="category-chip">Seasonal</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured Products -->
  <section class="py-5 bg-white">
    <div class="container">
      <h2 class="section-title text-center mx-auto">Popular Fresh Picks</h2>
      <div class="row g-4">
        <?php foreach (array_slice($featured_products, 0, 8) as $p):
          $price = number_format($p['product_price'] ?? 0);
          $unit  = $p['product_unit'] ?? 'kg';
          $img   = $p['product_image'] ?? 'placeholder.jpg';
          $name  = $p['product_name'] ?? 'Fresh Produce';
          $farmer_name = explode(' ', $p['farmer_fullname'] ?? 'Farmer')[0];
        ?>
          <div class="col-6 col-md-4 col-lg-3">
            <div class="card product-card h-100">
              <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($img) ?>" class="product-img card-img-top" alt="<?= htmlspecialchars($name) ?>">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title mb-2"><?= htmlspecialchars($name) ?></h5>
                <div class="mt-auto">
                  <p class="fs-5 fw-bold text-success mb-1">₦<?= $price ?> <small class="text-muted">/ <?= $unit ?></small></p>
                  <p class="small text-muted mb-3">By <?= htmlspecialchars($farmer_name) ?></p>
                  <a href="<?= BASE_URL ?>product_details.php?id=<?= $p['id'] ?? '' ?>" class="btn btn-outline-accent btn-sm w-100">View Details</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="text-center mt-5">
        <a href="<?= BASE_URL ?>products.php" class="btn btn-outline-accent btn-lg px-5">View All Products</a>
      </div>
    </div>
  </section>

  <!-- Top Farmers -->
  <section class="py-5 bg-light">
    <div class="container">
      <h2 class="section-title text-center mx-auto">Meet Our Top Farmers</h2>
      <div class="row g-4">
        <?php foreach (array_slice($featured_farmers, 0, 6) as $farmer): ?>
          <div class="col-md-6 col-lg-4">
            <div class="card farmer-card h-100 text-center">
              <div class="card-body">
                <div class="mb-4">
                  <img src="<?= BASE_URL ?>assets/images/farmer-placeholder.jpg" alt="<?= htmlspecialchars($farmer['farmer_fullname']) ?>"
                    class="rounded-circle" width="100" height="100"
                    style="object-fit:cover; border:5px solid var(--accent-light)">
                </div>
                <h5 class="mb-2"><?= htmlspecialchars($farmer['farmer_fullname']) ?></h5>
                <p class="small text-muted mb-2"><?= htmlspecialchars($farmer['state_name'] ?? 'Nigeria') ?></p>
                <p class="fw-medium text-success mb-4">
                  Specializes in <?= htmlspecialchars($farmer['farmer_primary_produce'] ?? 'Various crops') ?>
                </p>
                <a href="<?= BASE_URL ?>farmers/farmer_details.php?id=<?= $farmer['id'] ?? '' ?>" class="btn btn-outline-accent btn-sm px-4">View Profile</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="text-center mt-5">
        <a href="<?= BASE_URL ?>farmers/farmers.php" class="btn btn-outline-accent btn-lg px-5">Discover More Farmers</a>
      </div>
    </div>
  </section>

  <!-- How It Works -->
  <section class="py-5 bg-white text-center">
    <div class="container" style="max-width: 1100px;">
      <h2 class="section-title mx-auto">How AgriLink Works</h2>
      <div class="row g-5 mt-3">
        <div class="col-md-4 animate__animated animate__fadeIn">
          <i class="bi bi-person-plus-fill display-1 text-accent-2 mb-4"></i>
          <h4 class="mb-3">1. Sign Up</h4>
          <p class="text-muted px-3">Create your free account as a farmer or buyer in minutes.</p>
        </div>
        <div class="col-md-4 animate__animated animate__fadeIn animate__delay-1s">
          <i class="bi bi-basket-fill display-1 text-accent-2 mb-4"></i>
          <h4 class="mb-3">2. List or Shop</h4>
          <p class="text-muted px-3">Farmers list fresh produce • Buyers discover & order directly.</p>
        </div>
        <div class="col-md-4 animate__animated animate__fadeIn animate__delay-2s">
          <i class="bi bi-truck display-1 text-accent-2 mb-4"></i>
          <h4 class="mb-3">3. Deliver & Enjoy</h4>
          <p class="text-muted px-3">Secure payment • Reliable delivery • Farm-fresh to your table.</p>
        </div>
      </div>
    </div>
  </section>

  <?php require_once ROOT_PATH . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>