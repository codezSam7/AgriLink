<?php 
  session_start(); 
  require_once("../classes/User.php");
  $c = new User;
  $states = $c->fetch_all_states();
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
    <title>AgriLink - Farmers to Consumers</title>
    <style>
      body {
        background: linear-gradient(to left, #e8f5e9, #c8e6c9);
        font-family: "poppins", monospace;
      }
      <?php include("../assets/style.php"); ?>
      .con {
        margin-top: 3%;
      }
    </style>
  </head>
  <body class="container py-5">
    <nav class="navbar bar fixed-top navbar-expand-md mb-5 glass-navbar">
      <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="../index.php">
          <img width="56" height="56" src="../assets/images/logo.png" alt=""/>
          <div class="ms-2 d-none d-md-block">
            <div style="font-weight:800; color:#1fa97a;">AgriLink</div>
            <small class="text-muted">Farmers → Consumers</small>
          </div>
        </a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav mx-auto gap-4">
            <li class="nav-item">
              <a
                class="bar-link active"
                href="../index.php"
                >Home</a
              >
            </li>
            <li class="nav-item">
              <a class="bar-link" href="../farmers.php">Farmers</a>
            </li>
            <li class="nav-item">
              <a class="bar-link" href="../products.php">Products</a>
            </li>
            <li class="nav-item">
              <a class="bar-link" href="../orders.php">Orders</a>
            </li>
            <li class="nav-item">
              <a class="bar-link" href="../admin.php">Admin</a>
            </li>
            <li class="nav-item">
              <a class="bar-link" href="../contact.php">Contact</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="dropdown collapse navbar-collapse" id="navbarNavDropdown">
        <button
          class="btn btn-success dropdown-toggle m-3"
          type="button"
          data-bs-toggle="dropdown"
          aria-expanded="false"
        >
          Register
        </button>
        <ul class="dropdown-menu">
          <li>
            <a href="sign_farmer.php" class="dropdown-item"
              >As a farmer</a
            >
          </li>
          <li>
            <a href="sign_buyer.php" class="dropdown-item"
              >As a buyer</a
            >
          </li>
        </ul>
      </div>
    </nav>

    <div class="container con">
      <div class="row justify-content-center">
        <div class="col-md-7">
          <div class="p-4">
            <h1 class="mb-3 text-center">Register as a <span class="text-success">consumer</span></h1>
            <p class="small text-muted text-center">
              Create an account to place orders, save addresses and view order
              history.
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

                <div class="col-md-12">
                  <label class="form-label">Delivery address - state</label>
                  <select class="form-select" id="delvstate" name="delvstate">
                    <option value="">Select State</option>
                    <?php 
                      foreach($states as $state){ 
                    ?>
                      <option value="<?php echo $state['state_id'] ?>">
                        <?php echo htmlspecialchars($state['state_name']) ?>
                      </option>
                    <?php 
                      }; 
                    ?>
                  </select>
                </div>

                <div class="col-md-12">
                  <label class="form-label">Delivery address - lga</label>
                  <select class="form-select" name="delvlga" id="delvlga"></select>
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
          </div>
        </div>
      </div>
    </div>



    <script src="../assets/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../assets/jquery.js"></script>
    <script>
      // jQuery
      $(document).ready(function(){
        $("#delvstate").change(function(){
        var state_id = $(this).val();
          $("#delvlga").load("../process/process_state_lga.php?id="+state_id);
        })
      })
    </script>
  </body> 
</html>
