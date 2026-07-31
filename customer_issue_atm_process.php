<?php
session_start();
if (!isset($_SESSION['customer_login']) || !isset($_SESSION['login_id'])) {
    header('location:login.php');
    exit();
}

include '_inc/dbconn.php';

$name = mysql_real_escape_string($_SESSION['name']);
$account_no = mysql_real_escape_string($_SESSION['login_id']);
$option = isset($_REQUEST['atm']) ? $_REQUEST['atm'] : '';

if ($option === 'ATM') {
    // Check pending/issued status
    $sql = "SELECT * FROM atm WHERE account_no='$account_no'";
    $result = mysql_query($sql);
    if ($result && $rws = mysql_fetch_array($result)) {
        if ($rws['atm_status'] === 'PENDING' || $rws['atm_status'] === 'ISSUED') {
            echo '<script>alert("You already have an active or pending ATM request!"); window.location="customer_issue_atm.php";</script>';
            exit();
        }
    }

    $sql_insert = "INSERT INTO atm VALUES('', '$name', '$account_no', 'PENDING')";
    mysql_query($sql_insert) or die(mysql_error());

    echo '<script>alert("ATM Card request submitted successfully. Awaiting branch approval."); window.location="customer_issue_atm.php";</script>';
    exit();

} elseif ($option === 'CHEQUE') {
    // Check pending/issued status
    $sql = "SELECT * FROM cheque_book WHERE account_no='$account_no'";
    $result = mysql_query($sql);
    if ($result && $rws = mysql_fetch_array($result)) {
        if ($rws['cheque_book_status'] === 'PENDING' || $rws['cheque_book_status'] === 'ISSUED') {
            echo '<script>alert("You already have an active or pending Cheque Book request!"); window.location="customer_issue_atm.php";</script>';
            exit();
        }
    }

    $sql_insert = "INSERT INTO cheque_book VALUES('', '$name', '$account_no', 'PENDING')";
    mysql_query($sql_insert) or die(mysql_error());

    echo '<script>alert("Cheque Book request submitted successfully. Awaiting branch approval."); window.location="customer_issue_atm.php";</script>';
    exit();

} else {
    header('location:customer_issue_atm.php');
    exit();
}
?>
