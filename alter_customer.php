<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header('location:adminlogin.php');
    exit();
}

include '_inc/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysql_real_escape_string($_POST['edit_name']);
    $gender = mysql_real_escape_string($_POST['edit_gender']);
    $dob = mysql_real_escape_string($_POST['edit_dob']);
    $id = mysql_real_escape_string($_POST['current_id']);
    $type = mysql_real_escape_string($_POST['edit_account']);
    $nominee = mysql_real_escape_string($_POST['edit_nominee']);
    $address = mysql_real_escape_string($_POST['edit_address']);
    $mobile = mysql_real_escape_string($_POST['edit_mobile']);
    $email = mysql_real_escape_string($_POST['edit_email']);

    $sql = "UPDATE customer SET name='$name', gender='$gender', dob='$dob', nominee='$nominee', account='$type', address='$address', mobile='$mobile', email='$email' WHERE id='$id'";
    mysql_query($sql) or die("Error updating customer profile: " . mysql_error());

    header('location:display_customer.php');
    exit();
}
?>
