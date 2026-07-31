<?php
session_start();
if (isset($_SESSION['admin_impersonator'])) {
    unset($_SESSION['customer_login']);
    unset($_SESSION['cust_id']);
    unset($_SESSION['login_id']);
    unset($_SESSION['name']);
    unset($_SESSION['admin_impersonator']);
}
header('location:display_customer.php');
exit();
?>
