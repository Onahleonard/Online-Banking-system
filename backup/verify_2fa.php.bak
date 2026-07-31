<?php
session_start();
include '_inc/dbconn.php';

// Check if user is in the 2FA login transition
if (!isset($_SESSION['temp_2fa_user_id'])) {
    header('location:index.php?view=login');
    exit();
}

$user_id = intval($_SESSION['temp_2fa_user_id']);
$user_email = $_SESSION['temp_2fa_email'];

// Fetch customer name
$cust_res = mysql_query("SELECT name FROM customer WHERE id='$user_id'");
$cust_row = mysql_fetch_array($cust_res);
$cust_name = $cust_row ? $cust_row['name'] : 'Valued Customer';

$error = '';
$current_step = isset($_SESSION['temp_2fa_step']) ? $_SESSION['temp_2fa_step'] : 'otp';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['verify_otp'])) {
        $entered_otp = trim($_POST['otp_code']);
        
        // Fetch latest unverified OTP row
        $otp_res = mysql_query("SELECT * FROM temp_otp WHERE user_id='$user_id' AND otp_verified=0 ORDER BY id DESC LIMIT 1");
        if ($otp_row = mysql_fetch_array($otp_res)) {
            // Check code (with a standard 10 minute expiration check)
            $created_time = strtotime($otp_row['created_at']);
            if (time() - $created_time > 600) {
                $error = 'One-Time Password (OTP) has expired. Please try logging in again.';
            } elseif ($otp_row['otp_code'] === $entered_otp) {
                // OTP verified successfully!
                mysql_query("UPDATE temp_otp SET otp_verified=1 WHERE id='{$otp_row['id']}'");
                
                // Step B: Generate and send Security Authentication Code
                $auth_code = strval(rand(100000, 999999));
                mysql_query("UPDATE temp_otp SET auth_code='$auth_code' WHERE id='{$otp_row['id']}'");
                
                // Simulate sending email by writing to a file
                $email_sim_content = "To: $user_email\nSubject: Security Authentication Code\n\nDear $cust_name,\n\nYour Security Authentication Code is: $auth_code\n\nPlease enter this code on the verification screen to complete your device registration.\n";
                file_put_to_contents_shim("C:/Users/LADY COLETTE/Online-Banking-system/_tmp_email_simulator.txt", $email_sim_content);
                
                $_SESSION['temp_2fa_step'] = 'auth';
                $_SESSION['temp_otp_row_id'] = $otp_row['id'];
                header('location:verify_2fa.php');
                exit();
            } else {
                $error = 'Invalid OTP code. Please check and try again.';
            }
        } else {
            $error = 'No active OTP verification request found. Please login again.';
        }
    } elseif (isset($_POST['verify_auth'])) {
        $entered_auth = trim($_POST['auth_code']);
        $otp_row_id = isset($_SESSION['temp_otp_row_id']) ? intval($_SESSION['temp_otp_row_id']) : 0;
        
        $auth_res = mysql_query("SELECT * FROM temp_otp WHERE id='$otp_row_id' AND otp_verified=1 AND auth_verified=0");
        if ($auth_row = mysql_fetch_array($auth_res)) {
            $created_time = strtotime($auth_row['created_at']);
            if (time() - $created_time > 600) {
                $error = 'Authentication Code has expired. Please try logging in again.';
            } elseif ($auth_row['auth_code'] === $entered_auth) {
                // Auth code verified! Complete device approval (Step C)
                mysql_query("UPDATE temp_otp SET auth_verified=1 WHERE id='$otp_row_id'");
                
                // Generate secure device token
                $device_token = bin2hex(openssl_random_pseudo_bytes(16));
                mysql_query("INSERT INTO device_verification (user_id, device_token) VALUES ('$user_id', '$device_token')");
                
                // Set long-lived recognized device cookie (1 year)
                setcookie('device_token', $device_token, time() + (365 * 24 * 60 * 60), '/');
                
                // Log customer in fully
                $_SESSION['customer_login'] = 1;
                $_SESSION['cust_id'] = $user_email;
                $_SESSION['login_id'] = $user_id;
                $_SESSION['name'] = $cust_name;
                $_SESSION['user'] = [
                    'email' => $user_email,
                    'role' => 'customer',
                    'label' => 'Customer Portal'
                ];
                
                // Clean up transition variables
                unset($_SESSION['temp_2fa_user_id']);
                unset($_SESSION['temp_2fa_email']);
                unset($_SESSION['temp_2fa_step']);
                unset($_SESSION['temp_otp_row_id']);
                
                header('location:index.php?view=dashboard');
                exit();
            } else {
                $error = 'Invalid Security Authentication Code. Please check and try again.';
            }
        } else {
            $error = 'Verification flow state mismatch. Please start login again.';
        }
    }
}

function file_put_to_contents_shim($filepath, $content) {
    $fp = fopen($filepath, "w");
    if ($fp) {
        fwrite($fp, $content);
        fclose($fp);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identity Verification - Meridian Financial</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
      :root {
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, sans-serif;
      }
    </style>
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center p-6 text-slate-900">
    <div class="bg-white rounded-3xl shadow-xl max-w-md w-full border border-slate-200 p-8">
        <div class="flex flex-col items-center mb-6">
            <div class="w-12 h-12 bg-cyan-500 rounded-2xl flex items-center justify-center text-white text-lg font-black shadow mb-4">M</div>
            <h3 class="text-xl font-bold">Security Verification Required</h3>
            <p class="text-xs text-slate-500 text-center mt-2">
                We don't recognize the device you are using. To ensure your account is protected, we need to verify your identity.
            </p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="mb-4 rounded-xl bg-rose-50 border border-rose-200 p-3 text-sm text-rose-700">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($current_step === 'otp'): ?>
            <!-- STEP A: OTP Code Input -->
            <form method="POST" action="" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2">Step 1: Enter One-Time Password (OTP)</label>
                    <p class="text-[11px] text-slate-400 mb-3">We have sent a secure 6-digit OTP code to your registered email address.</p>
                    <input type="text" name="otp_code" required maxlength="6" pattern="\d{6}" placeholder="••••••" class="w-full text-center text-xl tracking-[0.25em] font-mono rounded-xl border border-slate-200 bg-slate-50 px-3 py-3 outline-none focus:ring-2 focus:ring-cyan-200" />
                </div>
                <button type="submit" name="verify_otp" class="w-full bg-cyan-600 hover:bg-cyan-500 text-white rounded-xl py-3 text-sm font-semibold shadow transition">Verify OTP Code</button>
            </form>
        <?php else: ?>
            <!-- STEP B: Auth Code Input -->
            <form method="POST" action="" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2">Step 2: Enter Security Authentication Code</label>
                    <p class="text-[11px] text-slate-400 mb-3">OTP verified. We have sent a secondary security clearance code to your email.</p>
                    <input type="text" name="auth_code" required maxlength="6" pattern="\d{6}" placeholder="••••••" class="w-full text-center text-xl tracking-[0.25em] font-mono rounded-xl border border-slate-200 bg-slate-50 px-3 py-3 outline-none focus:ring-2 focus:ring-cyan-200" />
                </div>
                <button type="submit" name="verify_auth" class="w-full bg-cyan-600 hover:bg-cyan-500 text-white rounded-xl py-3 text-sm font-semibold shadow transition">Approve Device &amp; Continue</button>
            </form>
        <?php endif; ?>

        <div class="mt-6 text-center text-xs border-t border-slate-100 pt-4">
            <a href="index.php?view=login" class="text-cyan-600 hover:underline">Cancel &amp; Return to Sign In</a>
        </div>
    </div>
</body>
</html>
