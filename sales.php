<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>My Sales</title>
    <style>
      body{
        background: linear-gradient(90deg,#f3faf3,#e8f5e9); 
        font-family: "Poppins", system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
      }
      .orders-grid{
        max-width:1200px; 
        margin:2.5rem auto;
      }
      .order-card{
        border:0; 
        border-radius:12px; 
        box-shadow: 0 6px 18px rgba(2,6,23,0.06);
      }
      .order-hero{
        font-weight:700;
      }
      .order-info small{
        color:#6b7280;
      }
      .order-actions a{
        margin-left:.35rem;
      }
      <?php require_once("assets/style.php"); ?>
    </style>
  </head>
  <body>
    <div class="container orders-grid">
      <?php require_once("assets/common/header.php"); ?>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <h2 class="text-success mb-0">My Sales</h2>
          <small class="text-muted">All goods bought & delivery status</small>
        </div>
        <div>
          <button class="btn btn-sm btn-outline-secondary">Filter</button>
          <button class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
      </div>

      <div class="row g-3">
        <!-- Repeat this col in a PHP loop -->
        <div class="col-12 col-md-6 col-lg-4">
          <div class="card order-card h-100">
            <div class="card-body d-flex flex-column">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                  <div class="order-hero">#1001 — Tomato</div>
                  <div class="small text-muted">1 crate - Mr Jimi</div>
                </div>
                <div class="text-end">
                  <div><strong>&#8358;10,000</strong></div>
                  <div class="small text-muted">Qty: 1</div>
                </div>
              </div>

              <div class="mb-3 mt-auto d-flex justify-content-between align-items-center">
                <div>
                  <span class="badge bg-warning text-dark">Pending</span>
                  <small class="d-block text-muted">Bought 3 days ago</small>
                </div>
                <div class="order-actions">
                  <a href="order_details.php?id=1001" class="btn btn-sm btn-outline-primary">Details</a>
                  <a href="#" class="btn btn-sm btn-outline-secondary">Chat</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
          <div class="card order-card h-100">
            <div class="card-body d-flex flex-column">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                  <div class="order-hero">#1002 — Rice</div>
                  <div class="small text-muted">50kg - Omosare</div>
                </div>
                <div class="text-end">
                  <div><strong>&#8358;45,000</strong></div>
                  <div class="small text-muted">Qty: 1</div>
                </div>
              </div>

              <div class="mb-3 mt-auto d-flex justify-content-between align-items-center">
                <div>
                  <span class="badge bg-success">Delivered</span>
                  <small class="d-block text-muted">Bought on 2025-10-10</small>
                </div>
                <div class="order-actions">
                  <a href="invoice.php?id=1002" class="btn btn-sm btn-outline-primary">Invoice</a>
                  <a href="#" class="btn btn-sm btn-outline-secondary">Rate</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /repeat -->
      </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>
