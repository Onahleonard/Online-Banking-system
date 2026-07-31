<?php
session_start();
include '_inc/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_REQUEST['submitBtn'])) {
    $email = isset($_REQUEST['email']) ? mysql_real_escape_string(trim($_REQUEST['email'])) : '';
    $raw_pwd = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';

    $salt = "@g26jQsG&nh*&#8v";
    $hashed_pwd = sha1($raw_pwd . $salt);

    $sql = "SELECT * FROM customer WHERE email='$email' AND password='$hashed_pwd'";
    $result = mysql_query($sql);

    if ($result && mysql_num_rows($result) > 0) {
        $rws = mysql_fetch_array($result);

        if (strtoupper($rws['accstatus']) === 'INACTIVE') {
            header('location:login.php?error=inactive');
            exit();
        }

        $_SESSION['customer_login'] = 1;
        $_SESSION['cust_id'] = $rws['email'];
        $_SESSION['login_id'] = $rws['id']; // Primary account number
        $_SESSION['name'] = $rws['name'];
        $_SESSION['customer_id'] = $rws['id'];

        header('location:dashboard.php');
        exit();
    } else {
        header('location:login.php?error=invalid');
        exit();
    }
} else {
    header('location:login.php');
    exit();
}
?>
