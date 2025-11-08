<?php
  session_start();
  require_once("classes/Farmer.php");
  require_once("classes/Category.php");
  require_once("classes/Buyer.php");

  $f = new Farmer;
  $b = new Buyer;
  $c = new Category;

  $farmer = isset($_SESSION["farmer_online"]) ? $f->get_farmer_details($_SESSION["farmer_online"]) : [];
  $buyer = isset($_SESSION["buyer_online"]) ? $b->get_buyer_details($_SESSION["buyer_online"]) : [];

  if(!isset($_GET["id"])){
    header("location: index.php");
    exit;
  }

  $product_id = $_GET["id"];
  $product = $f->get_product_by_id($product_id);

  if(!$product){
    header("location: index.php");
    exit;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="assets/images/logo.png" />
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="assets/animate.min.css" />
  <link rel="stylesheet" href="assets/fontawesome/css/all.css" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <title><?php echo $product["product_name"]; ?> - AgriLink</title>
  <style>
    body {
      background: linear-gradient(to left, #e8f5e9, #c8e6c9);
      font-family: "Poppins", system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
      padding-top: 80px;
    }

    .product-detail-wrapper {
      max-width: 1100px;
      margin: 3rem auto;
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      animation: fadeIn 0.5s ease-in-out;
    }

    .product-detail-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 18px 0 0 18px;
    }

    .product-detail-content {
      padding: 2rem 2.5rem;
    }

    .product-title {
      font-size: 1.7rem;
      font-weight: 600;
      color: #1fa97a;
      margin-bottom: .8rem;
    }

    .product-desc {
      color: #333;
      font-size: 0.95rem;
      margin-bottom: 1.5rem;
      line-height: 1.6;
    }

    .price-tag {
      font-size: 1.5rem;
      color: #0c7a52;
      font-weight: 600;
    }

    .unit {
      color: #555;
      font-size: .9rem;
    }

    .farmer-info {
      margin-top: 1.5rem;
      border-top: 1px solid rgba(0,0,0,0.05);
      padding-top: 1rem;
      color: #333;
    }

    .farmer-info a {
      color: #1fa97a;
      text-decoration: none;
      font-weight: 500;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    <?php require_once("assets/style.php"); ?>
  </style>
</head>
<body>
  <?php require_once("outhead.php"); ?>

  <div class="container">
    <div class="product-detail-wrapper row g-0">
      <div class="col-md-5">
        <img src="uploads/<?php echo $product["product_image"]; ?>" alt="<?php echo $product["product_name"]; ?>" class="product-detail-img">
      </div>
      <div class="col-md-7">
        <div class="product-detail-content">
          <h2 class="product-title"><?php echo $product["product_name"]; ?></h2>

          <div class="price-tag mb-2">
            ₦<?php echo number_format($product["product_price"]); ?>
            <span class="unit">/ <?php echo $product["product_unit"]; ?></span>
          </div>

          <p class="product-desc">
            <?php echo nl2br($product["product_description"]); ?>
          </p>

          <p><strong>Available Quantity:</strong> <?php echo $product["product_quantityavailable"]; ?></p>

          <div class="farmer-info">
            <p>
              <i class="fas fa-user text-success"></i>
              Sold by: 
              <a href="farmers/farmer_details.php?id=<?php echo $product['product_farmer_id']; ?>">
                <?php echo $product["farmer_fullname"]; ?>
              </a>
            </p>
            <p><i class="fas fa-map-marker-alt text-success"></i> Located in: <?php echo $product["state_name"]; ?></p>
          </div>

          <div class="mt-4 d-flex gap-2">
            <?php if(isset($_SESSION["buyer_online"])): ?>
              <a href="process/process_addtocart.php?id=<?php echo $product["product_id"]; ?>" class="btn btn-success btn-lg">
                <i class="fas fa-cart-plus"></i> Add to Cart
              </a>
            <?php elseif(isset($_SESSION["farmer_online"])): ?>
              <a href="farmers/update_product.php?id=<?php echo $product['product_id']; ?>" class="btn btn-outline-success">
                <i class="bi bi-pencil-square"></i> Update Product
              </a>
            <?php else: ?>
              <a href="buyers/login_buyer.php" class="btn btn-outline-success btn-lg">
                <i class="fas fa-user"></i> Login to Purchase
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require_once("common/footer.php"); ?>
  <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>
