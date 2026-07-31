<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header('location:adminlogin.php');
    exit();
}

include '_inc/dbconn.php';

if (isset($_POST['add_staff']) || $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysql_real_escape_string($_POST['staff_name']);
    $gender = mysql_real_escape_string($_POST['staff_gender']);
    $dob = mysql_real_escape_string($_POST['staff_dob']);
    $status = mysql_real_escape_string($_POST['staff_status']);
    $dept = mysql_real_escape_string($_POST['staff_dept']);
    $doj = mysql_real_escape_string($_POST['staff_doj']);
    $address = mysql_real_escape_string($_POST['staff_address']);
    $mobile = mysql_real_escape_string($_POST['staff_mobile']);
    $email = mysql_real_escape_string($_POST['staff_email']);
    $password = mysql_real_escape_string($_POST['staff_pwd']);

    $sql = "INSERT INTO staff VALUES('', '$name', '$dob', '$status', '$dept', '$doj', '$address', '$mobile', '$email', '$password', '$gender', '')";
    
    if (!mysql_query($sql)) {
        die("Error registering staff: Email ID might already exist. " . mysql_error());
    }

    header('location:admin_hompage.php');
    exit();
}
?>
