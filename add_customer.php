<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header('location:adminlogin.php');
    exit();
}

include '_inc/dbconn.php';

if (isset($_POST['add_customer'])) {
    $name = mysql_real_escape_string($_POST['customer_name']);
    $gender = mysql_real_escape_string($_POST['customer_gender']);
    $dob = mysql_real_escape_string($_POST['customer_dob']);
    $nominee = mysql_real_escape_string($_POST['customer_nominee']);
    $type = mysql_real_escape_string($_POST['customer_account']);
    $credit = floatval($_POST['initial']);
    $address = mysql_real_escape_string($_POST['customer_address']);
    $mobile = mysql_real_escape_string($_POST['customer_mobile']);
    $email = mysql_real_escape_string($_POST['customer_email']);
    $branch = mysql_real_escape_string($_POST['branch']);

    $salt = "@g26jQsG&nh*&#8v";
    $password = sha1($_POST['customer_pwd'] . $salt);

    $date = date("Y-m-d");
    switch ($branch) {
        case 'KOLKATA': $ifsc = "K421A"; break;
        case 'DELHI': $ifsc = "D30AC"; break;
        case 'BANGALORE': $ifsc = "B6A9E"; break;
        default: $ifsc = "M100B"; break;
    }

    $sql_insert = "INSERT INTO customer VALUES('', '$name', '$gender', '$dob', '$nominee', '$type', '$address', '$mobile', '$email', '$password', '$branch', '$ifsc', '', 'ACTIVE')";
    if (!mysql_query($sql_insert)) {
        die("Error creating customer account: " . mysql_error());
    }

    $id = mysql_insert_id();

    // Create passbook table for customer
    $sql_create_passbook = "CREATE TABLE passbook" . $id . " 
        (transactionid int(5) AUTO_INCREMENT, transactiondate date, name VARCHAR(255), branch VARCHAR(255), ifsc VARCHAR(255), credit int(10), debit int(10), 
        amount float(10,2), narration VARCHAR(255), PRIMARY KEY (transactionid))";
    mysql_query($sql_create_passbook) or die(mysql_error());

    // Insert opening balance entry
    $sql_init_passbook = "INSERT INTO passbook" . $id . " VALUES('', '$date', '$name', '$branch', '$ifsc', '$credit', '0', '$credit', 'Account Open')";
    mysql_query($sql_init_passbook) or die(mysql_error());

    header('location:admin_hompage.php');
    exit();
}
?>
