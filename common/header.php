<?php
require_once '../classes/Buyer.php';
require_once '../classes/Cart.php';
require_once '../classes/Farmer.php';
require_once '../classes/Logistics.php';

$b = new Buyer;
$c = new Cart;
$f = new Farmer;
$l = new Logistics;

$buyer = isset($_SESSION['buyer_online']) ? $b->get_buyer_details($_SESSION['buyer_online']) : [];
$farmer = isset($_SESSION['farmer_online']) ? $f->get_farmer_details($_SESSION['farmer_online']) : [];
$logistic = isset($_SESSION['logistic_online']) ? $l->get_logistics_details($_SESSION['logistic_online']) : [];

$cart_count = isset($_SESSION['buyer_online']) ? $c->count_buyer_cart($_SESSION['buyer_online']) : 0;

if (! isset($logistic)) {
    $_SESSION['errormsg'] = 'You have to be logged in first';
    header('location: logistics_login.php');
    exit;
}
?>

<nav class="navbar bar fixed-top navbar-expand-md mb-5 glass-navbar">
  <div class="container-fluid">

    <a class="navbar-brand d-flex align-items-center" href="../index.php">
      <div class="ms-2 d-none d-md-block">
        <img width="52" height="40" src="../assets/images/logo.png" alt=""/>
        <div style="font-weight:800; color:#1fa97a;">AgriLink</div>
      </div>
    </a>

    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      
      <ul class="navbar-nav mx-auto gap-4">
        <li class="nav-item"><a class="bar-link active" href="../index.php">Home</a></li>
        <li class="nav-item"><a class="bar-link" href="../farmers/farmers.php">Farmers</a></li>
        <li class="nav-item"><a class="bar-link" href="../products.php">Products</a></li>
        <li class="nav-item"><a class="bar-link" href="../logistics.php">Logistics</a></li>
        <li class="nav-item"><a class="bar-link" href="../admin/ad_login.php">Admin</a></li>
        <li class="nav-item"><a class="bar-link" href="../contact.php">Contact</a></li>
      </ul>

      <div class="d-flex gap-2">


        <?php if (isset($farmer['farmer_fullname'])) {
            $split = explode(' ', $farmer['farmer_fullname']);
            $show = end($split);
            ?>
          <div class="dropdown">
            <a href="../profile.php" class="btn btn-light text-success d-flex align-items-center gap-1 dropdown-toggle" data-bs-toggle="dropdown">
              <i class="fas fa-user"></i> Farmer <?php echo $show; ?>
            </a>
            <ul class="dropdown-menu">
              <a href="../profile.php" class="dropdown-item"><i class="fas fa-user"></i> Profile</a>
              <a href="../process/process_logout.php" class="dropdown-item text-danger"><i class="fas fa-power-off"></i> Logout</a>
            </ul>
          </div>

        <?php } elseif (isset($logistic['name'])) { ?>
          <div class="dropdown">
            <a href="../profile.php" class="btn btn-light text-success d-flex align-items-center gap-1 dropdown-toggle" data-bs-toggle="dropdown">
              <i class="fas fa-user"></i> <?php echo $logistic['name']; ?> (Logistics)
            </a>
            <ul class="dropdown-menu">
              <a href="../profile.php" class="dropdown-item"><i class="fas fa-user"></i> Profile</a>
              <a href="../process/process_logout.php" class="dropdown-item text-danger"><i class="fas fa-power-off"></i> Logout</a>
            </ul>
          </div>

        <?php } elseif (isset($buyer['buyer_fullname'])) { ?>
          <div class="dropdown">
            <a href="../profile.php" class="btn btn-light text-success d-flex align-items-center dropdown-toggle gap-1" data-bs-toggle="dropdown">
              <i class="fas fa-user"></i> <?php echo $buyer['buyer_fullname']; ?>
            </a>
            <ul class="dropdown-menu">
              <a href="../process/process_logout.php" class="dropdown-item text-danger"><i class="fas fa-power-off"></i> Logout</a>
            </ul>
          </div>

          <a href="../cart.php" class="position-relative mt-2">
            <i class="fas fa-cart-plus text-success fs-5"></i>
            <?php if ($cart_count > 0) { ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-success">
                <?php echo $cart_count; ?>
              </span>
            <?php } ?>
          </a>

        <?php } else { ?>
          <div class="dropdown">
            <button class="btn btn-success dropdown-toggle m-md-3" data-bs-toggle="dropdown">Register</button>
            <ul class="dropdown-menu">
              <li><a href="../farmers/sign_farmer.php" class="dropdown-item">As a Farmer</a></li>
              <li><a href="../buyers/sign_buyer.php" class="dropdown-item">As a Buyer</a></li>
              <li><a href="../logistics/sign_logistics.php" class="dropdown-item">As Logistics</a></li>
            </ul>
          </div>

          <div class="dropdown">
            <button class="btn btn-success dropdown-toggle m-md-3" data-bs-toggle="dropdown">Login</button>
            <ul class="dropdown-menu">
              <li><a href="../farmers/login_farmer.php" class="dropdown-item">As a Farmer</a></li>
              <li><a href="../buyers/login_buyer.php" class="dropdown-item">As a Buyer</a></li>
              <li><a href="../logistics/login_logistics.php" class="dropdown-item">As Logistics</a></li>
            </ul>
          </div>

        <?php } ?>
      </div>

    </div>
  </div>
</nav>
