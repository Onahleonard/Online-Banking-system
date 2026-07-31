<?php
session_start();
if (!isset($_SESSION['staff_login']) || !isset($_SESSION['staff_id'])) {
    header('location:staff_login.php');
    exit();
}

include '_inc/dbconn.php';

$staff_email = mysql_real_escape_string($_SESSION['staff_id']);
$sql = "SELECT * FROM staff WHERE email='$staff_email'";
$result = mysql_query($sql) or die(mysql_error());
$rws = mysql_fetch_array($result);

$name = $rws[1];
$department = $rws[4];
$doj = $rws[5];
$email = $rws[8];
$last_login = $rws[11];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light">

    <?php include 'header.php'; ?>

    <div class="container my-4">
        <div class="row">
            <div class="col-md-3 mb-4">
                <?php include 'staff_navbar.php'; ?>
            </div>
            <div class="col-md-9">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h1 class="h3 fw-bold text-dark mb-1">Welcome back, <?php echo htmlspecialchars($name); ?></h1>
                    <p class="text-muted small mb-3">Staff Department: <strong><?php echo ucfirst(htmlspecialchars($department)); ?></strong></p>

                    <div class="row g-3 small bg-light p-3 rounded-3 border">
                        <div class="col-sm-6"><span class="fw-semibold">Email:</span> <?php echo htmlspecialchars($email); ?></div>
                        <div class="col-sm-6"><span class="fw-semibold">Date of Joining:</span> <?php echo htmlspecialchars($doj); ?></div>
                        <div class="col-sm-12"><span class="fw-semibold">Last Login:</span> <?php echo htmlspecialchars($last_login ?? 'N/A'); ?></div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="staff_beneficiary.php" class="card border-0 shadow-sm rounded-4 p-3 bg-white text-decoration-none h-100 text-dark">
                            <h5 class="fw-bold text-primary mb-1">Beneficiary Requests</h5>
                            <p class="text-muted small mb-0">Approve pending payee additions.</p>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="staff_atm_approve.php" class="card border-0 shadow-sm rounded-4 p-3 bg-white text-decoration-none h-100 text-dark">
                            <h5 class="fw-bold text-success mb-1">ATM Approvals</h5>
                            <p class="text-muted small mb-0">Issue pending debit cards.</p>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="staff_cheque_approve.php" class="card border-0 shadow-sm rounded-4 p-3 bg-white text-decoration-none h-100 text-dark">
                            <h5 class="fw-bold text-warning mb-1">Cheque Approvals</h5>
                            <p class="text-muted small mb-0">Approve pending cheque books.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
