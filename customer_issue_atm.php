<?php
session_start();
if (!isset($_SESSION['customer_login']) || !isset($_SESSION['login_id'])) {
    header('location:login.php');
    exit();
}

include '_inc/dbconn.php';

$account_no = mysql_real_escape_string($_SESSION['login_id']);

// Fetch ATM Card Status
$atm_sql = "SELECT * FROM atm WHERE account_no='$account_no' ORDER BY id DESC LIMIT 1";
$atm_res = mysql_query($atm_sql);
$atm_status = ($atm_res && $atm_row = mysql_fetch_array($atm_res)) ? $atm_row['atm_status'] : 'NOT REQUESTED';

// Fetch Cheque Book Status
$cheque_sql = "SELECT * FROM cheque_book WHERE account_no='$account_no' ORDER BY id DESC LIMIT 1";
$cheque_res = mysql_query($cheque_sql);
$cheque_status = ($cheque_res && $cheque_row = mysql_fetch_array($cheque_res)) ? $cheque_row['cheque_book_status'] : 'NOT REQUESTED';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATM & Cheque Book Request - Meridian Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light">

    <?php include 'customer_navbar.php'; ?>

    <main class="container my-5" style="max-width: 650px;">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h1 class="h4 fw-bold text-dark mb-1">Issue / Request Cards & Cheque Book</h1>
            <p class="text-muted small mb-4">Request a new physical debit card or cheque book for Account No: <strong><?php echo $account_no; ?></strong>.</p>

            <form action="customer_issue_atm_process.php" method="POST">
                <div class="mb-4">
                    <label class="form-label fw-semibold">Select Request Type</label>
                    <select name="atm" class="form-select" required>
                        <option value="ATM">ATM Debit Card</option>
                        <option value="CHEQUE">Cheque Book</option>
                    </select>
                </div>

                <button type="submit" name="submitBtn" class="btn btn-primary w-100 py-2 rounded-pill fw-semibold">Submit Request</button>
            </form>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h3 class="h5 fw-bold text-dark mb-3">Request Status Overview</h3>
            <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-3 mb-2">
                <span class="fw-semibold text-dark">ATM Card Request:</span>
                <span class="badge bg-<?php echo $atm_status === 'ISSUED' ? 'success' : ($atm_status === 'PENDING' ? 'warning' : 'secondary'); ?> fs-6"><?php echo $atm_status; ?></span>
            </div>
            <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-3">
                <span class="fw-semibold text-dark">Cheque Book Request:</span>
                <span class="badge bg-<?php echo $cheque_status === 'ISSUED' ? 'success' : ($cheque_status === 'PENDING' ? 'warning' : 'secondary'); ?> fs-6"><?php echo $cheque_status; ?></span>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.nav-atm')?.classList.add('active');
    </script>
</body>
</html>
