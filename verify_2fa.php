<!DOCTYPE html>
<html lang='en'>
<head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body class='bg-light'>
    <div class='container mt-5'>
        <div class='card p-4 shadow-sm'>
<?php
session_start();
include '_inc/dbconn.php';

if (!isset($_SESSION['temp_2fa_user_id']) || !$conn) {
    header('location:index.php?view=login');
    exit();
}

$user_id = intval($_SESSION['temp_2fa_user_id']);
$user_email = $_SESSION['temp_2fa_email'];

$stmt = mysqli_prepare($conn, "SELECT name FROM users WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$cust_res = mysqli_stmt_get_result($stmt);
$cust_row = mysqli_fetch_array($cust_res);
$cust_name = $cust_row ? $cust_row['name'] : 'Valued Customer';

$error = '';
$current_step = isset($_SESSION['temp_2fa_step']) ? $_SESSION['temp_2fa_step'] : 'otp';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['verify_otp'])) {
        $entered_otp = trim($_POST['otp_code']);
        $stmt = mysqli_prepare($conn, "SELECT * FROM temp_otp WHERE user_id=? AND otp_verified=0 ORDER BY id DESC LIMIT 1");
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $otp_res = mysqli_stmt_get_result($stmt);
        
        if ($otp_row = mysqli_fetch_array($otp_res)) {
            if ((time() - strtotime($otp_row['created_at'])) > 600) {
                $error = 'OTP expired. Please try again.';
            } elseif ($otp_row['otp_code'] === $entered_otp) {
                mysqli_query($conn, "UPDATE temp_otp SET otp_verified=1 WHERE id='" . intval($otp_row['id']) . "'");
                $auth_code = strval(rand(100000, 999999));
                mysqli_query($conn, "UPDATE temp_otp SET auth_code='$auth_code' WHERE id='" . intval($otp_row['id']) . "'");
                
                file_put_contents("C:/Users/LADY COLETTE/Online-Banking-system/_tmp_email_simulator.txt", "Code: $auth_code");
                $_SESSION['temp_2fa_step'] = 'auth';
                $_SESSION['temp_otp_row_id'] = $otp_row['id'];
                header('location:verify_2fa.php');
                exit();
            } else { $error = 'Invalid OTP.'; }
        } else { $error = 'No active request.'; }
    } elseif (isset($_POST['verify_auth'])) {
        $entered_auth = trim($_POST['auth_code']);
        $otp_row_id = intval($_SESSION['temp_otp_row_id'] ?? 0);
        $stmt = mysqli_prepare($conn, "SELECT * FROM temp_otp WHERE id=? AND otp_verified=1 AND auth_verified=0");
        mysqli_stmt_bind_param($stmt, "i", $otp_row_id);
        mysqli_stmt_execute($stmt);
        $auth_res = mysqli_stmt_get_result($stmt);
        
        if ($auth_row = mysqli_fetch_array($auth_res)) {
            if ($auth_row['auth_code'] === $entered_auth) {
                mysqli_query($conn, "UPDATE temp_otp SET auth_verified=1 WHERE id='$otp_row_id'");
                $device_token = bin2hex(random_bytes(16));
                $stmt = mysqli_prepare($conn, "INSERT INTO device_verification (user_id, device_token) VALUES (?, ?)");
                mysqli_stmt_bind_param($stmt, "is", $user_id, $device_token);
                mysqli_stmt_execute($stmt);
                
                setcookie('device_token', $device_token, time() + 31536000, '/');
                $_SESSION['customer_login'] = 1;
                $_SESSION['login_id'] = $user_id;
                header('location:index.php?view=dashboard');
                exit();
            } else { $error = 'Invalid Auth Code.'; }
        }
    }
}
?>

        </div>
    </div>
</body>
</html>
