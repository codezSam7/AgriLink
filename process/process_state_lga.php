<?php
require_once('../classes/Farmer.php');
$c = new Farmer();

if (!isset($_GET['id']) || !is_numeric($_GET['id']) || empty($_GET['id'])) {
    echo '<option value="">Select State First</option>';
    exit;
}

$state_id = $_GET['id'];
$lgas = $c->fetch_lga($state_id);

echo '<option value="">Select LGA</option>';
foreach ($lgas as $lga) {
    $value = $lga['lga_id'];
    $label = $lga['lga_name'];
    $result = "<option value='$value'>$label</option>";
    echo $result;
}
