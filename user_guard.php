<?php

// whenever a user logs in, we keep user_online
if (! isset($_SESSION['farmer_online']) || ! isset($_SESSION['buyer_online'])) {
    $_SESSION['errormsg'] = 'You need to be logged in to access the page';
    header('location:login.php');
    exit;
}
