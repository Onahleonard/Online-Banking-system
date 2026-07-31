<?php
session_start();
include '_inc/dbconn.php';

if (!isset($_SESSION['temp_2fa_user_id'])) {
    header('location:index.php');
    exit();
}

$user_id = intval($_SESSION['temp_2fa_user_id']);
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['verify_otp'])) {
        $entered_otp = trim($_POST['otp_code']);
        $sql = "SELECT * FROM temp_otp WHERE user_id='$user_id' AND otp_verified=0 ORDER BY id DESC LIMIT 1";
        $res = mysql_query($sql);

        if ($res && $otp_row = mysql_fetch_array($res)) {
            if ($otp_row['otp_code'] === $entered_otp) {
                $otp_id = $otp_row['id'];
                mysql_query("UPDATE temp_otp SET otp_verified=1 WHERE id='$otp_id'");

                $device_token = bin2hex(random_bytes(16));
                mysql_query("INSERT INTO device_verification (user_id, device_token) VALUES ('$user_id', '$device_token')");
                setcookie('device_token', $device_token, time() + 31536000, '/');

                $_SESSION['customer_login'] = 1;
                $_SESSION['login_id'] = $user_id;

                header('location:dashboard.php');
                exit();
            } else {
                $error = 'Invalid OTP code entered.';
            }
        } else {
            $error = 'No active verification request found.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA Verification - Meridian Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="card p-4 shadow-sm border-0 rounded-4 bg-white" style="width: 380px;">
        <h4 class="fw-bold text-dark mb-1">Two-Factor Authentication</h4>
        <p class="text-muted small mb-3">Please enter the security verification OTP sent to your account.</p>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger border-0 small mb-3"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <input type="text" name="otp_code" class="form-control text-center fs-5 fw-bold" placeholder="6-Digit Code" required autofocus>
            </div>
            <button type="submit" name="verify_otp" class="btn btn-primary w-100 py-2 rounded-pill fw-semibold">Authorize Device & Sign In</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
