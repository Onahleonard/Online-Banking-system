<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header('location:adminlogin.php');
    exit();
}

include '_inc/dbconn.php';

$sql = "SELECT * FROM admin WHERE id=1";
$result = mysql_query($sql) or die(mysql_error());
$rws = mysql_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin Profile - Admin Dashboard</title>
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
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h1 class="h4 fw-bold text-dark mb-4 border-bottom pb-2">Admin Profile Details</h1>

                    <div class="row g-3 small">
                        <div class="col-md-6"><span class="fw-semibold">Name:</span> <?php echo htmlspecialchars($rws['name'] ?? 'Admin'); ?></div>
                        <div class="col-md-6"><span class="fw-semibold">Login ID:</span> <?php echo htmlspecialchars($rws['login_id'] ?? 'admin'); ?></div>
                        <div class="col-md-6"><span class="fw-semibold">Designation:</span> <?php echo htmlspecialchars($rws['designation'] ?? 'Administrator'); ?></div>
                        <div class="col-md-6"><span class="fw-semibold">Department:</span> <?php echo htmlspecialchars($rws['department'] ?? 'IT'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
