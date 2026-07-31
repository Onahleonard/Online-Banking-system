<?php 
session_start();
if(!isset($_SESSION['admin_login'])) {
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
if (mysql_num_rows($cust_res) == 0) {
    echo "<script>alert('Customer not found!'); window.location='display_customer.php';</script>";
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
    $bal_sql = "SELECT amount FROM passbook".$customer_id." ORDER BY transactionid DESC LIMIT 1";
    $bal_res = mysql_query($bal_sql);
    $last_bal = 0;
    if ($bal_row = mysql_fetch_array($bal_res)) {
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
    
    $insert_sql = "INSERT INTO passbook".$customer_id." VALUES ('', '$tx_date', '$cust_name', '$cust_branch', '$cust_ifsc', '$credit', '$debit', '$new_bal', '$tx_narration')";
    if (mysql_query($insert_sql)) {
        $msg = "Transaction successfully added!";
    } else {
        $msg = "Error adding transaction: " . mysql_error();
    }
}

// Fetch all transactions
$tx_sql = "SELECT * FROM passbook".$customer_id." ORDER BY transactionid DESC";
$tx_res = mysql_query($tx_sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Manage Transactions - <?php echo htmlspecialchars($cust_name); ?></title>
        <link rel="stylesheet" href="newcss.css">
        <style>
            .displaystaff_content table, th, td {
                padding: 6px;
                border: 1px solid #2E4372;
                border-collapse: collapse;
                text-align: center;
            }
            .tx_form {
                margin: 20px auto;
                width: 50%;
                border: 1px solid #2E4372;
                padding: 15px;
                border-radius: 8px;
            }
            .tx_form td {
                padding: 5px;
                text-align: left;
            }
            .msg {
                text-align: center;
                color: green;
                font-weight: bold;
                margin: 10px;
            }
        </style>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="displaystaff_content">
            <?php include 'admin_navbar.php'; ?>
            
            <h3 style="text-align:center;color:#2E4372;"><u>Manage Transactions for <?php echo htmlspecialchars($cust_name); ?></u></h3>
            <p style="text-align:center;">Account No: <?php echo $customer_id; ?> | Email: <?php echo htmlspecialchars($customer['email']); ?></p>
            
            <?php if (!empty($msg)) echo "<div class='msg'>$msg</div>"; ?>
            
            <!-- Transaction form -->
            <form method="POST" class="tx_form">
                <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
                <table align="center" style="border:none; width: 100%;">
                    <tr>
                        <td><strong>Transaction Date:</strong></td>
                        <td><input type="date" name="tx_date" value="<?php echo date('Y-m-d'); ?>" required></td>
                    </tr>
                    <tr>
                        <td><strong>Type:</strong></td>
                        <td>
                            <input type="radio" name="tx_type" value="credit" checked> Credit (Deposit)
                            <input type="radio" name="tx_type" value="debit"> Debit (Withdrawal)
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Amount ($):</strong></td>
                        <td><input type="number" name="tx_amount" step="0.01" min="0.01" required></td>
                    </tr>
                    <tr>
                        <td><strong>Narration:</strong></td>
                        <td><input type="text" name="tx_narration" required placeholder="e.g. Wire Transfer, Cash Deposit"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:center; padding-top:10px;">
                            <input type="submit" name="add_tx" value="ADD TRANSACTION" class="addstaff_button">
                        </td>
                    </tr>
                </table>
            </form>
            
            <h3 style="text-align:center;color:#2E4372; margin-top:30px;"><u>Transaction History</u></h3>
            <table align="center" style="width:90%; margin-bottom: 30px;">
                <tr>
                    <th>Id</th>
                    <th>Date</th>
                    <th>Narration</th>
                    <th>Credit ($)</th>
                    <th>Debit ($)</th>
                    <th>Balance ($)</th>
                </tr>
                <?php while ($row = mysql_fetch_array($tx_res)) { ?>
                    <tr>
                        <td><?php echo $row[0]; ?></td>
                        <td><?php echo $row[1]; ?></td>
                        <td><?php echo htmlspecialchars($row[8]); ?></td>
                        <td><?php echo $row[5] > 0 ? '$'.number_format($row[5], 2) : '-'; ?></td>
                        <td><?php echo $row[6] > 0 ? '$'.number_format($row[6], 2) : '-'; ?></td>
                        <td><strong>$<?php echo number_format($row[7], 2); ?></strong></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>

