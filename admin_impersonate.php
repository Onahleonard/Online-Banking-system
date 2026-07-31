<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header('location:adminlogin.php');
    exit();
}

include '_inc/dbconn.php';

$customer_id = isset($_REQUEST['customer_id']) ? mysql_real_escape_string($_REQUEST['customer_id']) : '';

if (empty($customer_id)) {
    echo "<script>alert('Please select a customer first!'); window.location='display_customer.php';</script>";
    exit();
}

$sql = "SELECT * FROM customer WHERE id='$customer_id'";
$res = mysql_query($sql);

if ($res && mysql_num_rows($res) > 0) {
    $row = mysql_fetch_array($res);

    // Set impersonator session flag
    $_SESSION['admin_impersonator'] = true;

    // Set active customer session variables
    $_SESSION['customer_login'] = 1;
    $_SESSION['cust_id'] = $row['email'];
    $_SESSION['login_id'] = $row['id'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['customer_id'] = $row['id'];

    header('location:dashboard.php');
    exit();
} else {
    echo "<script>alert('Customer not found!'); window.location='display_customer.php';</script>";
    exit();
}
?>
