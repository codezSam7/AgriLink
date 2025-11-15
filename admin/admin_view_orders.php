<?php
session_start();
require_once 'admin_guard.php';
require_once 'classes/Admin.php';

$a = new Admin;

if (isset($_SESSION['admin_online'])) {
    $admin = $a->get_admin_details($_SESSION['admin_online']);
} else {
    header('Location: login.php');
    exit();
}

$orders = $a->fetch_orders();
$providers = $a->fetch_logistics_providers();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Products | AgriLink</title>
    <link rel="icon" href="../assets/images/logo.png" />
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/fontawesome/css/all.css" />
    <link rel="stylesheet" href="../assets/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root{
        --brand-green: #1fa97a;
        --card-bg: #ffffff;
        --soft-bg: #f5fff7;
        --brand-green: #1fa97a;
        --light-green: rgba(31,169,122,0.08);
        }

        body{
            font-family: "Poppins", sans-serif;
            background: linear-gradient(180deg, #f3fff8 0%, #e8f5e9 100%);
            margin: 0;
            padding: 0;
        }

        /* Sidebar */
        .admin-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 260px;
        background: linear-gradient(180deg,#f3fff8 0%, #e6fff2 100%);
        box-shadow: 4px 0 20px rgba(0,0,0,0.05);
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

        .btn-green {
            background-color: var(--brand-green); 
            border:none; 
            border-radius:12px;
            padding:0.65rem; 
            font-weight:600; 
            transition: all 0.3s ease;
        }
        .btn-green:hover { 
            background-color:#188e66; 
            transform:translateY(-2px); 
        }
        .logout-btn { 
            width:100%; 
            margin-top:2rem; 
        }
        .logout-btn a { 
            text-decoration:none; 
            color: #fff; 
            display:block; 
            text-align:center; 
            font-weight:600; 
        }


        /* Main content */
        .admin-wrapper {
        margin-left: 280px;
        padding: 2rem;
        display: flex;
        flex-direction: column;
        gap: 2rem;
        }

        .page-title {
            font-weight: 600;
            color: var(--brand-green);
        }

        /* Product cards */
        .products-grid{
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(230px,1fr));
        gap: 1.5rem;
        }

        .product-card{
        background: var(--card-bg);
        border-radius: 14px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product-card:hover{
        transform: translateY(-4px);
        box-shadow: 0 8px 28px rgba(0,0,0,0.12);
        }

        .product-card img{
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
        object-fit: cover;
        height: 160px;
        width: 100%;
        }

        .product-card .card-body{
        padding: 1rem;
        }

        .product-card h6{
        font-weight: 500;
        margin-bottom: 0.5rem;
        }

        .product-card p{
        margin-bottom: 0.25rem;
        font-size: 0.875rem;
        }

        .product-card .btn{
        font-size: 0.85rem;
        padding: 0.35rem 0.5rem;
        }

        .product-card .admin-actions{
        display: flex;
        gap: 0.5rem;
        margin-top: 0.5rem;
        }

        @media(max-width:768px){
        .admin-wrapper{
            margin-left: 0;
            padding: 1rem;
        }
        .admin-sidebar {
            position: relative;
            width: 100%;
            height: auto;
            flex-direction: row;
            justify-content: space-around;
            }
        .products-grid{ grid-template-columns: repeat(auto-fill,minmax(180px,1fr)); }
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
                <a class="nav-link" href="admin_view_users.php">
                <i class="fas fa-users"></i> Manage Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_view_orders.php">
                <i class="fas fa-shopping-cart"></i> Manage Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_view_category.php">
                <i class="fas fa-layer-group"></i> Manage Categories</a>
            </li>
        </ul>
            <button class="btn btn-green logout-btn">
                <a href="process/process_logout_admin.php"> Logout</a>
            </button>
        </div>
    </aside>

    <div class="admin-wrapper">
    <h3 class="page-title">Manage Orders</h3>

    <div class="row g-3">

        <?php foreach ($orders as $order) {

            // Extract
            $order_id = $order['order_id'];
            $price = number_format($order['order_totalamt'], 2);
            $buyer = $order['buyer_fullname'];
            $status = $order['pay_status'];
            $date = date('M j, Y', strtotime($order['order_date']));
            $delivery_status = $order['delivery_status'];

            // Status badge color
            switch ($status) {
                case 'pending':
                    $badge = 'bg-warning text-dark';
                    break;
                case 'rejected':
                    $badge = 'bg-danger';
                    break;
                case 'paid':
                    $badge = 'bg-success';
                    break;
                default:
                    $badge = 'bg-secondary';
            }

            ?>
<div class="col-12 col-md-6 col-lg-4">
  <div class="card order-card h-100 shadow-sm" style="border-radius: 14px;">
    <div class="card-body d-flex flex-column">
      <div class="d-flex justify-content-between align-items-start mb-2">
        <div>
          <div class="order-hero fw-semibold">#<?php echo $order_id; ?></div>
          <div class="small text-muted">
            Buyer: <?php echo $buyer; ?>
          </div>
        </div>

        <div class="text-end">
          <div><strong>&#8358;<?php echo $price; ?></strong></div>
        </div>
      </div>

      <div class="mt-auto">
        <span class="badge <?php echo $badge; ?>"><?php echo $status; ?></span>
        <small class="d-block text-muted">Placed on <?php echo $date; ?></small>
        <small class="d-block text-muted">Delivery: <?php echo $delivery_status; ?></small>
      </div>

        <form method="POST" action="process/process_update_order_status.php" class="mt-3">
          <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">

          <div class="input-group input-group-sm">
            <select name="status" class="form-select">
                <option value="pending" <?php if ($status == 'pending') {
                    echo 'selected';
                } ?>>Pending</option>
                <option value="rejected" <?php if ($status == 'rejected') {
                    echo 'selected';
                } ?>>Rejected</option>
                <option value="paid" <?php if ($status == 'paid') {
                    echo 'selected';
                } ?>>Paid</option>
            </select>
            <button class="btn btn-success" type="submit">Update</button>
          </div>
        </form>

      <!-- Assign Logistics Form -->
        <form method="POST" action="process/process_assign_logistics.php" class="mt-2">
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">

            <div class="input-group input-group-sm">
                <select name="logistics_id" class="form-select">
                    <option value="">Select Rider</option>
                    <?php foreach ($providers as $provider) { ?>
                        <option value="<?php echo $provider['logistics_id']; ?>"
                            <?php if ($order['logistics_id'] == $provider['logistics_id']) {
                                echo 'selected';
                            } ?>>
                            <?php echo $provider['name']; ?>
                        </option>
                    <?php } ?>
                </select>
                <button class="btn btn-primary" type="submit">Assign</button>
            </div>
        </form>
    </div>
  </div>
</div>
<?php } ?>


    </div>
</div>


    

    <script src="../assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>
