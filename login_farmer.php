<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="assets/images/logo.png" />
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/animate.min.css" />
    <link rel="stylesheet" href="assets/fontawesome/css/all.css" />
    <title>AgriLink - Farmers to Consumers</title>
    <style>
      body {
        background: linear-gradient(to left, #e8f5e9, #c8e6c9);
        font-family: "poppins", monospace;
      }
      <?php require_once("assets/style.php"); ?>
      .con {
        margin-top: 3%;
      }
    </style>
  </head>
  <body class="container py-5">
    <?php require_once("assets/common/header.php"); ?>
    <div class="row con justify-content-center">
    <div class="col-md-8">
      <div class="p-4">
        <h1 class="mb-3 text-center">Login as a <span class="text-success">farmer</span></h1>
        <p class="mb-3 text-muted text-center">
          Create your farmer profile to list produce and receive orders.
        </p>

        <?php 
          if(isset($_SESSION["msg"])){ 
        ?>  
          <p class="alert alert-success">
            <?php echo $_SESSION["msg"]; unset($_SESSION["msg"]); ?>
          </p>
        <?php 
          } 
        ?>

        <?php 
          if(isset($_SESSION["errormsg"])){ 
        ?>  
          <p class="alert alert-danger">
            <?php echo $_SESSION["errormsg"]; unset($_SESSION["errormsg"]); ?>
          </p>
        <?php 
          } 
        ?>

        <form action="../process/process_login_farmer.php" method="post">
          <div class="row g-5">
            <div class="col-md-6">
              <label class="form-label">Full Name</label>
              <input class="form-control" type="text" name="fullname" required />
            </div>

            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input class="form-control" type="email" name="email" />
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
        </form>
      </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
  </body>
</html>