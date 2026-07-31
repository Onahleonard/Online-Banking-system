<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header('location:adminlogin.php');
    exit();
}

include '_inc/dbconn.php';

// Fetch quick stats
$cust_count = 0;
$staff_count = 0;

$c_res = mysql_query("SELECT COUNT(*) FROM customer");
if ($c_res && $c_row = mysql_fetch_array($c_res)) {
    $cust_count = $c_row[0];
}

$s_res = mysql_query("SELECT COUNT(*) FROM staff");
if ($s_res && $s_row = mysql_fetch_array($s_res)) {
    $staff_count = $s_row[0];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Meridian Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light">

    <?php include 'header.php'; ?>

    <div class="container my-4">
        <div class="row">
            <div class="col-md-3 mb-4">
                <?php include 'admin_navbar.php'; ?>
            </div>
            <div class="col-md-9">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h1 class="h3 fw-bold text-dark mb-2">Admin Dashboard</h1>
                    <p class="text-muted small">Welcome to the secure administrative control panel.</p>

                    <div class="row g-3 my-2">
                        <div class="col-md-6">
                            <div class="p-3 bg-primary bg-opacity-10 rounded-3 border border-primary border-opacity-25">
                                <div class="small text-primary fw-semibold">Total Active Customers</div>
                                <div class="fs-2 fw-bold text-primary"><?php echo $cust_count; ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-success bg-opacity-10 rounded-3 border border-success border-opacity-25">
                                <div class="small text-success fw-semibold">Total Staff Members</div>
                                <div class="fs-2 fw-bold text-success"><?php echo $staff_count; ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                            <h3 class="h5 fw-bold text-dark border-bottom pb-2 mb-3">Customer Operations</h3>
                            <ul class="list-unstyled d-grid gap-2 mb-0">
                                <li><a href="addcustomer.php" class="btn btn-outline-primary text-start w-100">+ Add New Customer Account</a></li>
                                <li><a href="display_customer.php" class="btn btn-outline-secondary text-start w-100">Edit / Manage Customer Accounts</a></li>
                                <li><a href="delete_customer.php" class="btn btn-outline-danger text-start w-100">Delete Customer Account</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                            <h3 class="h5 fw-bold text-dark border-bottom pb-2 mb-3">Staff Operations</h3>
                            <ul class="list-unstyled d-grid gap-2 mb-0">
                                <li><a href="addstaff.php" class="btn btn-outline-primary text-start w-100">+ Add New Staff Member</a></li>
                                <li><a href="display_staff.php" class="btn btn-outline-secondary text-start w-100">Edit / Manage Staff Details</a></li>
                                <li><a href="delete_staff.php" class="btn btn-outline-danger text-start w-100">Delete Staff Member</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
