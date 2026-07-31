<?php
session_start();
if (!isset($_SESSION['customer_login'])) {
    header('location:login.php');
    exit();
}

include '_inc/dbconn.php';

if (isset($_REQUEST['submit_id'])) {
    $beneficiary_id = mysql_real_escape_string($_REQUEST["customer_id"]);
    $sql = "DELETE FROM beneficiary1 WHERE id='$beneficiary_id'";
    mysql_query($sql) or die(mysql_error());

    echo '<script>alert("Beneficiary removed successfully."); window.location="display_beneficiary.php";</script>';
    exit();
} else {
    header('location:display_beneficiary.php');
    exit();
}
?>
