<?php
session_start();
if (!isset($_SESSION['customer_login']) || !isset($_SESSION['login_id'])) {
    header('location:login.php');
    exit();
}

include '_inc/dbconn.php';

$msg = '';
$error = '';
$change = mysql_real_escape_string($_SESSION['login_id']);

if (isset($_POST['change_password'])) {
    $sql = "SELECT * FROM customer WHERE id='$change'";
    $result = mysql_query($sql);
    $rws = mysql_fetch_array($result);

    $salt = "@g26jQsG&nh*&#8v";
    $old = sha1($_POST['old_password'] . $salt);
    $new = sha1($_POST['new_password'] . $salt);
    $again = sha1($_POST['again_password'] . $salt);

    if ($rws['password'] === $old) {
        if ($new === $again) {
            $sql1 = "UPDATE customer SET password='$new' WHERE id='$change'";
            mysql_query($sql1) or die(mysql_error());
            $msg = "Password updated successfully!";
        } else {
            $error = "New passwords do not match.";
        }
    } else {
        $error = "Incorrect current password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - Meridian Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light">

    <?php include 'customer_navbar.php'; ?>

    <main class="container my-5" style="max-width: 500px;">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h1 class="h4 fw-bold text-dark mb-4 border-bottom pb-2">Change Password</h1>

            <?php if (!empty($msg)): ?>
                <div class="alert alert-success border-0 small mb-3"><?php echo htmlspecialchars($msg); ?></div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger border-0 small mb-3"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Current Password</label>
                    <input type="password" name="old_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small">New Password</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold small">Confirm New Password</label>
                    <input type="password" name="again_password" class="form-control" required>
                </div>

                <button type="submit" name="change_password" class="btn btn-primary w-100 py-2 rounded-pill fw-semibold">Save New Password</button>
            </form>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
