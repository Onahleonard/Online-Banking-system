<?php
session_start();
if (isset($_SESSION['admin_login'])) {
    header('location:admin_hompage.php');
    exit();
}

include '_inc/dbconn.php';

$error = '';
if (isset($_POST['submitBtn'])) {
    $username = mysql_real_escape_string(trim($_POST['uname']));
    $password = mysql_real_escape_string(trim($_POST['pwd']));

    $sql = "SELECT * FROM admin WHERE id='1'";
    $result = mysql_query($sql);
    if ($result && $rws = mysql_fetch_array($result)) {
        if ($username === $rws['login_id'] && $password === $rws['pwd']) {
            $_SESSION['admin_login'] = 1;
            header('location:admin_hompage.php');
            exit();
        } else {
            $error = "Invalid administrator username or password.";
        }
    } else {
        $error = "Admin configuration record not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light">

    <?php include 'header.php'; ?>

    <main class="container my-5" style="max-width: 440px;">
        <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
            <div class="text-center mb-4">
                <h1 class="h4 fw-bold text-dark mb-1">Administrative Login</h1>
                <p class="text-muted small">Sign in to control platform accounts, staff, and settings.</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger border-0 small mb-3"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Admin Username</label>
                    <input type="text" name="uname" class="form-control" required autofocus>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold small">Password</label>
                    <input type="password" name="pwd" class="form-control" required>
                </div>

                <button type="submit" name="submitBtn" class="btn btn-danger w-100 py-2 rounded-pill fw-semibold">Sign In as Administrator</button>
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
