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
    $status = mysql_real_escape_string($_POST['edit_status']);
    $dept = mysql_real_escape_string($_POST['edit_dept']);
    $doj = mysql_real_escape_string($_POST['edit_doj']);
    $address = mysql_real_escape_string($_POST['edit_address']);
    $mobile = mysql_real_escape_string($_POST['edit_mobile']);
    $email = mysql_real_escape_string($_POST['edit_email']);

    $sql = "UPDATE staff SET name='$name', gender='$gender', dob='$dob', relationship='$status', department='$dept', doj='$doj', address='$address', mobile='$mobile', email='$email' WHERE id='$id'";
    mysql_query($sql) or die("Error updating staff record: " . mysql_error());

    header('location:display_staff.php');
    exit();
}
?>
