<?php 
  session_start();
  require_once("../classes/Farmer.php");
  require_once("../classes/Buyer.php");

  $f = new Farmer;
  $b = new Buyer;

  $farmer = isset($_SESSION["farmer_online"]) ? $f->get_farmer_details($_SESSION["farmer_online"]) : [];
  $buyer = isset($_SESSION["buyer_online"]) ? $b->get_buyer_details($_SESSION["buyer_online"]) : [];

  $states = $f->fetch_all_states(); 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../assets/images/logo.png" />
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/fontawesome/css/all.css" />
    <link rel="stylesheet" href="../assets/animate.min.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <title>AgriLink - Farmers to Consumers</title>

    <style>
      :root{
        --brand: #1fa97a;
        --hero-height: 220px;
      }

      html,
      body{
        height:100%;
      }
      body {
        background: linear-gradient(90deg, #eef9f0 0%, #e8f5e9 100%);
        font-family: "Poppins", system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
        padding-top: 76px;
      }

      <?php require_once("../assets/style.php"); ?>

      .hero {
        background: linear-gradient(180deg, rgba(255,255,255,0.85), rgba(255,255,255,0.80));
        border-radius: 14px;
        padding: 1.5rem;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
      }

      .hero .lead {
        color: rgba(0,0,0,0.7);
      }

      .search-row {
        gap: .75rem;
      }

      .state-select {
        min-width: 180px;
      }

      .btn-ghost {
        background: transparent;
        border: 1px solid rgba(0,0,0,0.06);
      }
    </style>
  </head>

  <body>
    <?php require_once("../common/header.php"); ?>
    <main class="container">
      <section class="hero mb-4">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3 w-100">
          <div class="flex-grow-1">
            <h1 class="h4 mb-1" style="color:var(--brand);">Find farmers & produce near you</h1>
            <p class="lead small mb-2">Search by farmer name, produce, or filter by state and LGA.</p>

            <form class="row g-2 align-items-center search-row" method="get" action="" role="search" aria-label="Search farmers or produce">
              <div class="col-12 col-md">
                <label for="search">Search</label>
                <input id="search" name="search" type="search" class="form-control form-control-lg" placeholder="e.g. Tomato, Rice, Farmer Samuel" />
              </div>

              <div class="col-6 col-md-auto">
                <label for="state">State</label>
                <select id="delvstate" name="delvstate" class="form-select state-select" aria-label="Filter by state">
                  <option value="">All State</option>
                    <?php 
                      foreach($states as $state){ 
                    ?>
                      <option value="<?php echo $state['state_id'] ?>">
                        <?php echo $state['state_name'] ?>
                      </option>
                    <?php 
                      }; 
                    ?>
                </select>
              </div>

              <div class="col-6 col-md-auto">
                <label for="lga">LGA</label>
                <select id="delvlga" name="delvlga" class="form-select state-select" aria-label="Filter by local government">
                </select>
              </div>

              <div class="col-md-12 d-grid">
                <button class="btn btn-success" name="btnsearch" type="submit">Search</button>
              </div>

              <div class="col-md-12">
                <small class="text-muted">choose a state to narrow results — the LGA list updates automatically.</small>
              </div>
            </form>
          </div>

          <?php if(!isset($_SESSION["farmer_online"]) && !isset($_SESSION["buyer_online"])){ ?> 
            <div class="d-none d-md-flex">
              <a href="sign_farmer.php" class="btn btn-outline-success">Register as Farmer</a>
            </div>
          <?php } ?>
        </div>
      </section>

      <section>
        <div class="row g-3">
          <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
              <h2 class="h6 mb-0 text-muted">Featured farmers</h2>
              <small class="text-muted">Showing top picks</small>
            </div>
          </div>

          <div class="col-12 col-md-6 col-lg-4">
            <article class="card h-100 shadow-sm border-0">
              <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center gap-3 mb-3">
                  <div style="width:56px;height:56px;border-radius:10px;background:#f3fbf7;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--brand);">
                    F
                  </div>
                  <div>
                    <div class="fw-semibold">Farmer Ade</div>
                    <div class="small text-muted">Tomatoes . Lagos, Ikeja</div>
                  </div>
                </div>

                <p class="small text-muted mb-3">Supplying fresh tomatoes and assorted vegetables directly from farm to your kitchen.</p>

                <div class="mt-auto d-flex justify-content-between align-items-center">
                  <div>
                    <span class="badge bg-success">Available</span>
                    <small class="text-muted d-block">Delivery: 2-3 days</small>
                  </div>
                  <div>
                    <a class="btn btn-sm btn-outline-secondary" href="">View profile</a>
                    <a class="btn btn-sm btn-success ms-2" href="">Order</a>
                  </div>
                </div>
              </div>
            </article>
          </div>
        </div>
      </section>
    </main>
    
      <?php //require_once("assets/common/footer.php") ?>

    <script src="../assets/bootstrap/js/bootstrap.bundle.js"></script>
    <script>
      $(document).ready(function(){
        $("#delvstate").change(function(){
        var state_id = $(this).val();
          $("#delvlga").load("../process/process_state_lga.php?id="+state_id);
        })
      })
    </script>
  </body>
</html>
