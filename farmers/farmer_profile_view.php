<?php
session_start();
require_once '../classes/Farmer.php';

$f = new Farmer;
$farmer = isset($_SESSION['farmer_online']) ? $f->get_farmer_details($_SESSION['farmer_online']) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../assets/animate.min.css" />
  <link rel="stylesheet" href="../assets/fontawesome/css/all.css" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <title>AgriLink - Farmer Details</title>

  <style>
    body {
      background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
      font-family: "Poppins", system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }

    <?php require_once '../assets/style.php'; ?>
  </style>
</head>
<body>

  <?php require_once '../common/header.php'; ?>


  <script src="../assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>
