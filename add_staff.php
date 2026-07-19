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
$name=  mysql_real_escape_string($_REQUEST['staff_name']);
$gender=  mysql_real_escape_string($_REQUEST['staff_gender']);
$dob=  mysql_real_escape_string($_REQUEST['staff_dob']);
$status=  mysql_real_escape_string($_REQUEST['staff_status']);
$dept=  mysql_real_escape_string($_REQUEST['staff_dept']);
$doj=  mysql_real_escape_string($_REQUEST['staff_doj']);
$address=  mysql_real_escape_string($_REQUEST['staff_address']);
$mobile=  mysql_real_escape_string($_REQUEST['staff_mobile']);
$email= mysql_real_escape_string($_REQUEST['staff_email']);
$password=  mysql_real_escape_string($_REQUEST['staff_pwd']);

$sql="insert into staff values('','$name','$dob','$status','$dept','$doj','$address','$mobile',
    '$email','$password','$gender','')";
mysql_query($sql) or die("the email-id is already registered");
header('location:admin_hompage.php');
?>

        </div>
    </div>
</body>
</html>
