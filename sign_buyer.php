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



    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/jquery.js"></script>
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
