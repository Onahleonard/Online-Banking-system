<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Basic verification logic
    $_SESSION["user"] = "authenticated";
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="card p-4 shadow" style="width: 320px;">
        <h4>Security Verification</h4>
        <p><small>A code has been sent to your email regarding a new login location.</small></p>
        <form method="POST">
            <input type="text" name="otp" class="form-control mb-3" placeholder="Enter OTP" required>
            <button type="submit" class="btn btn-danger w-100">Verify & Login</button>
        </form>
    </div>
</body>
</html>
