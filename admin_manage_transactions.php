<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header('location:adminlogin.php');
    exit();
}

include '_inc/dbconn.php';

$customer_id = isset($_REQUEST['customer_id']) ? mysql_real_escape_string($_REQUEST['customer_id']) : '';
if (empty($customer_id)) {
    header('location:display_customer.php');
    exit();
}

// Fetch customer details
$cust_sql = "SELECT * FROM customer WHERE id='$customer_id'";
$cust_res = mysql_query($cust_sql);
if (!$cust_res || mysql_num_rows($cust_res) == 0) {
    echo "<script>alert('Customer account not found!'); window.location='display_customer.php';</script>";
    exit();
}
$customer = mysql_fetch_array($cust_res);
$cust_name = $customer['name'];
$cust_branch = $customer['branch'];
$cust_ifsc = $customer['ifsc'];

// Handle transaction addition
$msg = '';
if (isset($_POST['add_tx'])) {
    $tx_date = mysql_real_escape_string($_POST['tx_date']);
    $tx_type = mysql_real_escape_string($_POST['tx_type']);
    $tx_amount = floatval($_POST['tx_amount']);
    $tx_narration = mysql_real_escape_string($_POST['tx_narration']);

    // Fetch last balance
    $bal_sql = "SELECT amount FROM passbook" . $customer_id . " ORDER BY transactionid DESC LIMIT 1";
    $bal_res = mysql_query($bal_sql);
    $last_bal = 0.00;
    if ($bal_res && $bal_row = mysql_fetch_array($bal_res)) {
        $last_bal = floatval($bal_row['amount']);
    }

    $credit = 0;
    $debit = 0;
    if ($tx_type === 'credit') {
        $credit = $tx_amount;
        $new_bal = $last_bal + $tx_amount;
    } else {
        $debit = $tx_amount;
        $new_bal = $last_bal - $tx_amount;
    }

    $insert_sql = "INSERT INTO passbook" . $customer_id . " VALUES('', '$tx_date', '$cust_name', '$cust_branch', '$cust_ifsc', '$credit', '$debit', '$new_bal', '$tx_narration')";
    if (mysql_query($insert_sql)) {
        $msg = "Transaction successfully added to customer passbook!";
    } else {
        $msg = "Error adding transaction: " . mysql_error();
    }
}

// Fetch all passbook transactions
$tx_sql = "SELECT * FROM passbook" . $customer_id . " ORDER BY transactionid DESC";
$tx_res = mysql_query($tx_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Transactions - Admin Dashboard</title>
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
                    <h1 class="h4 fw-bold text-dark mb-1">Manage Ledger Transactions</h1>
                    <p class="text-muted small">Account ID: <strong><?php echo $customer_id; ?></strong> | Customer: <strong><?php echo htmlspecialchars($cust_name); ?></strong></p>

                    <?php if (!empty($msg)): ?>
                        <div class="alert alert-info border-0 small mb-3"><?php echo htmlspecialchars($msg); ?></div>
                    <?php endif; ?>

                    <form method="POST" class="p-3 bg-light rounded-3 border">
                        <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">Transaction Date</label>
                                <input type="date" name="tx_date" value="<?php echo date('Y-m-d'); ?>" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">Transaction Type</label>
                                <select name="tx_type" class="form-select">
                                    <option value="credit">Credit (Deposit)</option>
                                    <option value="debit">Debit (Withdrawal)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">Amount ($)</label>
                                <input type="number" name="tx_amount" step="0.01" min="0.01" class="form-control" required placeholder="0.00">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold small">Narration / Description</label>
                                <input type="text" name="tx_narration" class="form-control" required placeholder="e.g. Wire Deposit, Interest Credit">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" name="add_tx" class="btn btn-primary rounded-pill px-4">Post Transaction</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h3 class="h5 fw-bold text-dark mb-3">Passbook Transaction History</h3>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle small">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Narration</th>
                                    <th>Credit ($)</th>
                                    <th>Debit ($)</th>
                                    <th>Balance ($)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($tx_res && mysql_num_rows($tx_res) > 0): ?>
                                    <?php while ($row = mysql_fetch_array($tx_res)): ?>
                                        <tr>
                                            <td><?php echo $row[0]; ?></td>
                                            <td><?php echo $row[1]; ?></td>
                                            <td><?php echo htmlspecialchars($row[8]); ?></td>
                                            <td class="text-success"><?php echo floatval($row[5]) > 0 ? '$' . number_format($row[5], 2) : '-'; ?></td>
                                            <td class="text-danger"><?php echo floatval($row[6]) > 0 ? '$' . number_format($row[6], 2) : '-'; ?></td>
                                            <td class="fw-bold">$<?php echo number_format($row[7], 2); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="6" class="text-center text-muted py-3">No transaction entries found in passbook.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
