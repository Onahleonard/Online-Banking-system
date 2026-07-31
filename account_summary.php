<?php
session_start();
if (!isset($_SESSION['customer_login'])) {
    header('location:login.php');
    exit();
}

include '_inc/dbconn.php';

$cust_id = mysql_real_escape_string($_SESSION['cust_id']);
$sql = "SELECT * FROM customer WHERE email='$cust_id'";
$result = mysql_query($sql) or die(mysql_error());
$rws = mysql_fetch_array($result);

$account_no = $rws[0];
$name = $rws[1];
$gender = $rws[2] === 'M' ? 'Male' : 'Female';
$dob = $rws[3];
$nominee = $rws[4];
$acc_type = $rws[5];
$address = $rws[6];
$mobile = $rws[7];
$email = $rws[8];
$branch = $rws[10];
$branch_code = $rws[11];
$last_login = $rws[12];
$acc_status = $rws[13];

// Fetch current balance from customer passbook
$bal_sql = "SELECT amount FROM passbook" . $account_no . " ORDER BY transactionid DESC LIMIT 1";
$bal_res = mysql_query($bal_sql);
$balance = 0.00;
if ($bal_res && $bal_row = mysql_fetch_array($bal_res)) {
    $balance = floatval($bal_row[0]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Summary - Meridian Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light">

    <?php include 'customer_navbar.php'; ?>

    <main class="container my-5" style="max-width: 800px;">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h2 class="h4 fw-bold text-dark mb-4 text-center">Account Summary</h2>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <div class="small text-muted">Account Holder</div>
                        <div class="fw-bold fs-5 text-dark"><?php echo htmlspecialchars($name); ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <div class="small text-muted">Available Balance</div>
                        <div class="fw-bold fs-5 text-success">$<?php echo number_format($balance, 2); ?></div>
                    </div>
                </div>

                <div class="col-md-6"><span class="fw-semibold">Account Number:</span> <?php echo $account_no; ?></div>
                <div class="col-md-6"><span class="fw-semibold">Account Type:</span> <?php echo ucfirst(htmlspecialchars($acc_type)); ?></div>
                <div class="col-md-6"><span class="fw-semibold">Branch:</span> <?php echo htmlspecialchars($branch); ?> (IFSC: <?php echo htmlspecialchars($branch_code); ?>)</div>
                <div class="col-md-6"><span class="fw-semibold">Account Status:</span> <span class="badge bg-success"><?php echo htmlspecialchars($acc_status); ?></span></div>

                <hr class="my-3">

                <div class="col-md-6"><span class="fw-semibold">Email:</span> <?php echo htmlspecialchars($email); ?></div>
                <div class="col-md-6"><span class="fw-semibold">Mobile:</span> <?php echo htmlspecialchars($mobile); ?></div>
                <div class="col-md-6"><span class="fw-semibold">Gender:</span> <?php echo $gender; ?></div>
                <div class="col-md-6"><span class="fw-semibold">Nominee:</span> <?php echo htmlspecialchars($nominee); ?></div>
                <div class="col-md-12"><span class="fw-semibold">Residential Address:</span> <?php echo htmlspecialchars($address); ?></div>
                <div class="col-md-12"><span class="fw-semibold">Last Login:</span> <?php echo htmlspecialchars($last_login ?? 'N/A'); ?></div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
