<?php
session_start();
if (!isset($_SESSION['customer_login']) || !isset($_SESSION['login_id'])) {
    header('location:login.php');
    exit();
}

include '_inc/dbconn.php';

$account_no = mysql_real_escape_string($_SESSION['login_id']);
$date1 = isset($_REQUEST['date1']) ? mysql_real_escape_string($_REQUEST['date1']) : '';
$date2 = isset($_REQUEST['date2']) ? mysql_real_escape_string($_REQUEST['date2']) : '';

$result = false;
if (!empty($date1) && !empty($date2)) {
    $sql = "SELECT * FROM passbook" . $account_no . " WHERE transactiondate BETWEEN '$date1' AND '$date2' ORDER BY transactionid DESC";
    $result = mysql_query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statement by Date - Meridian Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light">

    <?php include 'customer_navbar.php'; ?>

    <main class="container my-5 max-width-1200">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h1 class="h4 fw-bold text-dark mb-3">Filter Statement by Date Range</h1>

            <form action="" method="GET" class="row g-3 align-items-end mb-2">
                <div class="col-md-4">
                    <label class="form-label fw-semibold small">Start Date</label>
                    <input type="date" name="date1" class="form-control" value="<?php echo htmlspecialchars($date1); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold small">End Date</label>
                    <input type="date" name="date2" class="form-control" value="<?php echo htmlspecialchars($date2); ?>" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" name="summary_date" class="btn btn-primary rounded-pill px-4 w-100">Fetch Passbook Entries</button>
                </div>
            </form>
        </div>

        <?php if (!empty($date1) && !empty($date2)): ?>
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="h5 fw-bold text-dark mb-0">Filtered Transactions (<?php echo htmlspecialchars($date1); ?> to <?php echo htmlspecialchars($date2); ?>)</h3>
                    <button onclick="window.print()" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Print</button>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light small">
                            <tr>
                                <th>Txn ID</th>
                                <th>Date</th>
                                <th>Narration</th>
                                <th>Credit ($)</th>
                                <th>Debit ($)</th>
                                <th class="text-end">Balance Amount ($)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && mysql_num_rows($result) > 0): ?>
                                <?php while ($row = mysql_fetch_array($result)): ?>
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
                                    <td colspan="6" class="text-center text-muted py-4">No records found within the selected date range.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
