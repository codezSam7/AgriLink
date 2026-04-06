<?php
session_start();
require_once '../config/constants.php';
require_once '../classes/Farmer.php';

$f = new Farmer();

$search    = $_GET['search'] ?? '';
$state_id  = $_GET['delvstate'] ?? '';
$lga_id    = $_GET['delvlga'] ?? '';

$results = $f->search_farmers($search, $state_id, $lga_id);

if (!empty($results)) {
    foreach ($results as $farmer) {
        $farmer_id = (int)($farmer['farmer_id'] ?? 0);

        if ($farmer_id <= 0) continue;
?>
        <div class="col-12 col-md-6 col-lg-4">
            <article class="card card-farmer h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="avatar">
                            <?= strtoupper(substr($farmer['farmer_fullname'] ?? 'F', 0, 1)) ?>
                        </div>
                        <div>
                            <div class="fw-semibold fs-5"><?= htmlspecialchars($farmer['farmer_fullname'] ?? 'Unknown Farmer') ?></div>
                            <div class="small text-muted">
                                <?= htmlspecialchars($farmer['farmer_primary_produce'] ?? '') ?> •
                                <?= htmlspecialchars($farmer['state_name'] ?? 'Nigeria') ?>
                            </div>
                        </div>
                    </div>

                    <p class="small text-muted mb-4 flex-grow-1">
                        <?= htmlspecialchars($farmer['farmer_bio'] ?? 'No bio available.') ?>
                    </p>

                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-success"><?= htmlspecialchars($farmer['farmer_status'] ?? 'Active') ?></span>
                        </div>
                        <div>
                            <a href="<?= BASE_URL ?>farmers/farmer_profile_view.php?id=<?= $farmer_id ?>"
                                class="btn btn-outline-success btn-sm px-4">
                                <i class="fas fa-eye"></i> View Profile
                            </a>
                        </div>
                    </div>
                </div>
            </article>
        </div>
<?php
    }
} else {
    echo '<div class="col-12"><div class="alert alert-info">No results found matching your search.</div></div>';
}
