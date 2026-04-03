<?php
session_start();
require_once 'config/constants.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="assets/images/logo.png" />
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="assets/animate.min.css" />
  <link rel="stylesheet" href="assets/fontawesome/css/all.css" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <title>AgriLink - Logistics Login</title>

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

    .hero {
      background: linear-gradient(rgba(15, 81, 50, 0.92), rgba(31, 169, 122, 0.88)),
        url('assets/images/logistics-hero.jpg') center/cover no-repeat;
      /* Add a nice logistics image if available */
      color: white;
      padding: 4rem 0 3rem;
      text-align: center;
      margin-bottom: 3rem;
    }

    .login-card {
      background: white;
      border-radius: 20px;
      box-shadow: 0 15px 40px rgba(15, 81, 50, 0.12);
      overflow: hidden;
      max-width: 520px;
      margin: 0 auto;
    }

    .login-card .card-body {
      padding: 2.5rem 2rem;
    }

    .form-control {
      border-radius: 12px;
      border: 1.5px solid #e0e7e0;
      padding: 0.85rem 1.1rem;
      font-size: 1.02rem;
    }

    .form-control:focus {
      border-color: var(--brand);
      box-shadow: 0 0 0 4px rgba(31, 169, 122, 0.15);
    }

    .btn-login {
      background: var(--brand);
      border: none;
      font-weight: 600;
      padding: 0.9rem;
      border-radius: 12px;
      font-size: 1.1rem;
      transition: all 0.3s ease;
    }

    .btn-login:hover {
      background: #1a8f66;
      transform: translateY(-2px);
    }

    .hero h1 {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2.2rem, 5vw, 2.8rem);
    }
  </style>
</head>

<body>

  <?php require_once ROOT_PATH . 'outhead.php'; ?>

  <!-- Hero Banner -->
  <section class="hero">
    <div class="container">
      <h1 class="display-5 fw-bold mb-2">Logistics Partner Login</h1>
      <p class="lead opacity-90 mb-0">
        Deliver fresh produce • Update status • Grow with AgriLink
      </p>
    </div>
  </section>

  <section class="container pb-5">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">
        <div class="login-card">
          <div class="card-body">
            <div class="text-center mb-4">
              <i class="fas fa-truck-loading fa-3x text-success mb-3"></i>
              <p class="text-muted mb-0">
                Continue with your logistics account to manage deliveries and update status.
              </p>
            </div>

            <?php require_once ROOT_PATH . 'common/alert.php'; ?>

            <form action="<?= BASE_URL ?>process/process_logistics_login.php" method="post">
              <div class="row g-4">
                <div class="col-12">
                  <label class="form-label fw-medium">Email Address</label>
                  <input type="email" name="email" class="form-control" />
                </div>

                <div class="col-12">
                  <label class="form-label fw-medium">Password</label>
                  <input type="password" name="password" class="form-control" placeholder="Enter your password" required />
                </div>

                <div class="col-12 mt-3">
                  <button type="submit" name="btn" class="btn btn-login btn-success w-100">
                    <i class="fas fa-sign-in-alt me-2"></i> Login as Logistics
                  </button>
                </div>
              </div>
            </form>

            <div class="text-center mt-4 pt-3 border-top">
              <p class="mb-0 text-muted">
                Don't have an account yet?
                <a href="<?= BASE_URL ?>logistics_sign.php" class="text-success fw-medium text-decoration-none">
                  Register Here
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="<?= BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>