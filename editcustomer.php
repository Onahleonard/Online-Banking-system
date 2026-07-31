<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header('location:adminlogin.php');
    exit();
}

include '_inc/dbconn.php';

$id = isset($_REQUEST['customer_id']) ? mysql_real_escape_string($_REQUEST['customer_id']) : '';

// Handle customer deletion request
if (isset($_REQUEST['submit2_id'])) {
    if (!empty($id)) {
        $sql_delete = "DELETE FROM customer WHERE id='$id'";
        $sql_drop = "DROP TABLE IF EXISTS passbook" . $id;
        mysql_query($sql_delete) or die(mysql_error());
        mysql_query($sql_drop) or die(mysql_error());
    }
    header('location:delete_customer.php');
    exit();
}

if (empty($id)) {
    header('location:display_customer.php');
    exit();
}

$sql = "SELECT * FROM customer WHERE id='$id'";
$result = mysql_query($sql) or die(mysql_error());
if (!$result || mysql_num_rows($result) == 0) {
    header('location:display_customer.php');
    exit();
}
$rws = mysql_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer Details - Admin Dashboard</title>
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
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h1 class="h4 fw-bold text-dark mb-4 border-bottom pb-2">Edit Customer Account #<?php echo $id; ?></h1>

                    <form action="alter_customer.php" method="POST">
                        <input type="hidden" name="current_id" value="<?php echo $id; ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Customer Name</label>
                                <input type="text" name="edit_name" value="<?php echo htmlspecialchars($rws['name']); ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Gender</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="edit_gender" value="M" <?php if ($rws['gender'] === 'M') echo 'checked'; ?>>
                                        <label class="form-check-label">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="edit_gender" value="F" <?php if ($rws['gender'] === 'F') echo 'checked'; ?>>
                                        <label class="form-check-label">Female</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Date of Birth</label>
                                <input type="date" name="edit_dob" value="<?php echo $rws['dob']; ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nominee Name</label>
                                <input type="text" name="edit_nominee" value="<?php echo htmlspecialchars($rws['nominee']); ?>" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Account Type</label>
                                <select name="edit_account" class="form-select">
                                    <option value="savings" <?php if ($rws['account'] === 'savings') echo 'selected'; ?>>Savings</option>
                                    <option value="current" <?php if ($rws['account'] === 'current') echo 'selected'; ?>>Current</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Mobile Number</label>
                                <input type="text" name="edit_mobile" value="<?php echo htmlspecialchars($rws['mobile']); ?>" class="form-control" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="edit_email" value="<?php echo htmlspecialchars($rws['email']); ?>" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Address</label>
                                <textarea name="edit_address" class="form-control" rows="2" required><?php echo htmlspecialchars($rws['address']); ?></textarea>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" name="alter_customer" class="btn btn-primary rounded-pill px-4">Update Customer Details</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
