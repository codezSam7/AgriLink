<?php

session_start();
require_once '../classes/Farmer.php';
$f = new Farmer;

if (isset($_POST['updateprofilebtn'])) {

    $fullname = $_POST['fullname'];
    $farmname = $_POST['farmname'];
    $phone = $_POST['phone'];
    $status = $_POST['status'];
    $farmerDetails = $f->get_farmer_details($_SESSION['farmer_online']);
    $farmer_id = $farmerDetails['farmer_id'];

    if (! empty($_FILES['cover']['name'])) {

        $filename = $_FILES['cover']['name'];
        $filetmp = $_FILES['cover']['tmp_name'];
        $filesize = $_FILES['cover']['size'];
        $fileerror = $_FILES['cover']['error'];

        $result = $f->upload_file($fileerror, $filesize, $filename, $filetmp);

        if ($result == false) {
            $_SESSION['errormsg'] = 'Error uploading file';
            header('location:../profile.php');
            exit;
        }

        $final_res = $f->update_profile($fullname, $farmname, $phone, $status, $farmer_id, $result);
    } else {
        $final_res = $f->update_profile($fullname, $farmname, $phone, $status, $farmer_id);
    }

    if ($final_res) {
        $_SESSION['msg'] = 'Your profile has been updated successfully';
    } else {
        $_SESSION['errormsg'] = 'Error updating your profile';
    }

    header('location:../profile.php');
    exit;
} else {
    header('location:../profile.php');
    exit;
}
