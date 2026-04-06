<?php
session_start();
require_once("classes/Farmer.php");
require_once("classes/Buyer.php");
require_once 'config/constants.php';

$f = new Farmer();
$b = new Buyer();

$farmer = isset($_SESSION["farmer_online"]) ? $f->get_farmer_details($_SESSION["farmer_online"]) : [];
$buyer  = isset($_SESSION["buyer_online"]) ? $b->get_buyer_details($_SESSION["buyer_online"]) : [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="<?= BASE_URL ?>assets/images/logo.png" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/animate.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/fontawesome/css/all.css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <title>Contact Us - AgriLink</title>

    <style>
        :root {
            --brand: #1fa97a;
            --brand-dark: #0f5132;
        }

        body {
            font-family: 'Poppins', system-ui, sans-serif;
            background: linear-gradient(135deg, #f8faf9 0%, #e8f5e9 100%);
            min-height: 100vh;
            padding-top: 90px;
        }

        .contact-hero {
            background: linear-gradient(rgba(15, 81, 50, 0.85), rgba(31, 169, 122, 0.85)),
                url('assets/images/contact-bg.jpg') center/cover no-repeat;
            color: white;
            padding: 4rem 0 3.5rem;
            text-align: center;
            margin-bottom: 3rem;
        }

        .contact-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(15, 81, 50, 0.10);
            overflow: hidden;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            border: 1.5px solid #e0e7e0;
            padding: 0.85rem 1.1rem;
        }

        .form-control:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(31, 169, 122, 0.15);
        }

        .btn-send {
            background: var(--brand);
            border: none;
            font-weight: 600;
            padding: 0.95rem 2rem;
            border-radius: 12px;
            font-size: 1.1rem;
        }

        .btn-send:hover {
            background: #1a8f66;
            transform: translateY(-2px);
        }

        .info-box {
            background: #f8faf9;
            border-radius: 16px;
            padding: 2rem;
            height: 100%;
        }

        .map-placeholder {
            background: linear-gradient(135deg, #e9ecef, #dee2e6);
            height: 260px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 1.1rem;
            border: 2px dashed #ced4da;
        }
    </style>
</head>

<body>

    <?php require_once ROOT_PATH . "outhead.php"; ?>

    <section class="contact-hero">
        <div class="container">
            <h1 class="display-5 fw-bold mb-3" style="font-family: 'Playfair Display', serif;">
                Get in Touch
            </h1>
            <p class="lead opacity-90">
                We're here to help. Reach out to us anytime.
            </p>
        </div>
    </section>

    <div class="container pb-5">
        <div class="contact-card">
            <div class="row g-0">
                <div class="col-lg-7">
                    <div class="p-4 p-lg-5">
                        <h3 class="mb-4 text-success">Send us a Message</h3>
                        <p class="text-muted mb-4">
                            Have a question or feedback? We'll respond within 48 hours.
                        </p>

                        <?php require_once ROOT_PATH . "common/alert.php"; ?>

                        <form action="<?= BASE_URL ?>process/process_contact.php" method="post">
                            <div class="mb-4">
                                <label class="form-label fw-medium">Full Name</label>
                                <input type="text" name="fullname" class="form-control" placeholder="Your full name" required />
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="your@email.com" required />
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">Message</label>
                                <textarea name="message" class="form-control" rows="6"
                                    placeholder="How can we help you today?" required></textarea>
                            </div>

                            <button type="submit" name="btn" class="btn btn-send btn-success w-100">
                                <i class="fas fa-paper-plane me-2"></i> Send Message
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5 bg-light">
                    <div class="info-box h-100 p-4 p-lg-5">
                        <h4 class="text-success mb-4">Our Office</h4>

                        <div class="mb-4">
                            <strong class="d-block mb-1">Address</strong>
                            <p class="text-muted mb-0">
                                Ikeja, Lagos<br>
                                Nigeria
                            </p>
                        </div>

                        <div class="mb-4">
                            <strong class="d-block mb-1">Support</strong>
                            <p class="mb-1">
                                <a href="mailto:support@agrilink.com" class="text-success text-decoration-none">
                                    support@agrilink.com
                                </a>
                            </p>
                            <p class="mb-0">
                                <a href="tel:+2347042972024" class="text-success text-decoration-none">
                                    +234 704 297 2024
                                </a>
                            </p>
                        </div>

                        <div class="mt-auto">
                            <strong class="d-block mb-2">Find Us</strong>
                            <div class="map-placeholder">
                                <div class="text-center">
                                    <i class="fas fa-map-marker-alt fa-3x mb-3 text-muted"></i>
                                    <p class="mb-0 fw-medium">Interactive Map Coming Soon</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>