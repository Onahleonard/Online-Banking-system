<?php
// Preserve existing authentication and session checks
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
$customer_id = $_SESSION['customer_id'];

$message = "";
$error = "";

// Preserve existing backend transfer logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_transfer'])) {
    $from_account = mysqli_real_escape_string($conn, $_POST['from_account']);
    $to_account = mysqli_real_escape_string($conn, $_POST['to_account']);
    $amount = floatval($_POST['amount']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    if ($amount <= 0) {
        $error = "Please enter a valid transfer amount.";
    } else {
        // Fetch source balance
        $bal_check = mysqli_query($conn, "SELECT balance FROM bank_accounts WHERE account_no = '$from_account' AND customer_id = '$customer_id'");
        if ($bal_row = mysqli_fetch_assoc($bal_check)) {
            if ($bal_row['balance'] < $amount) {
                $error = "Insufficient funds for this transfer.";
            } else {
                // Execute transfer transaction
                mysqli_autocommit($conn, FALSE);
                $deduct = mysqli_query($conn, "UPDATE bank_accounts SET balance = balance - $amount WHERE account_no = '$from_account'");
                $add = mysqli_query($conn, "UPDATE bank_accounts SET balance = balance + $amount WHERE account_no = '$to_account'");
                $log_txn = mysqli_query($conn, "INSERT INTO transactions (customer_id, account_no, amount, type, description, transaction_date) VALUES ('$customer_id', '$from_account', '$amount', 'Debit', '$description', NOW())");

                if ($deduct && $add && $log_txn) {
                    mysqli_commit($conn);
                    $message = "Transfer completed successfully!";
                } else {
                    mysqli_rollback($conn);
                    $error = "Transfer failed. Please try again.";
                }
                mysqli_autocommit($conn, TRUE);
            }
        } else {
            $error = "Invalid source account selected.";
        }
    }
}

// Fetch user accounts for dropdowns
$accounts_query = mysqli_query($conn, "SELECT * FROM bank_accounts WHERE customer_id = '$customer_id'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fund Transfer - Meridian Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body>

    <?php include 'customer_navbar.php'; ?>

    <main class="bank-container" style="max-width: 720px;">
        <div class="mb-4">
            <h1 class="h3 fw-bold mb-1">Move Money</h1>
            <p class="text-muted">Transfer funds between internal accounts or external recipients.</p>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="bank-card">
            <form action="customer_transfer.php" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold">From Account</label>
                    <select name="from_account" class="bank-form-control" required>
                        <option value="">Select Source Account</option>
                        <?php 
                        if ($accounts_query && mysqli_num_rows($accounts_query) > 0) {
                            mysqli_data_seek($accounts_query, 0);
                            while ($acc = mysqli_fetch_assoc($accounts_query)) {
                                echo "<option value='".$acc['account_no']."'>".ucfirst($acc['account_type'])." (•••• ".substr($acc['account_no'], -4).") - $".number_format($acc['balance'], 2)."</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">To Account / Recipient Account Number</label>
                    <input type="text" name="to_account" class="bank-form-control" placeholder="Enter recipient account number" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Amount ($)</label>
                    <input type="number" step="0.01" name="amount" class="bank-form-control" placeholder="0.00" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Memo / Description</label>
                    <input type="text" name="description" class="bank-form-control" placeholder="e.g. Rent, Savings transfer">
                </div>

                <button type="submit" name="submit_transfer" class="bank-btn-primary w-100">
                    Complete Transfer
                </button>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.nav-transfer')?.classList.add('active');
    </script>
</body>
</html>