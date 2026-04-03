<?php
session_start();
require_once 'classes/Buyer.php';
require_once 'classes/Cart.php';
require_once 'config/constants.php';

$b = new Buyer;
$c = new Cart;

$buyer = $b->get_buyer_details($_SESSION['buyer_online']);

if (isset($_SESSION['order_id'])) {
  $order_id = $_SESSION['order_id'];
} else {
  $_SESSION['errormsg'] = 'Please, checkout here';
  header('location:cart.php');
  exit;
}

$items_confirm = $b->fetch_order($order_id);
if (! $items_confirm) {
  $_SESSION['errormsg'] = 'Invalid action';
  header('location:cart.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AgriLink - Order Confirmation</title>
  <link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/fontawesome/css/all.css" />
  <style>
    :root {
      --accent: #0f5132;
      --accent-2: #1fa97a;
    }

    html,
    body {
      margin: 0;
      font-family: "Poppins", system-ui, Roboto, Arial;
    }

    body {
      background: linear-gradient(90deg, #e8f5e9 0%, #c8e6c9 100%);
      color: #1b4332;
    }

    .con {
      margin-top: 3%;
    }

    <?php require_once ROOT_PATH . 'assets/style.php' ?>
  </style>
</head>

<body>
  <?php require_once ROOT_PATH . 'outhead.php'; ?>

  <section class="products-hero con py-5 bg-success text-white">
    <div class="container text-center">
      <h1 class="display-5 fw-bold mb-2">Order Confirmation</h1>
      <p class="lead mb-0">Thank you for shopping with AgriLink!</p>
    </div>
  </section>

  <section class="py-5 bg-light">
    <div class="container">

      <!-- Alerts -->
      <div class="row justify-content-center mb-4">
        <div class="col-md-8">
          <?php require_once ROOT_PATH . 'common/alert.php'; ?>
        </div>
      </div>

      <!-- Order Summary Card -->
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
              <h5 class="mb-0"><i class="bi bi-bag-check-fill me-2"></i>Order Summary</h5>
              <small>Order ID: <strong>#<?php echo $order_id ?></strong></small>
            </div>
            <div class="card-body bg-white">
              <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                  <thead class="table-success text-success fw-semibold">
                    <tr>
                      <th>S/N</th>
                      <th>Product</th>
                      <th>Image</th>
                      <th>Quantity</th>
                      <th>Unit Price</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody class="table-light">
                    <?php
                    $total = 0;
                    $serial = 0;
                    foreach ($items_confirm as $item) {
                      $pix = ($item['product_image'] != '') ? 'uploads/' . $item['product_image'] : 'assets/images/noimage.png';
                      $product = $item['product_name'];
                      $qty = $item['detail_qty'];
                      $price = $item['product_price'];
                      $subtotal = $qty * $price;
                      $total += $subtotal;
                      $serial++;
                    ?>
                      <tr>
                        <td><?php echo $serial ?></td>
                        <td class="fw-semibold text-dark"><?php echo $product ?></td>
                        <td><img src="<?php echo $pix ?>" class="rounded shadow-sm" width="80" height="70" style="object-fit:cover;" alt="Product image"></td>
                        <td><?php echo $qty ?></td>
                        <td>&#8358;<?php echo number_format($price, 2) ?></td>
                        <td class="fw-semibold">&#8358;<?php echo number_format($subtotal, 2) ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <div class="mt-4 text-end">
                <h5 class="fw-bold text-success">Grand Total: &#8358;<?php echo number_format($total, 2) ?></h5>
              </div>
            </div>
            <div class="card-footer bg-light py-3 text-center">
              <a href="products.php" class="btn btn-outline-success btn-lg px-4 me-2">
                <i class="bi bi-arrow-left-circle"></i> Continue Shopping
              </a>
              <?php if ($items_confirm) { ?>
                <a href="paynow.php" class="btn btn-success btn-lg px-4 shadow-sm">
                  <i class="bi bi-credit-card-fill"></i> Proceed to Payment
                </a>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <?php require_once ROOT_PATH . 'common/footer.php'; ?>

  <script src="<?= BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.js"></script>
  <script src="<?= BASE_URL ?>assets/jquery.js"></script>
  <script>
    // dynamic LGA loading
    $(document).ready(function() {
      $("#state_select").change(function() {
        var state_id = $(this).val();
        $("#lga_select").load("process/process_shipping_lga.php?id=" + state_id);
      })
    })
  </script>
</body>

</html>