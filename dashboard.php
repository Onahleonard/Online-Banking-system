<?php
session_start();
if (!isset($_SESSION['customer_login']) || !isset($_SESSION['login_id'])) {
    header('location:login.php');
    exit();
}

include '_inc/dbconn.php';

$account_no = mysql_real_escape_string($_SESSION['login_id']);

// Fetch Customer Profile
$cust_sql = "SELECT * FROM customer WHERE id='$account_no'";
$cust_res = mysql_query($cust_sql);
$customer = mysql_fetch_array($cust_res);

// Fetch Current Account Balance from Passbook
$bal_sql = "SELECT amount FROM passbook" . $account_no . " ORDER BY transactionid DESC LIMIT 1";
$bal_res = mysql_query($bal_sql);
$current_balance = 0.00;
if ($bal_res && $bal_row = mysql_fetch_array($bal_res)) {
    $current_balance = floatval($bal_row[0]);
}

// Fetch Recent 5 Transactions
$txn_sql = "SELECT * FROM passbook" . $account_no . " ORDER BY transactionid DESC LIMIT 5";
$txn_res = mysql_query($txn_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - Meridian Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body>

    <?php include 'customer_navbar.php'; ?>

    <main class="bank-container my-4">
        <!-- Welcome Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold mb-1">Welcome back, <?php echo htmlspecialchars($customer['name'] ?? $_SESSION['name']); ?></h1>
                <p class="text-muted small mb-0">Account No: <strong><?php echo $account_no; ?></strong> | Branch: <?php echo htmlspecialchars($customer['branch'] ?? 'Main'); ?> (<?php echo htmlspecialchars($customer['ifsc'] ?? 'IFSC'); ?>)</p>
            </div>
            <a href="customer_transfer.php" class="btn btn-primary rounded-pill px-4">
                + Transfer Funds
            </a>
        </div>

        <!-- Financial Summary Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-4">
                <div class="financial-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="account-type"><?php echo strtoupper(htmlspecialchars($customer['account'] ?? 'SAVINGS')); ?> ACCOUNT</span>
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    </div>
                    <div class="account-number">•••• <?php echo substr($account_no, -4); ?></div>
                    <div class="balance-amount">$<?php echo number_format($current_balance, 2); ?></div>
                    <div class="available-label">Available Balance</div>
                </div>
            </div>

            <div class="col-md-6 col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                    <h2 class="h5 fw-bold mb-3">Profile Overview</h2>
                    <div class="row g-3 small text-muted">
                        <div class="col-sm-6">
                            <span class="fw-semibold text-dark">Email:</span> <?php echo htmlspecialchars($customer['email']); ?>
                        </div>
                        <div class="col-sm-6">
                            <span class="fw-semibold text-dark">Mobile:</span> <?php echo htmlspecialchars($customer['mobile']); ?>
                        </div>
                        <div class="col-sm-6">
                            <span class="fw-semibold text-dark">Nominee:</span> <?php echo htmlspecialchars($customer['nominee']); ?>
                        </div>
                        <div class="col-sm-6">
                            <span class="fw-semibold text-dark">Last Login:</span> <?php echo htmlspecialchars($customer['lastlogin'] ?? 'N/A'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions Grid -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="h5 fw-bold mb-0">Recent Activity</h3>
                <a href="customer_account_statement.php" class="text-decoration-none small fw-semibold text-primary">View Full Statement →</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light small">
                        <tr>
                            <th>Date</th>
                            <th>Narration / Description</th>
                            <th>Credit ($)</th>
                            <th>Debit ($)</th>
                            <th class="text-end">Balance ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($txn_res && mysql_num_rows($txn_res) > 0): ?>
                            <?php while ($row = mysql_fetch_array($txn_res)): ?>
                                <tr>
                                    <td class="small"><?php echo htmlspecialchars($row[1]); ?></td>
                                    <td class="fw-medium"><?php echo htmlspecialchars($row[8]); ?></td>
                                    <td class="text-success fw-semibold"><?php echo floatval($row[5]) > 0 ? '+$' . number_format($row[5], 2) : '-'; ?></td>
                                    <td class="text-danger fw-semibold"><?php echo floatval($row[6]) > 0 ? '-$' . number_format($row[6], 2) : '-'; ?></td>
                                    <td class="text-end fw-bold">$<?php echo number_format($row[7], 2); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No recent transactions logged in passbook.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.nav-dash')?.classList.add('active');
    </script>
</body>
</html>
