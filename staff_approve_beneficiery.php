<?php
session_start();
if (!isset($_SESSION['staff_login'])) {
    header('location:staff_login.php');
    exit();
}

include '_inc/dbconn.php';

if (isset($_REQUEST['submit_id'])) {
    $id = mysql_real_escape_string($_REQUEST['customer_id']);

    $sql = "UPDATE beneficiary1 SET status='ACTIVE' WHERE id='$id'";
    mysql_query($sql) or die(mysql_error());

    echo '<script>alert("Beneficiary status updated to ACTIVE successfully."); window.location="staff_beneficiary.php";</script>';
    exit();
} else {
    header('location:staff_beneficiary.php');
    exit();
}
?>
