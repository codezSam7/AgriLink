<?php  
  session_start();
  require_once("../classes/Farmer.php");

  $f = new Farmer;
  $farmer = isset($_SESSION["farmer_online"]) ? $f->get_farmer_details($_SESSION["farmer_online"]) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../assets/animate.min.css" />
  <link rel="stylesheet" href="../assets/fontawesome/css/all.css" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <title>AgriLink - Farmer Details</title>

  <style>
    body {
      background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
      font-family: "Poppins", system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }

    .profile-container {
      margin-top: 6rem;
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.08);
      overflow: hidden;
      max-width: 900px;
      transition: 0.3s;
    }

    .profile-header {
      background: #1fa97a;
      color: #fff;
      text-align: center;
      padding: 50px 20px;
      position: relative;
    }

    .profile-header img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      border: 4px solid #fff;
      margin-bottom: 15px;
    }

    .profile-header h3 {
      font-weight: 700;
      margin-bottom: 5px;
    }

    .profile-header p {
      font-weight: 400;
      opacity: 0.9;
    }

    .profile-details {
      padding: 40px;
    }

    .detail-item {
      margin-bottom: 25px;
    }

    .detail-item label {
      color: #388e3c;
      font-weight: 600;
      margin-bottom: 5px;
      display: block;
    }

    .detail-item p, .detail-item input {
      color: #1b4332;
      font-size: 15px;
    }

    .detail-item input {
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 6px 10px;
      width: 100%;
      display: none;
    }

    .card-footer {
      background: #f1f8f4;
      border-top: 1px solid #dcedc8;
      text-align: center;
      padding: 20px;
    }

    .card-footer button {
      border-radius: 25px;
      padding: 8px 20px;
    }

    <?php require_once("../assets/style.php"); ?>
  </style>
</head>
<body>

  <?php require_once("../common/header.php"); ?>

  <div class="container d-flex justify-content-center align-items-center">
    <div class="profile-container">
      <div class="profile-header">
        <?php  
          if(isset($farmer["farmer_online"])){
        ?>
          <h3 class="fw-bold mb-0">
            <?php echo $farmer['farmer_fullname']; ?>
          </h3>
          <p class="mb-0"><?php echo $farmer['farm_name']; ?></p>
        </div>
        <?php 
          }
        ?>

      <form id="farmerForm" class="profile-details">
        <div class="row">
          <div class="col-md-6 detail-item">
            <label><i class="bi bi-envelope"></i> Email</label>
            <p><?php echo $farmer['farmer_email']; ?></p>
            <input type="email" name="farmer_email" value="<?php echo $farmer['farmer_email']; ?>">
          </div>

          <div class="col-md-6 detail-item">
            <label><i class="bi bi-telephone"></i> Phone</label>
            <p><?php echo $farmer['farmer_phone']; ?></p>
            <input type="text" name="farmer_phone" value="<?php echo $farmer['farmer_phone']; ?>">
          </div>

          <div class="col-md-6 detail-item">
            <label><i class="bi bi-geo-alt"></i> State</label>
            <p><?php echo $farmer['farmer_state']; ?></p>
            <input type="text" name="farmer_state" value="<?php echo $farmer['farmer_state']; ?>">
          </div>

          <div class="col-md-6 detail-item">
            <label><i class="bi bi-house"></i> Address</label>
            <p><?php echo $farmer['farmer_address']; ?></p>
            <input type="text" name="farmer_address" value="<?php echo $farmer['farmer_address']; ?>">
          </div>
        </div>
      </form>

      <div class="card-footer">
        <button id="editBtn" class="btn btn-outline-success btn-sm">
          <i class="bi bi-pencil-square"></i> Update Profile
        </button>
      </div>
    </div>
  </div>

  <script src="../assets/bootstrap/js/bootstrap.bundle.js"></script>

  <!-- <script>
    const editBtn = document.getElementById("editBtn");
    const saveBtn = document.getElementById("saveBtn");
    const cancelBtn = document.getElementById("cancelBtn");
    const inputs = document.querySelectorAll("#farmerForm input");
    const paragraphs = document.querySelectorAll("#farmerForm p");

    editBtn.addEventListener("click", (e) => {
      e.preventDefault();
      editBtn.style.display = "none";
      saveBtn.style.display = "inline-block";
      cancelBtn.style.display = "inline-block";
      inputs.forEach((input, i) => {
        input.style.display = "block";
        paragraphs[i].style.display = "none";
      });
    });

    cancelBtn.addEventListener("click", (e) => {
      e.preventDefault();
      editBtn.style.display = "inline-block";
      saveBtn.style.display = "none";
      cancelBtn.style.display = "none";
      inputs.forEach((input, i) => {
        input.style.display = "none";
        paragraphs[i].style.display = "block";
      });
    });

    saveBtn.addEventListener("click", (e) => {
      e.preventDefault();
      alert("✅ Changes saved successfully (AJAX logic can be added here).");
      editBtn.style.display = "inline-block";
      saveBtn.style.display = "none";
      cancelBtn.style.display = "none";
      inputs.forEach((input, i) => {
        paragraphs[i].innerText = input.value;
        input.style.display = "none";
        paragraphs[i].style.display = "block";
      });
    });
  </script> -->
</body>
</html>
