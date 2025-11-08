<?php
session_start();
require_once '../classes/Farmer.php';
require_once 'admin_guard.php';
require_once 'classes/Admin.php';

$a = new Admin;
$f = new Farmer;

// Ensure admin is logged in
if (isset($_SESSION['admin_online'])) {
    $admin = $a->get_admin_details($_SESSION['admin_online']);
} else {
    header('Location: login.php');
    exit();
}
$farmers = $f->get_all_farmers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Farmers | AgriLink Admin</title>
  <link rel="icon" href="../assets/images/logo.png" />
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../assets/fontawesome/css/all.css" />
  <link rel="stylesheet" href="../assets/animate.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
  <style>
    :root {
      --brand-green: #1fa97a;
      --card-bg: #fff;
    }

    body {
      background: #f8f9fa;
      font-family: "Poppins", sans-serif;
      padding-top: 80px;
    }

    .page-title {
      font-weight: 600;
      color: var(--brand-green);
      margin-bottom: 1.5rem;
    }

    .farmer-card {
      background: var(--card-bg);
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      overflow: hidden;
      transition: 0.3s ease;
    }

    .farmer-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 28px rgba(0,0,0,0.1);
    }

    .farmer-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .farmer-info {
      padding: 1rem 1.2rem;
    }

    .farmer-info h6 {
      font-weight: 600;
      color: #1a1a1a;
    }

    .farmer-info small {
      color: #6c757d;
    }

    .btn-view {
      background: var(--brand-green);
      color: #fff;
      border: none;
      font-size: 0.9rem;
      border-radius: 8px;
      transition: 0.2s;
    }

    .btn-view:hover {
      background: #178e65;
    }

    .badge-status {
      font-size: 0.8rem;
      border-radius: 8px;
      padding: 0.35rem 0.6rem;
    }

    .search-bar {
      margin-bottom: 2rem;
      display: flex;
      align-items: center;
      gap: .5rem;
    }

    .search-bar input {
      border-radius: 10px;
      border: 1px solid #ccc;
      padding: .6rem 1rem;
      width: 250px;
    }

    @media(max-width: 768px){
      .farmer-card img {
        height: 140px;
      }
    }
  </style>
</head>
<body>
  <?php require_once 'admin_header.php'; ?>

  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
      <h3 class="page-title">Manage Farmers</h3>
      <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search farmer name...">
        <button class="btn btn-success" onclick="filterFarmers()">Search</button>
      </div>
    </div>

    <div class="row g-4" id="farmerContainer">
      <?php if (! empty($farmers)) { ?>
        <?php foreach ($farmers as $farmer) { ?>
          <div class="col-md-4 farmer-card-wrapper">
            <div class="farmer-card">
              <img src="../uploads/<?php echo $farmer['farmer_image'] ?? 'default_user.png'; ?>" alt="Farmer Image">
              <div class="farmer-info">
                <h6><?php echo htmlspecialchars($farmer['farmer_fullname']); ?></h6>
                <small><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($farmer['state_name']); ?></small>
                <div class="mt-2 d-flex justify-content-between align-items-center">
                  <?php if ($farmer['farmer_status'] == 'active') { ?>
                    <span class="badge bg-success badge-status">Active</span>
                  <?php } else { ?>
                    <span class="badge bg-danger badge-status">Inactive</span>
                  <?php } ?>
                  <a href="admin_farmer_details.php?id=<?php echo $farmer['farmer_id']; ?>" class="btn btn-view btn-sm">
                    <i class="fas fa-eye"></i> View
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      <?php } else { ?>
        <div class="text-center text-muted py-5">
          <i class="fas fa-user-slash fa-2x mb-3"></i>
          <p>No farmers found yet.</p>
        </div>
      <?php } ?>
    </div>
  </div>

  <script>
    function filterFarmers(){
      const input = document.getElementById("searchInput").value.toLowerCase();
      const farmers = document.querySelectorAll(".farmer-card-wrapper");
      farmers.forEach(card => {
        const name = card.querySelector("h6").textContent.toLowerCase();
        card.style.display = name.includes(input) ? "block" : "none";
      });
    }
  </script>

  <script src="../assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>
