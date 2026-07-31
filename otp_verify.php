<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION["customer_login"] = 1;
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Verification - Meridian Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="card p-4 shadow-sm border-0 rounded-4 bg-white" style="width: 360px;">
        <h4 class="fw-bold text-dark mb-1">Security Verification</h4>
        <p class="text-muted small mb-4">An OTP has been sent to your registered contact method.</p>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="otp" class="form-control text-center fs-5 fw-bold" placeholder="Enter OTP" required autofocus>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-semibold">Verify & Sign In</button>
        </form>
    </div>
</body>
</html>
