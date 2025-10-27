<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="assets/images/logo.png" />
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/animate.min.css" />
    <title>AgriLink - Farmers to Consumers</title>
    <style>
      body {
        background: linear-gradient(to left, #e8f5e9, #c8e6c9);
        font-family: "poppins", monospace;
      }
      <?php include("assets/style.php"); ?>
      .con {
        margin-top: 12%;
      }
    </style>
  </head>
  <body class="container">
    <?php require_once("assets/common/header.php"); ?>
    
    <section class="con">
      <div class="row">
        <div class="col">
          <h2 class="text-center">Who are you looking for?</h2>
        </div>
      </div>
      <div class="row d-flex justify-content-center">
        <div class="col-md-2">
          <div class="dropdown">
            <button
              class="btn btn-success dropdown-toggle"
              type="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              All Nigeria
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item">Action</a></li>
              <li><a class="dropdown-item"></a></li>
              <li><a class="dropdown-item"></a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-5">
          <form
            class="d-flex collapse navbar-collapse"
            id="navbarNavDropdown"
            role="search"
          >
            <input
              class="form-control me-2"
              type="search"
              placeholder="I am looking for?"
              aria-label="Search"
            />
            <button class="btn btn-outline-success" type="submit">
              Search
            </button>
          </form>
        </div>
      </div>
    </section>

    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
  </body>
</html>
