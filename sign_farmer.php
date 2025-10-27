<?php 
  session_start();
  require_once("classes/User.php");
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
    <!-- <link rel="stylesheet" href="assets/fontawesome/css/all.css" /> -->
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
          <h1 class="mb-3 text-center">Register as a <span class="text-success">farmer</span></h1>
          <p class="mb-3 text-muted text-center">
            Create your farmer profile to list produce and receive orders.
          </p>

          <?php require_once("assets/common/alert.php"); ?>

          <form action="process/process_sign_farmer.php" method="post">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Full Name</label>
                <input class="form-control" type="text" name="fullname" required />
              </div>
              <div class="col-md-6">
                <label class="form-label">Farm Name</label>
                <input class="form-control" type="text" name="farmname" />
              </div>

              <div class="col-md-6">
                <label class="form-label">Phone Number</label>
                <input class="form-control" name="phone" type="tel" required />
              </div>

              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input class="form-control" name="email" type="email" />
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
                <label class="form-label">Primary produce</label>
                <input
                  class="form-control"
                  name="prip"
                  placeholder="e.g. Tomatoes, Maize"
                />
              </div>

              <div class="col-md-6">
                <label class="form-label">Farm size (hectares)</label>
                <input class="form-control" type="number" name="farm_s" />
              </div>

              <div class="col-12">
                <textarea class="form-control" rows="3" name="message" placeholder="Short bio"></textarea>
              </div>

              <div class="col-md-6">
                <input class="form-control" type="password" name="password" placeholder="Password" required />
              </div>
              <div class="col-md-6">
                <input class="form-control" name="cpassword" type="password" placeholder="Confirm password" required />
              </div>

              <div class="col-12">
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    id="terms"
                    name="agree"
                  />
                  <label class="form-check-label small" for="terms"
                    >I accept the terms & conditions</label
                  >
                  </div>
                </div>

                <div class="col-12 d-grid">
                  <button class="btn btn-success" name="btn">Create account</button>
                </div>
              </div>
            </div>
          </form>
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
          $("#delvlga").load("process/process_state_lga.php?id="+state_id);
        })
      })
    </script>
  </body>
</html>
