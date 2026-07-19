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
if (isset($_SESSION['admin_impersonator'])) {
    unset($_SESSION['customer_login']);
    unset($_SESSION['cust_id']);
    unset($_SESSION['login_id']);
    unset($_SESSION['name']);
    unset($_SESSION['admin_impersonator']);
}
header('location:display_customer.php');
exit();
?>

        </div>
    </div>
</body>
</html>
