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
        <li class="nav-item">
          <a
            class="bar-link active"
            href="index.php"
            >Home</a
          >
        </li>
        <li class="nav-item">
          <a class="bar-link" href="farmers/farmers.php">Farmers</a>
        </li>
        <li class="nav-item">
          <a class="bar-link" href="products.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="bar-link" href="orders.php">Orders</a>
        </li>
        <li class="nav-item">
          <a class="bar-link" href="admin.php">Admin</a>
        </li>
        <li class="nav-item">
          <a class="bar-link" href="contact.php">Contact</a>
        </li>
      </ul>
    </div>
  </div>

  
    <div class="dropdown collapse navbar-collapse" id="navbarNavDropdown">
        <?php 
          if(!isset($_SESSION["farmer_online"])){ 
        ?>
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
          <a href="farmers/sign_farmer.php" class="dropdown-item"
            >As a farmer</a
          >
        </li>
        <li>
          <a href="buyers/sign_buyer.php" class="dropdown-item"
            >As a buyer</a
          >
        </li>
      </ul>
    </div>
    <div class="dropdown collapse navbar-collapse" id="navbarNavDropdown">
      <button
        class="btn button btn-success dropdown-toggle m-3"
        type="button"
        data-bs-toggle="dropdown"
        aria-expanded="false"
      >
        Login
      </button>
      <ul class="dropdown-menu">
        <li>
          <a href="farmers/login_farmer.php" class="dropdown-item">As a farmer</a>
        </li>
        <li>
          <a href="buyers/login_buyer.php" class="dropdown-item">As a buyer</a>
        </li>
      </ul>

      <?php 
        }else{
          $fname = $farmer["farmer_fullname"];
          $name = explode(" ", $fname);
          $show = end($name);
      ?>
        <a href="profile.php" class="btn btn-light text-success me-2">
          <i class="fas fa-user"></i> Farmer <?php echo $show ?>
        </a>
        <a href="process/process_logout.php" class="btn btn-danger"><i class="fas fa-power-off"></i> Logout</a>
      <?php
        }
      ?>
    </div>
  </div>
</nav>