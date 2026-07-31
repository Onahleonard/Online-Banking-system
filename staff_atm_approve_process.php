<?php
session_start();
if (!isset($_SESSION['staff_login'])) {
    header('location:staff_login.php');
    exit();
}

include '_inc/dbconn.php';

if (isset($_REQUEST['submit_id'])) {
    $id = mysql_real_escape_string($_REQUEST['customer_id']);

    $sql = "UPDATE atm SET atm_status='ISSUED' WHERE id='$id'";
    mysql_query($sql) or die(mysql_error());

    echo '<script>alert("ATM Card request approved and set to ISSUED."); window.location="staff_atm_approve.php";</script>';
    exit();
} else {
    header('location:staff_atm_approve.php');
    exit();
}
?>
