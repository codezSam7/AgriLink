<?php 
  session_start();
  require_once("../classes/Buyer.php");

  $b = new Buyer;

   $buyer = isset($_SESSION["buyer_online"]) ? $b->get_buyer_details($_SESSION["buyer_online"]) : [];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../assets/images/logo.png" />
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/animate.min.css" />
    <link rel="stylesheet" href="../assets/fontawesome/css/all.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>AgriLink - Farmers to Consumers</title>
    <style>
      body {
        background: linear-gradient(to left, #e8f5e9, #c8e6c9);
        font-family: "Poppins", system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
      }
      <?php require_once("../assets/style.php"); ?>
      .con {
        margin-top: 3%;
      }
    </style>
  </head>
  <body>
    <?php require_once("../common/header.php"); ?>

    <section class="hero bg-success text-white">
      <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3"> Register As a Buyer </h1>
      </div>
    </section>

    <div class="container con">
      <div class="row justify-content-center">
        <div class="col-md-7">
          <div class="p-4">
            <p class="small text-muted text-center">
              Create an account to place orders, save addresses and view order
              history.
            </p>

            <?php require_once("../common/alert.php"); ?>

            <form action="../process/process_sign_buyer.php" method="post">
              <div class="row g-4">
                <div class="col-md-6">
                  <label class="form-label">Full name</label>
                  <input class="form-control" name="fullname" required />
                </div>

                <div class="col-md-6">
                  <label class="form-label">Phone</label>
                  <input class="form-control" name="phone" type="tel" required />
                </div>

                <div class="col-md-12">
                  <label class="form-label">Email</label>
                  <input class="form-control" name="email" type="email" required />
                </div>

                <div class="col-md-6">
                  <label class="form-label">Password</label>
                  <input class="form-control" name="password" type="password" required />
                </div>
                <div class="col-md-6">
                  <label class="form-label">Confirm password</label>
                  <input class="form-control" name="cpassword" type="password" required />
                </div>

                <div class="col-12 d-grid">
                  <button class="btn btn-success" name="btn">Create account</button>
                </div>
              </div>
            </form>

            <div class="text-center">
              <p>Already have an account? <a href="login_buyer.php" class="text-success text-center">Login Here</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>



    <script src="../assets/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../assets/jquery.js"></script>
  </body> 
</html>
