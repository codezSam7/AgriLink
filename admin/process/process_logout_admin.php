<?php

session_start();
require_once '../classes/Admin.php';

$a = new Admin;

$a->logout();

$_SESSION['msg'] = 'You have logged out successfully';
header('location:../ad_login.php');
exit;
