<?php
session_start();
if (isset($_SESSION['staff_login'])) {
    header('location:staff_homepage.php');
    exit();
}

include '_inc/dbconn.php';

$error = '';
if (isset($_POST['submitBtn'])) {
    $username = mysql_real_escape_string(trim($_POST['uname']));
    $password = mysql_real_escape_string(trim($_POST['pwd']));

    $sql = "SELECT email, pwd FROM staff WHERE email='$username' AND pwd='$password'";
    $result = mysql_query($sql);

    if ($result && $rws = mysql_fetch_array($result)) {
        $_SESSION['staff_login'] = 1;
        $_SESSION['staff_id'] = $username;
        header('location:staff_homepage.php');
        exit();
    } else {
        $error = "Invalid staff email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login - Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light">

    <?php include 'header.php'; ?>

    <main class="container my-5" style="max-width: 440px;">
        <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
            <div class="text-center mb-4">
                <h1 class="h4 fw-bold text-dark mb-1">Staff Portal Login</h1>
                <p class="text-muted small">Sign in to approve payees, ATM cards, and cheque books.</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger border-0 small mb-3"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Staff Email ID</label>
                    <input type="email" name="uname" class="form-control" required autofocus placeholder="staff@onlinebank.com">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold small">Password</label>
                    <input type="password" name="pwd" class="form-control" required placeholder="••••••••">
                </div>

                <button type="submit" name="submitBtn" class="btn btn-success w-100 py-2 rounded-pill fw-semibold">Sign In to Staff Portal</button>
            </form>

            <div class="text-center mt-4 pt-3 border-top">
                <a href="index.php" class="text-decoration-none small text-muted">← Back to Home Page</a>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
