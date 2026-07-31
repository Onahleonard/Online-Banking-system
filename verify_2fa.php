<?php
session_start();
require_once "_inc/dbconn.php";

$error = "";
$user_id = $_SESSION["customer_id"] ?? null;
$user_email = $_SESSION["customer_email"] ?? "";
$cust_name = $_SESSION["customer_name"] ?? "Valued Customer";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["verify_otp"])) {
    $entered_otp = trim($_POST["otp_code"]);
    $otp_res = mysqli_query($conn, "SELECT * FROM temp_otp WHERE user_id='$user_id' AND otp_verified=0 ORDER BY id DESC LIMIT 1");
    if ($otp_row = mysqli_fetch_array($otp_res)) {
        $created_time = strtotime($otp_row["created_at"]);
        if (time() - $created_time > 600) {
            $error = "One-Time Password (OTP) has expired. Please try logging in again.";
        } elseif ($otp_row["otp_code"] === $entered_otp) {
            mysqli_query($conn, "UPDATE temp_otp SET otp_verified=1 WHERE id='{$otp_row["id"]}'");
            $auth_code = strval(rand(100000, 999999));
            mysqli_query($conn, "UPDATE temp_otp SET auth_code='$auth_code' WHERE id='{$otp_row["id"]}'");
            $email_sim_content = "To: $user_email\nSubject: Security Authentication Code\n\nDear $cust_name,\n\nYour Security Authentication Code is: $auth_code\n\nPlease enter this code on the verification screen to complete your device registration.\n";
            file_put_contents("C:/xampp/htdocs/Online-Banking-system/_tmp_email_simulator.txt", $email_sim_content);
            $_SESSION["temp_2fa_step"] = "auth";
            $_SESSION["temp_otp_row_id"] = $otp_row["id"];
            header("location:verify_2fa.php");
            exit();
        } else {
            $error = "Invalid passcode code. Please check and try again.";
        }
    } else {
        $error = "No pending authentication tokens found. Please request a new code.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Device Verification &mdash; Meridian Bank</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Lora:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bank-theme.css">
</head>
<body class="mt-landing-body">
<div class="mt-login-backdrop">
    <div class="mt-login-card">
        <div class="mt-login-brand">
            <svg class="mt-logo-icon" width="36" height="36" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17 2C8.71573 2 2 8.71573 2 17C2 25.2843 8.71573 32 17 32C25.2843 32 32 25.2843 32 17C32 8.71573 25.2843 2 17 2Z" fill="#B3191F"/>
                <path d="M10 24C12.5 19 15 15.5 24 13C20 16 16.5 19.5 15 24H10Z" fill="white"/>
            </svg>
            <h2 class="mt-login-bank-title">Meridian Bank<span class="mt-red-dot">.</span></h2>
        </div>
        <div class="mt-passcode-header-area">
            <span class="mt-passcode-label">Enter passcode</span>
            <a href="customer_dashboard.php?view=login" class="mt-forgot-link">Forgot?</a>
        </div>
        <div class="mt-passcode-dots" id="passcode-dots">
            <span class="mt-dot"></span>
            <span class="mt-dot"></span>
            <span class="mt-dot"></span>
            <span class="mt-dot"></span>
            <span class="mt-dot"></span>
            <span class="mt-dot"></span>
        </div>
        <form method="POST" action="verify_2fa.php" id="mt-2fa-form">
            <input type="hidden" name="verify_otp" value="1" />
            <input type="hidden" name="otp_code" id="otp_code" value="" />
            <?php if ($error): ?>
                <div class="mt-login-error-msg" style="margin-bottom:16px;"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <div class="mt-keypad">
                <button type="button" class="mt-key" onclick="pressKey('1')">1</button>
                <button type="button" class="mt-key" onclick="pressKey('2')">2</button>
                <button type="button" class="mt-key" onclick="pressKey('3')">3</button>
                <button type="button" class="mt-key" onclick="pressKey('4')">4</button>
                <button type="button" class="mt-key" onclick="pressKey('5')">5</button>
                <button type="button" class="mt-key" onclick="pressKey('6')">6</button>
                <button type="button" class="mt-key" onclick="pressKey('7')">7</button>
                <button type="button" class="mt-key" onclick="pressKey('8')">8</button>
                <button type="button" class="mt-key" onclick="pressKey('9')">9</button>
                <div class="mt-key-empty"></div>
                <button type="button" class="mt-key" onclick="pressKey('0')">0</button>
                <button type="button" class="mt-key mt-key-back" onclick="pressBackspace()" aria-label="Backspace">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 4H8l-7 8 7 8h13a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2z"/><line x1="18" y1="9" x2="12" y2="15"/><line x1="12" y1="9" x2="18" y2="15"/></svg>
                </button>
            </div>
            <button type="submit" class="mt-btn-login-submit-card" style="margin-top:20px;">Verify Device</button>
        </form>
    </div>
</div>
<script>
const maxDigits = 6;
const inputField = document.getElementById('otp_code');
const dots = document.querySelectorAll('#passcode-dots .mt-dot');
function pressKey(num) {
    if (inputField.value.length < maxDigits) {
        inputField.value += num;
        updateDots();
    }
}
function pressBackspace() {
    if (inputField.value.length > 0) {
        inputField.value = inputField.value.slice(0, -1);
        updateDots();
    }
}
function updateDots() {
    const len = inputField.value.length;
    dots.forEach((dot, index) => {
        if (index < len) {
            dot.classList.add('filled');
        } else {
            dot.classList.remove('filled');
        }
    });
}
document.addEventListener('keydown', (e) => {
    if (e.key >= '0' && e.key <= '9') {
        pressKey(e.key);
    } else if (e.key === 'Backspace') {
        pressBackspace();
    } else if (e.key === 'Enter') {
        document.getElementById('mt-2fa-form').submit();
    }
});
</script>
</body>
</html>