<?php
require_once 'classes/Admin.php';
require_once 'classes/Category.php';
require_once '../config/constants.php';

$a = new Admin;
$c = new Category;
$cats = $c->fetch_all_categories();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="<?= BASE_URL ?>assets/images/logo.png">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/fontawesome/css/all.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/animate.min.css">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <title>Admin - Categories</title>
  <style>
    :root {
      --brand-green: #1fa97a;
      --card-bg: #ffffff;
      --soft-bg: #f5fff7;
      --light-green: rgba(31, 169, 122, 0.08);
      --danger-red: #e57373;
    }

    body {
      background: linear-gradient(to left, #e8f5e9, #c8e6c9);
      font-family: 'Poppins', sans-serif;
    }

    .admin-sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 260px;
      background: linear-gradient(180deg, #f3fff8 0%, #e6fff2 100%);
      box-shadow: 4px 0 20px rgba(0, 0, 0, 0.05);
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 2rem 1.5rem;
    }

    .sidebar-content {
      width: 100%;
      text-align: center;
    }

    .brand-header {
      margin-bottom: 2rem;
    }

    .icon-circle {
      width: 52px;
      height: 52px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 14px;
      background: var(--light-green);
      color: var(--brand-green);
      margin-bottom: 0.6rem;
    }

    .brand {
      font-weight: 600;
      color: var(--brand-green);
    }

    .nav {
      padding-left: 0;
      width: 100%;
    }

    .nav-link {
      color: #0a3b2c;
      padding: 0.8rem 0;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.6rem;
      font-weight: 500;
      transition: all 0.2s ease-in-out;
    }

    .nav-link:hover {
      background: var(--light-green);
      color: var(--brand-green);
      transform: translateX(5px);
      text-decoration: none;
    }

    .nav-link.active {
      background: var(--brand-green);
      color: #fff !important;
    }

    .admin-wrapper {
      margin-left: 280px;
      padding: 50px 20px;
      min-height: 100vh;
      display: flex;
      justify-content: center;
    }

    .admin-card {
      background: var(--card-bg);
      border-radius: 20px;
      box-shadow: 0 10px 35px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 800px;
      padding: 3rem;
      animation: fadeIn 0.5s ease-in-out;
      transition: all 0.3s ease;
    }

    .admin-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 45px rgba(0, 0, 0, 0.15);
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    h2 {
      font-weight: 700;
      color: var(--brand-green);
      margin-bottom: 2rem;
      text-align: center;
    }

    .form-label {
      font-weight: 500;
      color: #333;
    }

    input.form-control {
      border-radius: 12px;
      border: 1px solid #d4d4d4;
      transition: all 0.3s ease;
    }

    input.form-control:focus {
      border-color: var(--brand-green);
      box-shadow: 0 0 8px var(--light-green);
    }

    .btn-green {
      background-color: var(--brand-green);
      border: none;
      border-radius: 12px;
      padding: 0.65rem;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-green:hover {
      background-color: #188e66;
      transform: translateY(-2px);
    }

    /* Table Styling */
    .table-responsive {
      background: #fff;
      border-radius: 15px;
      padding: 1rem;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    table {
      border: none;
      border-radius: 12px;
      overflow: hidden;
    }

    thead {
      background: var(--brand-green);
      color: #fff;
      font-weight: 600;
    }

    tbody tr {
      transition: all 0.2s ease;
    }

    tbody tr:hover {
      background: #f0fdf4;
      transform: translateX(3px);
    }

    .btn-outline-danger {
      border-radius: 8px;
      padding: 0.35rem 0.7rem;
      font-size: 0.85rem;
      transition: all 0.2s ease;
    }

    .btn-outline-danger:hover {
      background-color: var(--danger-red);
      color: #fff;
    }

    .badge-category {
      background: var(--light-green);
      color: var(--brand-green);
      font-weight: 600;
      padding: 0.5em 0.7em;
      border-radius: 12px;
    }

    @media(max-width:768px) {
      .admin-wrapper {
        margin-left: 0;
        padding: 20px;
        flex-direction: column;
      }
    }

    .logout-btn {
      width: 100%;
      margin-top: 2rem;
    }

    .logout-btn a {
      text-decoration: none;
      color: #fff;
      display: block;
      text-align: center;
      font-weight: 600;
    }
  </style>
</head>

<body>
  <aside class="admin-sidebar">
    <div class="sidebar-content">
      <div class="brand-header">
        <div class="icon-circle"><i class="fas fa-chart-line"></i></div>
        <div>
          <h6 class="brand mb-0">AgriLink Admin</h6>
          <small class="text-muted">Dashboard</small>
        </div>
      </div>

      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="admin.php">
            <i class="fas fa-home"></i> Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_manage_products.php">
            <i class="fas fa-box"></i> Manage Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_manage_users.php">
            <i class="fas fa-users"></i> Manage Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_manage_orders.php">
            <i class="fas fa-shopping-cart"></i> Manage Orders</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_manage_category.php">
            <i class="fas fa-layer-group"></i> Manage Categories</a>
        </li>
      </ul>
      <button class="btn btn-green logout-btn">
        <a href="process/process_logout_admin.php">Logout</a>
      </button>
    </div>
  </aside>

  <div class="admin-wrapper">
    <div class="admin-card">
      <h2>Add New Category</h2>

      <form action="process/process_category.php" method="post">
        <?php require_once ROOT_PATH . "common/alert.php"; ?>
        <div class="mb-4">
          <label for="cat_name" class="form-label">Category Name</label>
          <input type="text" id="cat_name" name="cat_name" class="form-control" placeholder="e.g. Vegetables, Grains, Fruits">
        </div>

        <div class="d-grid mb-4">
          <button class="btn btn-success btn-lg" name="add"><i class="fas fa-plus-circle"></i> Add Category</button>
        </div>
      </form>

      <hr class="my-4">

      <h5 class="text-center text-muted mb-3">Existing Categories</h5>
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>S/N</th>
              <th>Category Name</th>
              <th style="width:140px">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $sn = 0;
            foreach ($cats as $cat) {
              $sn++; ?>
              <tr>
                <td><?php echo $sn; ?></td>
                <td><span class="badge-category"><?php echo $cat['category_name']; ?></span></td>
                <td>
                  <a href="process/process_delete_category.php?cid=<?php echo $cat['category_id'] ?>" class="btn btn-outline-danger" title="Delete"><i class="fas fa-trash-alt"></i></a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>

  <script src="<?= BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>