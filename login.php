<?php
session_start();
if (isset($_SESSION['customer_login'])) {
    header('location:dashboard.php');
    exit();
}
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login - Meridian Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light">

    <?php include 'header.php'; ?>

    <main class="container my-5" style="max-width: 440px;">
        <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
            <div class="text-center mb-4">
                <h1 class="h4 fw-bold text-dark mb-1">Customer Sign In</h1>
                <p class="text-muted small">Enter your registered email and password to access online banking.</p>
            </div>

            <?php if ($error === 'invalid'): ?>
                <div class="alert alert-danger border-0 small mb-3" role="alert">
                    Invalid email address or password. Please try again.
                </div>
            <?php elseif ($error === 'inactive'): ?>
                <div class="alert alert-warning border-0 small mb-3" role="alert">
                    Your account is currently inactive. Please contact customer support.
                </div>
            <?php endif; ?>

            <form action="login_process.php" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Registered Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="name@example.com" required autofocus>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold small">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" name="submitBtn" class="btn btn-primary w-100 py-2 rounded-pill fw-semibold">Sign In to Dashboard</button>
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
