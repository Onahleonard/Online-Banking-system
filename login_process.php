<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
    
    // Updated with your specific credentials
    if ($email === "tnsadam247@gmail.com" && $password === "QWERTY2012") {
        $_SESSION["user"] = $email;
        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: login.php?error=invalid_credentials");
        exit();
    }
}
?>
