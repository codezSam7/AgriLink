<?php
session_start();
require_once 'classes/Farmer.php';
// print_r($_SESSION);
// put a user guard to protect the page
// retrieve the details of a user
$f = new Farmer;
$farmer = $f->get_farmer_details($_SESSION['farmer_online']);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="assets/animate.min.css" />
  <link rel="stylesheet" href="assets/fontawesome/css/all.css" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <title>AgriLink - Farmers to Consumers</title>
  <style>
    body {
      background: linear-gradient(to left, #e8f5e9, #c8e6c9);
      font-family: "Poppins", system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
    }
    <?php require_once 'assets/style.php'; ?>
    .con{
        margin-top: 5%;
    }
  </style>
</head>
<body class="con">
  <?php require_once 'outhead.php'; ?>

  <?php require_once 'common/alert.php'?>
    <section class="py-5 my-5">
        <div class="container my-2">
            <div class="row g-4">

                <div class="col-md-8 offset-md-2">
                    <div class="card h-100 shadow-sm product-card">

                        <!-- Header (Dashboard Nav) -->
                        <div class="card-header bg-success border-bottom">
                            <!-- <?php require_once 'common/nav.php'; ?> -->
                        </div>

                        <div class="card-body">

                            <!-- Page Title -->
                            <h3 class="text-center text-success pt-4 mb-4">Update Profile</h3>

                            <!-- Display Picture -->
                            <div class="text-center mb-4">
                                <?php
                                    $avatar = ! empty($farmer['farmer_avatarurl'])
                                        ? 'uploads/'.$farmer['farmer_avatarurl']
                                        : 'assets/images/default_dp.png';
?>
                                <img src="<?php echo $avatar; ?>" 
                                    alt="Display Picture" 
                                    class="profile-pic rounded-circle border">
                            </div>

                            <div class="row g-4 pb-5">

                                <?php require_once 'common/alert.php'; ?>

                                <form action="process/process_farmer_profile_update.php" 
                                    method="post" 
                                    enctype="multipart/form-data">

                                    <!-- Fullname -->
                                    <div class="mb-3">
                                        <label for="fullname" class="form-label">Full Name</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="fullname" 
                                            name="fullname" 
                                            value="<?php echo $farmer['farmer_fullname']; ?>" 
                                            required
                                        >
                                    </div>

                                    <div class="mb-3">
                                        <label for="farmname" class="form-label">Farm Name</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="farmname" 
                                            name="farmname" 
                                            value="<?php echo $farmer['farmer_farm_name']; ?>" 
                                            required
                                        >
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="phone" 
                                            name="phone" 
                                            value="<?php echo $farmer['farmer_phone']; ?>" 
                                            required
                                        >
                                    </div>

                                    <div class="mb-3">
                                        <label for="primary_produce" class="form-label">Primary Produce</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="primary_produce" 
                                            name="primary_produce" 
                                            value="<?php echo $farmer['farmer_primary_produce']; ?>" 
                                            required
                                        >
                                    </div>

                                    <!-- Bio -->
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Bio</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="status" 
                                            name="status" 
                                            placeholder="Write something about yourself..."
                                            value="<?php echo $farmer['farmer_bio'] ?? ''; ?>"
                                        >
                                    </div>

                                    <!-- Display Picture Upload -->
                                    <div class="mb-3">
                                        <label for="cover" class="form-label">Change Display Picture</label>
                                        <input 
                                            type="file" 
                                            class="form-control" 
                                            id="cover" 
                                            name="cover"
                                        >
                                    </div>

                                    <!-- Submit -->
                                    <button name="updateprofilebtn" 
                                            class="btn btn-success w-100">
                                        Update Profile
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>



  <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>