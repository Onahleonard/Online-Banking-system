<?php
session_start();
if (!isset($_SESSION['customer_login']) || !isset($_SESSION['login_id'])) {
    header('location:login.php');
    exit();
}

include '_inc/dbconn.php';

$account_no = mysql_real_escape_string($_SESSION['login_id']);
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $mobile = mysql_real_escape_string($_POST['mobile']);
    $email = mysql_real_escape_string($_POST['email']);
    $address = mysql_real_escape_string($_POST['address']);

    $update_sql = "UPDATE customer SET mobile='$mobile', email='$email', address='$address' WHERE id='$account_no'";
    if (mysql_query($update_sql)) {
        $msg = "Personal contact details updated successfully!";
    }
}

$cust_sql = "SELECT * FROM customer WHERE id='$account_no'";
$cust_res = mysql_query($cust_sql);
$customer = mysql_fetch_array($cust_res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Details - Meridian Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light">

    <?php include 'customer_navbar.php'; ?>

    <main class="container my-5" style="max-width: 800px;">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h1 class="h4 fw-bold text-dark mb-1">Personal Details & Settings</h1>
            <p class="text-muted small mb-4">View your profile details or update contact preferences.</p>

            <?php if (!empty($msg)): ?>
                <div class="alert alert-success border-0 small mb-4"><?php echo htmlspecialchars($msg); ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Full Name</label>
                        <input type="text" class="form-control bg-light" value="<?php echo htmlspecialchars($customer['name']); ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Account Number</label>
                        <input type="text" class="form-control bg-light" value="<?php echo $customer['id']; ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Date of Birth</label>
                        <input type="text" class="form-control bg-light" value="<?php echo htmlspecialchars($customer['dob']); ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Gender</label>
                        <input type="text" class="form-control bg-light" value="<?php echo $customer['gender'] === 'M' ? 'Male' : 'Female'; ?>" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Email Address</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($customer['email']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Mobile Phone</label>
                        <input type="text" name="mobile" class="form-control" value="<?php echo htmlspecialchars($customer['mobile']); ?>" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold small">Residential Address</label>
                        <textarea name="address" class="form-control" rows="2" required><?php echo htmlspecialchars($customer['address']); ?></textarea>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" name="update_profile" class="btn btn-primary rounded-pill px-4">Save Contact Changes</button>
                </div>
            </form>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.nav-profile')?.classList.add('active');
    </script>
</body>
</html>
