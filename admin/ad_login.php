<?php
  session_start();

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
        <h1 class="display-4 fw-bold mb-3"> Login As An Admin </h1>
      </div>
    </section>
    
    <section class="container">
      <div class="row con justify-content-center">
        <div class="col-md-8">
          <div class="p-4">
            <form action="process/process_login_admin.php" method="post">
              <div class="row g-4">
                <div class="col-md-8 offset-md-2">
                  <?php require_once("../common/alert.php"); ?>
                </div>

                <div class="col-md-8 offset-md-2">
                  <input class="form-control" type="text" name="username" placeholder="Username" required />
                </div>

                <div class="col-md-8 offset-md-2">
                  <input class="form-control" type="password" name="password" placeholder="Password" required />
                </div>
                <div class="col-md-8 offset-md-2">
                  <input class="form-control" name="cpassword" type="password" placeholder="Confirm password" required />
                </div>

                <div class="col-md-8 offset-md-2 d-grid">
                  <button class="btn btn-success" name="btn">Login</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <script src="../assets/bootstrap/js/bootstrap.bundle.js"></script>
  </body>
</html>