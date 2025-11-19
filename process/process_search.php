<?php
session_start();
require_once '../classes/Farmer.php';
require_once '../classes/Buyer.php';

$f = new Farmer;
$b = new Buyer;

$search = $_GET['search'] ?? '';
$state_id = $_GET['delvstate'] ?? '';
$lga_id = $_GET['delvlga'] ?? '';

$results = $f->search_farmers($search, $state_id, $lga_id);

if (! empty($results)) {
    foreach ($results as $farmer) {
        ?>
        <div class="col-12 col-md-6 col-lg-4">
            <article class="card h-100 shadow-sm border-0">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width:56px;height:56px;border-radius:10px;background:#f3fbf7;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--brand);">
                            F
                        </div>
                        <div>
                            <div class="fw-semibold"><?= htmlspecialchars($farmer['farmer_fullname']); ?></div>
                            <div class="small text-muted">
                                <?= htmlspecialchars($farmer['farmer_primary_produce'].' . '.$farmer['state_name']); ?>
                            </div>
                        </div>
                    </div>

                    <p class="small text-muted mb-3"><?= htmlspecialchars($farmer['farmer_bio']); ?></p>

                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-success"><?= htmlspecialchars($farmer['farmer_status']); ?></span>
                        </div>
                        <div>
                            <a class="btn btn-sm btn-outline-secondary" href="farmer_profile_view.php">View profile</a>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <?php
    }
} else {
    echo '<div class="alert alert-info">No results found.</div>';
}
