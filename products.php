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
  $products = $f->fetch_products();
  // echo "<pre>";
  //   print_r($products);
  // echo "</pre>";
  $cats = $c->fetch_all_categories();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="assets/images/logo.png" />
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
      
      .admin-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 30px;
      }

      .admin-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
        width: 100%;
        max-width: 950px; 
        padding: 2.5rem;
        animation: fadeIn 0.5s ease-in-out;
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
        font-weight: 600;
        color: #1fa97a;
        margin-bottom: 1.5rem;
        text-align: center;
      }

      .form-label {
        font-weight: 500;
        color: #333;
      }

      @media (min-width: 992px){
        .hero {
          display: flex;
          align-items: center;
          justify-content: space-between;
          padding: 2rem 2.25rem;
        }
      }
      <?php require_once("assets/style.php"); ?>
    </style>
  </head>
  <body class="container con">
    <?php require_once("outhead.php"); ?>

    <?php 
      if(isset($_SESSION["farmer_online"])){ 
    ?> 
      <div class="admin-wrapper py-5 my-5">
        <div class="admin-card">
          <h2>Add New Product</h2>

          <form action="process/process_add_product.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <?php require_once("common/alert.php"); ?>
              <input type="text" id="name" name="name" class="form-control mb-3" placeholder="Product Name" required/>

              <select name="category" id="category" class="form-select mb-3">
                <option value="">Select Category</option>
                <?php foreach($cats as $cat){ ?>
                  <option value="<?php echo $cat["category_id"]; ?>">
                    <?php echo $cat["category_name"]; ?>
                  </option>
                <?php  } ?>
              </select>

              <input type="text" name="desc" id="desc" class="form-control mb-3" placeholder="Product Description" required />
              <input type="text" name="unit" id="unit" class="form-control mb-3" placeholder="Product Unit e.g per bag, per kg, per crate, per bunch" required />
              <input type="number" name="price" id="price" class="form-control mb-3" placeholder="Product Price" required />
              <input type="number" name="qtyavail" id="qtyavail" class="form-control mb-3" placeholder="Product Quantity Available" required />
              <input type="file" name="file" id="file" class="form-control mb-3" placeholder="Choose an image for your product" />
            </div>

            <div class="d-grid">
              <button class="btn btn-success btn-lg mb-3" name="add">
                + Add Product
              </button>
            </div>
          </form>
        </div>
      </div>
    <?php 
      } 
    ?>

    <section class="products py-5 my-5 mx-auto" style="max-width:1200px;">
      <div class="row g-4">
        <?php 
          foreach($products as $product){ 
            $image = $product["product_image"];
            $t1 =  $product["product_name"];
            $t2 = $product["product_quantityavailable"]; 
            $t3 = $product["product_unit"];
            $title = $t1." - ".$t2.$t3;
            $price = number_format($product["product_price"]);
            $fname = $product["farmer_fullname"];
              $name = explode(" ", $fname);
              $show = end($name);
            $state = $product["state_name"];
        ?>  
          <div class="col-6 col-sm-6 col-md-4 col-lg-3">
            <div class="card product-card">
              <img src="uploads/<?php echo $image ?>" class="card-img-top" alt="Tomatoes — 1 crate" />
              <div class="card-body">
                <h6 class="card-title mb-1"><?php echo $title ?></h6>
                <p class="mb-1 text-success fw-bold">&#8358; <?php echo $price ?></p>
                <p class="small-muted mb-2">From: <a href="pages/farmer_details.php" class="link-dark">Farmer <?php echo $show ?></a></p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="small-muted">In: <?php echo $state ?></div>
                  <a class="btn btn-outline-success btn-sm" href="pages/product_details.php">View</a>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </section>

     <?php require_once("common/footer.php"); ?>
    
    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
  </body>
</html>
