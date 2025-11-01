<?php
  require_once("classes/Category.php");
  $c = new Category;
  $cats = $c->fetch_all_categories();
  // echo "<pre>";
  //   print_r($cats);
  // echo "</pre>";

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="assets/images/logo.png" />
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/animate.min.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/fontawesome/css/all.css" />
    <style>
      body {
        background: linear-gradient(to left, #e8f5e9, #c8e6c9);
        font-family: "Poppins", system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
      }

      <?php require_once("assets/style.php"); ?>

      .con {
        margin-top: 5%;
      }

      .admin-wrapper {
        min-height: 100vh;
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
        max-width: 700px;
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

      .btn-success {
        background-color: #1fa97a;
        border: none;
        transition: all 0.3s ease;
      }

      .btn-success:hover {
        background-color: #188e66;
        transform: translateY(-1px);
      }

      table {
        margin-top: 1.5rem;
      }

      .table thead {
        background-color: #e8f5e9;
      }
    </style>
  </head>
  <body>
    <?php require_once("outhead.php"); ?>
    
    <div class="admin-wrapper con">
      <div class="admin-card">
        <h2>Add New Category</h2>

        <form action="process/process_category.php" method="post">
          <div class="mb-3">
            <?php require_once("common/alert.php"); ?>
            <label for="cat_name" class="form-label">Category Name</label>
            <input
              type="text"
              id="cat_name"
              name="cat_name"
              class="form-control"
              placeholder="e.g. Vegetables, Grains, Fruits"
              required
            />
          </div>

          <div class="d-grid">
            <button class="btn btn-success btn-lg" name="add">
              + Add Category
            </button>
          </div>
        </form>

        <hr class="my-5" />

        <h5 class="mb-3 text-center text-muted">Existing Categories</h5>
        <div class="table-responsive">
          <table class="table table-bordered align-middle">
            <thead>
              <tr>
                <th>S/N</th>
                <th>Category Name</th>
                <th style="width: 140px">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $sn = 0;
                foreach($cats as $cat){ 
                $sn++;
              ?>  
                <tr>
                  <td><?php echo $sn; ?></td>
                  <td><?php echo $cat["category_name"]; ?></td>
                  <td>
                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                  </td>
                </tr>
              <?php 
                } 
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
  </body>
</html>
