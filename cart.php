<?php
session_start();
require_once 'classes/Buyer.php';
require_once 'classes/Cart.php';

$b = new Buyer;
$c = new Cart;

$buyer = isset($_SESSION['buyer_online']) ? $b->get_buyer_details($_SESSION['buyer_online']) : [];
$cart_items = isset($_SESSION['buyer_online']) ? $c->fetch_buyer_cart($_SESSION['buyer_online']) : [];
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>AgriLink - Your Cart</title>

    <style>
      body {
        font-family: "Poppins", system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
        background: linear-gradient(90deg,#e8f5e9 0%, #c8e6c9 100%);
        color: #1b4332;
        margin: 0;
      }

      .con {
        margin-top: 6%;
        margin-bottom: 5%;
      }

      .cart-item {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
        padding: 15px;
      }

      .cart-img {
        width: 120px;
        height: 120px;
        object-fit: contain;
        border: 1px solid #eee;
        border-radius: 8px;
      }

      .item-name {
        font-weight: 600;
        color: #1b4332;
      }

      .item-price {
        color: #2e7d32;
        font-weight: 500;
      }

      .subtotal {
        font-weight: 600;
        color: #388e3c;
      }

      .cart-summary {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      }

      .btn-checkout {
        background: #1fa97a;
        color: #fff;
        font-weight: 600;
        border: none;
        transition: 0.3s;
      }

      .btn-checkout:hover {
        background: #188f68;
        color: #fff;
      }

      <?php require_once 'assets/style.php'; ?>
    </style>
  </head>

  <body class="container con">
    <?php require_once 'outhead.php'; ?>

    <div class="row">
        <div class="col-md-10 offset-md-1">

            <?php if (! $cart_items || count($cart_items) === 0) { ?>
                <div class=" mt-2 alert alert-danger text-center fs-5">
                    Your cart is empty 😣
                </div>
            <?php } else { ?>
                <h3 class="fw-bold mb-4 my-5 text-success">My Shopping Cart</h3>

            <?php require_once 'common/alert.php'; ?>
            <?php
                $total = 0;
                foreach ($cart_items as $item) {
                    $pix = ! empty($item['product_image']) ? 'uploads/'.$item['product_image'] : 'assets/images/no-image.png';
                    $product = $item['product_name'];
                    $qty = $item['cart_qty'];
                    $price = $item['product_price'];
                    $subtotal = $qty * $price;
                    $total += $subtotal;
                    ?>
                <div class="cart-item d-flex align-items-center justify-content-between flex-wrap">
                    <div class="d-flex align-items-center">
                        <img src="<?php echo $pix ?>" alt="<?php echo $product ?>" class="cart-img me-3">
                        <div>
                            <h5 class="item-name mb-1"><?php echo $product ?></h5>
                            <p class="mb-1">Price: <span class="item-price">&#8358;<?php echo number_format($price, 2) ?></span></p>
                            <p class="mb-1">Qty: <?php echo $qty ?></p>
                            <p class="subtotal mb-0">Subtotal: &#8358;<?php echo number_format($subtotal, 2) ?></p>
                        </div>
                    </div>

                    <div class="text-end mt-3 mt-md-0">
                        <a href="process/remove_from_cart.php?cid=<?php echo $item['cid'] ?>" class="btn btn-outline-danger btn-sm me-2">
                            <i class="fas fa-trash"></i> Remove
                        </a>
                    </div>
                </div>
            <?php } ?>

            <!-- CART SUMMARY -->
            <div class="cart-summary mt-5">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold">Total:</h5>
                    <h4 class="fw-bold text-success">&#8358;<?php echo number_format($total, 2) ?></h4>
                </div>
                <div class="text-end mt-3">
                    <a href="checkout.php" class="btn btn-checkout btn-lg px-4">
                        Proceed to Checkout
                    </a>
                </div>
            </div>

            <a href="process/empty_cart.php" class="btn btn-danger btn-lg mt-3">Empty Cart</a>

            <?php } ?>
        </div>
    </div>

  </body>
</html>
