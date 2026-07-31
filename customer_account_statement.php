<?php
session_start();
if (!isset($_SESSION['customer_login']) || !isset($_SESSION['login_id'])) {
    header('location:login.php');
    exit();
}

include '_inc/dbconn.php';

$account_no = mysql_real_escape_string($_SESSION['login_id']);

$stmt_sql = "SELECT * FROM passbook" . $account_no . " ORDER BY transactionid DESC";
$stmt_res = mysql_query($stmt_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Statement - Meridian Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light">

    <?php include 'customer_navbar.php'; ?>

    <main class="container my-5 max-width-1200">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold mb-1">Full Account Statement</h1>
                <p class="text-muted small mb-0">Complete historical transaction ledger for Account No: <strong><?php echo $account_no; ?></strong></p>
            </div>
            <div class="d-flex gap-2">
                <a href="customer_account_statement_date.php" class="btn btn-outline-primary btn-sm rounded-pill px-3">Filter by Date</a>
                <button onclick="window.print()" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Print Statement</button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light small">
                        <tr>
                            <th>Txn ID</th>
                            <th>Date</th>
                            <th>Narration / Description</th>
                            <th>Credit ($)</th>
                            <th>Debit ($)</th>
                            <th class="text-end">Balance Amount ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($stmt_res && mysql_num_rows($stmt_res) > 0): ?>
                            <?php while ($row = mysql_fetch_array($stmt_res)): ?>
                                <tr>
                                    <td><?php echo $row[0]; ?></td>
                                    <td><?php echo $row[1]; ?></td>
                                    <td class="fw-medium"><?php echo htmlspecialchars($row[8]); ?></td>
                                    <td class="text-success fw-semibold"><?php echo floatval($row[5]) > 0 ? '+$' . number_format($row[5], 2) : '-'; ?></td>
                                    <td class="text-danger fw-semibold"><?php echo floatval($row[6]) > 0 ? '-$' . number_format($row[6], 2) : '-'; ?></td>
                                    <td class="text-end fw-bold">$<?php echo number_format($row[7], 2); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No transaction history found in passbook.</td>
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
        document.querySelector('.nav-stmt')?.classList.add('active');
    </script>
</body>
</html>
