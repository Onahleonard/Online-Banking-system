<?php
session_start();
if (!isset($_SESSION['customer_login']) || !isset($_SESSION['login_id'])) {
    header('location:login.php');
    exit();
}

include '_inc/dbconn.php';

$account_no = mysql_real_escape_string($_SESSION['login_id']);

$mini_sql = "SELECT * FROM passbook" . $account_no . " ORDER BY transactionid DESC LIMIT 10";
$mini_res = mysql_query($mini_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Statement - Meridian Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light">

    <?php include 'customer_navbar.php'; ?>

    <main class="container my-5" style="max-width: 900px;">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h1 class="h4 fw-bold mb-1">Mini Statement</h1>
                    <p class="text-muted small mb-0">Summary of 10 most recent transactions for Account No: <strong><?php echo $account_no; ?></strong></p>
                </div>
                <button onclick="window.print()" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Print</button>
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
                        <?php if ($mini_res && mysql_num_rows($mini_res) > 0): ?>
                            <?php while ($row = mysql_fetch_array($mini_res)): ?>
                                <tr>
                                    <td><?php echo $row[1]; ?></td>
                                    <td class="fw-medium"><?php echo htmlspecialchars($row[8]); ?></td>
                                    <td class="text-success fw-semibold"><?php echo floatval($row[5]) > 0 ? '+$' . number_format($row[5], 2) : '-'; ?></td>
                                    <td class="text-danger fw-semibold"><?php echo floatval($row[6]) > 0 ? '-$' . number_format($row[6], 2) : '-'; ?></td>
                                    <td class="text-end fw-bold">$<?php echo number_format($row[7], 2); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No recent transactions recorded.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
