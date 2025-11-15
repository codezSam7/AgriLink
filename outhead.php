<?php
require_once 'classes/Buyer.php';
require_once 'classes/Cart.php';

$b = new Buyer;
$c = new Cart;

$buyer = isset($_SESSION['buyer_online']) ? $b->get_buyer_details($_SESSION['buyer_online']) : [];
$cart_count = 0;

if (isset($_SESSION['buyer_online'])) {
    $cart_count = $c->count_buyer_cart($_SESSION['buyer_online']);
}
?>


<nav class="navbar bar fixed-top navbar-expand-md mb-5 glass-navbar">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img width="56" height="56" src="assets/images/logo.png" alt=""/>
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
        <li class="nav-item"><a class="bar-link active" href="index.php">Home</a></li>
        <li class="nav-item"><a class="bar-link" href="farmers/farmers.php">Farmers</a></li>
        <li class="nav-item"><a class="bar-link" href="products.php">Products</a></li>
        <li class="nav-item"><a class="bar-link" href="admin/ad_login.php">Admin</a></li>
        <li class="nav-item"><a class="bar-link" href="contact.php">Contact</a></li>
      </ul>

      <div class="d-flex gap-2">
        <?php
  if (isset($farmer['farmer_fullname'])) {
      $fname = $farmer['farmer_fullname'];
      $name = explode(' ', $fname);
      $show = end($name);
      ?>
        
          <div class="dropdown">
            <a href="profile.php" class="btn btn-light text-success d-flex align-items-center gap-1 dropdown-toggle me-md-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user"></i> 
              <span>Farmer <?php echo $show ?></span>
            </a>
            <ul class="dropdown-menu">
              <a href="process/process_logout.php" class="btn btn-danger d-flex align-items-center gap-1 dropdown-item">
                <i class="fas fa-power-off"></i> 
                <span> Logout</span>
              </a>
              <a href="profile.php" class="btn btn-danger d-flex align-items-center gap-1 dropdown-item">
                <i class="fas fa-user"></i>
                <span> Profile</span>
              </a>
            </ul>
          </div>
        <?php
  } elseif (isset($buyer['buyer_fullname'])) {
      ?>
    
          <div class="dropdown">
            <a href="profile.php" class="btn btn-light text-success d-flex align-items-center gap-1 dropdown-toggle me-md-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user"></i> 
              <span><?php echo $buyer['buyer_fullname'] ?></span>
            </a>
            <ul class="dropdown-menu">
              <a href="process/process_logout.php" class="btn btn-danger d-flex align-items-center gap-1 dropdown-item">
                <i class="fas fa-power-off"></i> 
                <span>Logout</span>
              </a>
            </ul>
          </div>
          
          <?php if (isset($buyer['buyer_fullname'])) { ?>
            <a href="cart.php" class="position-relative mt-2">
              <i class="fas fa-cart-plus text-success fs-5"></i>
              <?php if ($cart_count > 0) { ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-success">
                  <?php echo $cart_count; ?>
                </span>
              <?php } ?>
            </a>
          <?php } ?>
          

        <?php
  } else {
      ?>

          <div class="dropdown">
            <button class="btn btn-success dropdown-toggle m-md-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Register
            </button>
            <ul class="dropdown-menu">
              <li><a href="farmers/sign_farmer.php" class="dropdown-item">As a farmer</a></li>
              <li><a href="buyers/sign_buyer.php" class="dropdown-item">As a buyer</a></li>
            </ul>
          </div>

          <div class="dropdown">
            <button class="btn btn-success dropdown-toggle m-md-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Login
            </button>
            <ul class="dropdown-menu">
              <li><a href="farmers/login_farmer.php" class="dropdown-item">As a farmer</a></li>
              <li><a href="buyers/login_buyer.php" class="dropdown-item">As a buyer</a></li>
            </ul>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</nav>






