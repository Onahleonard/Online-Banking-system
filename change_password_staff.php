<?php
session_start();
if (!isset($_SESSION['staff_login']) || !isset($_SESSION['staff_id'])) {
    header('location:staff_login.php');
    exit();
}

include '_inc/dbconn.php';

$msg = '';
$error = '';
$user = mysql_real_escape_string($_SESSION['staff_id']);

if (isset($_POST['change_password'])) {
    $sql = "SELECT * FROM staff WHERE email='$user'";
    $result = mysql_query($sql);
    $rws = mysql_fetch_array($result);

    $old = mysql_real_escape_string($_POST['old_password']);
    $new = mysql_real_escape_string($_POST['new_password']);
    $again = mysql_real_escape_string($_POST['again_password']);

    if ($rws['pwd'] === $old) {
        if ($new === $again) {
            $sql1 = "UPDATE staff SET pwd='$new' WHERE email='$user'";
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
    <title>Change Password - Staff Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light">

    <?php include 'header.php'; ?>

    <div class="container my-4">
        <div class="row">
            <div class="col-md-3 mb-4">
                <?php include 'staff_navbar.php'; ?>
            </div>
            <div class="col-md-9">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="max-width: 500px;">
                    <h1 class="h4 fw-bold text-dark mb-4 border-bottom pb-2">Change Staff Password</h1>

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

                        <button type="submit" name="change_password" class="btn btn-primary rounded-pill px-4">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
