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
    </style>
  </head>
  <body class="container">
    <?php require_once("assets/common/header.php"); ?>

     <?php if(file_exists("assets/common/footer.php")) {include("assets/common/footer.php");} ?>
    
    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
  </body>
</html>
