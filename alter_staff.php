<!DOCTYPE html>
<html lang='en'>
<head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body class='bg-light'>
    <div class='container mt-5'>
        <div class='card p-4 shadow-sm'>
<?php 
session_start();
        
if(!isset($_SESSION['admin_login'])) 
    header('location:adminlogin.php');   
?>
<?php
include '_inc/dbconn.php';
$name=  mysql_real_escape_string($_REQUEST['edit_name']);
$gender=  mysql_real_escape_string($_REQUEST['edit_gender']);
$dob=  mysql_real_escape_string($_REQUEST['edit_dob']);
$id=  mysql_real_escape_string($_REQUEST['current_id']);
$status=  mysql_real_escape_string($_REQUEST['edit_status']);
$dept=  mysql_real_escape_string($_REQUEST['edit_dept']);
$doj=  mysql_real_escape_string($_REQUEST['edit_doj']);
$address=  mysql_real_escape_string($_REQUEST['edit_address']);
$mobile=  mysql_real_escape_string($_REQUEST['edit_mobile']);

$sql="UPDATE staff SET  name='$name', dob='$dob', relationship='$status', 
    department='$dept', doj='$doj', address='$address', 
        mobile='$mobile', gender='$gender' WHERE id='$id'";
mysql_query($sql) or die(mysql_error());
header('location:admin_hompage.php');
?>

        </div>
    </div>
</body>
</html>
