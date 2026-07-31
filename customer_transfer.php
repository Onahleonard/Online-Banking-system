<?php
session_start();

if (!isset($_SESSION['customer_login'])) {
    header("location:index.php");
    exit();
}

include '_inc/dbconn.php';

$sender_id = $_SESSION['login_id'];

$sql = "SELECT * FROM customer WHERE id='$sender_id'";
$result = mysql_query($sql);
$customer = mysql_fetch_array($result);

$sql = "SELECT MAX(transactionid) FROM passbook".$sender_id;
$result = mysql_query($sql);
$row = mysql_fetch_array($result);

$lastid = $row[0];

$sql = "SELECT amount FROM passbook".$sender_id." WHERE transactionid='$lastid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);

$balance = $row[0];



<!DOCTYPE html>
<html>

<head>

<title>Transfer Funds</title>

<link rel="stylesheet" href="newcss.css">

</head>

<body>

<?php include 'customer_navbar.php'; ?>

<h2>Fund Transfer</h2>

<form action="customer_transfer_process.php" method="post">

<label>Recipient</label>

<select name="transfer">

<?php

$result=mysql_query("SELECT id,name FROM customer WHERE id!='$sender_id'");

while($row=mysql_fetch_array($result))
{

echo "<option value='".$row['id']."'>".$row['name']." (".$row['id'].")</option>";

}

?>

</select>

<br><br>

<label>Amount</label>

<input
type="number"
name="t_val"
required
min="100">

<br><br>

<h3>

Current Balance :

<?php

echo "$".number_format($balance,2);

?>

</h3>

<br>

<input
type="submit"
value="Transfer">

</form>

</body>

</html>