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
    <title>AgriLink - Farmers to Consumers</title>
    <style>
      body {
        background: linear-gradient(to left, #e8f5e9, #c8e6c9);
        font-family: "Poppins", system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
      }
      <?php include("assets/style.php"); ?>
      .con {
        margin-top: 10%;
      }
    </style>
  </head>
  <body class="container">
    <?php require_once("assets/common/header.php"); ?>
    
    <div class="container con">
      <div class="row">
        <div class="col-md-6">
          <h2 class="text-success">Contact us</h2>
          <p class="small text-muted">
            Have a question? Send a message and we'll get back to you within
            48 hours.
          </p>

          <form action="process/process_contact.php" method="post">
            <div class="mb-3">
              <input name="fullname" class="form-control" placeholder="Fullname" required />
            </div>
            <div class="mb-3">
              <input name="email" class="form-control" type="email" placeholder="Email" required />
            </div>
            <div class="mb-3">
              <textarea name="message" class="form-control" rows="5" placeholder="Message" required></textarea>
            </div>
            <button class="btn btn-success" name="btn">Send message</button>
          </form>
        </div>

        <div class="col-md-6">
          <h6>Office</h6>
          <p class="small text-muted">Lagos . Nigeria</p>
          <h6>Support</h6>
          <p class="small text-muted">
            support@agrilink.com . +234 704 297 2024
          </p>

          <div class="mt-3">
            <div
              style="
                background: #e9ecef;
                height: 220px;
                display: flex;
                align-items: center;
                justify-content: center;
              "
              class="rounded"
            >
              Map placeholder
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
  </body>
</html>
