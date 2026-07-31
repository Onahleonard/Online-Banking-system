<?php
session_start();
if (!isset($_SESSION['customer_login'])) {
    header('location:login.php');
    exit();
}

include '_inc/dbconn.php';

$sender_id = $_SESSION["login_id"];
$sender_name = $_SESSION["name"];

$Payee_name = mysql_real_escape_string($_REQUEST['name']);
$acc_no = mysql_real_escape_string($_REQUEST['account_no']);
$branch = mysql_real_escape_string($_REQUEST['branch_select']);
$ifsc = mysql_real_escape_string($_REQUEST['ifsc_code']);

// Check self addition
if ($sender_id == $acc_no) {
    echo '<script>alert("You cannot add yourself as a beneficiary!"); window.location="add_beneficiary.php";</script>';
    exit();
}

// Check duplicate beneficiary
$sql1 = "SELECT * FROM beneficiary1 WHERE sender_id='$sender_id' AND reciever_id='$acc_no'";
$result1 = mysql_query($sql1);
if ($result1 && mysql_num_rows($result1) > 0) {
    echo '<script>alert("You cannot add the same beneficiary twice!"); window.location="add_beneficiary.php";</script>';
    exit();
}

// Verify target customer exists in customer table
$sql = "SELECT * FROM customer WHERE id='$acc_no'";
$result = mysql_query($sql);

if (!$result || mysql_num_rows($result) == 0) {
    echo '<script>alert("Beneficiary account not found! Please check details."); window.location="add_beneficiary.php";</script>';
    exit();
}

$rws = mysql_fetch_array($result);

$status = "PENDING";
$sql_insert = "INSERT INTO beneficiary1 VALUES('', '$sender_id', '$sender_name', '$acc_no', '$Payee_name', '$status')";
mysql_query($sql_insert) or die(mysql_error());

echo '<script>alert("Beneficiary request submitted successfully. Awaiting staff approval."); window.location="display_beneficiary.php";</script>';
exit();
?>
