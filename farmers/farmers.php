<?php
session_start();
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../classes/Farmer.php';
require_once __DIR__ . '/../classes/Buyer.php';

$f = new Farmer();
$b = new Buyer();

$logged_farmer = isset($_SESSION['farmer_online']) ? $f->get_farmer_details($_SESSION['farmer_online']) : [];
$buyer         = isset($_SESSION['buyer_online']) ? $b->get_buyer_details($_SESSION['buyer_online']) : [];

$states = $f->fetch_all_states();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="<?= BASE_URL ?>assets/images/logo.png" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/fontawesome/css/all.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <title>AgriLink - Find Farmers & Fresh Produce</title>

    <style>
        :root {
            --brand: #1fa97a;
            --brand-dark: #0f5132;
        }

        body {
            font-family: 'Poppins', system-ui, sans-serif;
            background: linear-gradient(135deg, #f8faf9 0%, #eef9f0 100%);
            min-height: 100vh;
            padding-top: 90px;
            color: #1a2e1f;
        }

        .hero {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 35px rgba(15, 81, 50, 0.08);
            padding: 2rem 1.75rem;
            margin-bottom: 3rem;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.85rem;
            color: var(--brand-dark);
            margin-bottom: 0.5rem;
        }

        .search-row .form-control,
        .search-row .form-select {
            border-radius: 12px;
            border: 1.5px solid #e0e7e0;
            padding: 0.75rem 1rem;
            font-size: 1.02rem;
        }

        .search-row .form-control:focus,
        .search-row .form-select:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(31, 169, 122, 0.15);
        }

        .btn-search {
            background: var(--brand);
            border: none;
            font-weight: 600;
            padding: 0.85rem 2rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-search:hover {
            background: #1a8f66;
            transform: translateY(-2px);
        }

        .card-farmer {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            transition: all 0.35s ease;
            box-shadow: 0 8px 25px rgba(15, 81, 50, 0.07);
        }

        .card-farmer:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(15, 81, 50, 0.15);
        }

        .avatar {
            width: 62px;
            height: 62px;
            border-radius: 14px;
            background: #e8f5e9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--brand);
            border: 3px solid #fff;
            box-shadow: 0 4px 12px rgba(31, 169, 122, 0.2);
        }

        .section-header {
            font-size: 1.35rem;
            color: var(--brand-dark);
            margin-bottom: 1.25rem;
        }
    </style>
</head>

<body>

    <?php require_once ROOT_PATH . 'outhead.php'; ?>

    <main class="container py-4">
        <section class="hero animate__animated animate__fadeIn">
            <div class="d-flex flex-column flex-md-row align-items-md-center gap-4">
                <div class="flex-grow-1">
                    <h1>Find Farmers & Fresh Produce Near You</h1>
                    <p class="lead small text-muted mb-4">
                        Search by farmer name, produce type, or filter by state and LGA.
                    </p>

                    <form id="searchForm" class="row g-3 align-items-end search-row" method="get" action="">
                        <div class="col-12 col-lg-5">
                            <label for="search" class="form-label fw-medium small">What are you looking for?</label>
                            <input id="search" name="search" type="search"
                                class="form-control form-control-lg"
                                placeholder="e.g. Tomatoes, Rice, Farmer Ade..." />
                        </div>

                        <div class="col-6 col-lg-3">
                            <label for="delvstate" class="form-label fw-medium small">State</label>
                            <select id="delvstate" name="delvstate" class="form-select">
                                <option value="">All States</option>
                                <?php foreach ($states as $state): ?>
                                    <option value="<?= htmlspecialchars($state['state_id']) ?>">
                                        <?= htmlspecialchars($state['state_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-6 col-lg-3">
                            <label for="delvlga" class="form-label fw-medium small">LGA</label>
                            <select id="delvlga" name="delvlga" class="form-select">
                                <option value="">All LGAs</option>
                            </select>
                        </div>

                        <div class="col-12 col-lg-auto d-grid">
                            <button class="btn btn-search text-white" type="submit">
                                <i class="fas fa-search me-2"></i> Search
                            </button>
                        </div>
                    </form>
                </div>

                <?php if (!isset($_SESSION['farmer_online']) && !isset($_SESSION['buyer_online'])): ?>
                    <div class="d-none d-md-block">
                        <a href="<?= BASE_URL ?>farmers/sign_farmer.php" class="btn btn-outline-success px-4 py-2">
                            <i class="fas fa-user-plus me-2"></i> Register as Farmer
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h2 class="section-header mb-0" id="resultsTitle">Featured Farmers</h2>
                <small class="text-muted" id="resultCount"></small>
            </div>

            <div class="row g-4" id="searchResults">
                <div class="col-12 text-center py-5 text-muted">
                    <i class="fas fa-users fa-3x mb-3"></i>
                    <p>Use the search above to find farmers near you.</p>
                </div>
            </div>
        </section>
    </main>


    <script src="<?= BASE_URL ?>assets/jquery.js"></script>
    <script src="<?= BASE_URL ?>assets/bootstrap/js/bootstrap.bundle.js"></script>
    <script>
        $(document).ready(function() {
            $("#delvstate").change(function() {
                const state_id = $(this).val();
                if (state_id) {
                    $("#delvlga").html('<option value="">Loading LGAs...</option>');
                    $("#delvlga").load("<?= BASE_URL ?>process/process_state_lga.php?id=" + encodeURIComponent(state_id));
                } else {
                    $("#delvlga").html('<option value="">All LGAs</option>');
                }
            });

            $("#searchForm").on("submit", function(e) {
                e.preventDefault();

                const $form = $(this);
                const $btn = $form.find('button[type="submit"]');
                const data = $form.serialize();

                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> Searching...');

                $("#searchResults").html(`
                    <div class="col-12 text-center py-5">
                        <div class="spinner-border text-success" role="status"></div>
                        <p class="mt-3 text-muted">Finding the best farmers for you...</p>
                    </div>
                `);

                $.get("<?= BASE_URL ?>process/process_search.php", data, function(response) {
                    $("#searchResults").html(response ||
                        '<div class="col-12"><div class="alert alert-info">No results found.</div></div>');
                }).fail(function() {
                    $("#searchResults").html('<div class="col-12"><div class="alert alert-danger">Failed to load results. Please try again.</div></div>');
                }).always(function() {
                    $btn.prop('disabled', false).html('<i class="fas fa-search me-2"></i> Search');
                });
            });
        });
    </script>
</body>

</html>