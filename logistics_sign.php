<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="assets/images/logo.png" />
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/animate.min.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/fontawesome/css/all.css" />
    <title>AgriLink - Farmers to Consumers</title>
    <style>
      body {
        background: linear-gradient(to left, #e8f5e9, #c8e6c9);
        font-family: "Poppins", system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
      }
      <?php require_once 'assets/style.php'; ?>
      .con {
        margin-top: 3%;
      }
    </style>
  </head>
  <body>
    <?php require_once 'outhead.php'; ?>

    <section class="hero bg-success text-white">
      <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3"> Register As a Logistic </h1>
      </div>
    </section>

    <section class="container">
      <div class="row con justify-content-center">
        <div class="col-md-8">
          <div class="p-4">
            <p class="mb-3 text-muted text-center">
              Create your farmer profile to list produce and receive orders.
            </p>

            <?php require_once 'common/alert.php'; ?>

            <form action="process/process_logistics_sign.php" method="post">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Full Name</label>
                  <input class="form-control" type="text" name="fullname" required />
                </div>

                <div class="col-md-6">
                  <label class="form-label">Phone Number</label>
                  <input class="form-control" name="phone" type="tel" required />
                </div>

                <div class="col-md-6">
                  <label class="form-label">Email</label>
                  <input class="form-control" name="email" type="email" />
                </div>

                <div class="col-md-6">
                  <label class="form-label">Address</label>
                  <input class="form-control" name="address" type="text" />
                </div>

                <div class="col-md-6">
                  <input class="form-control" type="password" name="password" placeholder="Password" required />
                </div>
                <div class="col-md-6">
                  <input class="form-control" name="cpassword" type="password" placeholder="Confirm password" required />
                </div>
                <div class="col-12 d-grid">
                  <button class="btn btn-success" name="btn">Create account</button>
                </div>
                </div>
              </div>
            </form>

            <div class="text-center">
              <p>Already have an account? <a href="logistics_login.php" class="text-success">Login Here</a></p>
            </div>
          </div>
        </div>

      </div>
    </section>


    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
  </body>
</html>
