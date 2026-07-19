<!DOCTYPE html>
<html lang='en'>
<head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body class='bg-light'>
    <div class='container mt-5'>
        <div class='card p-4 shadow-sm'>
<?php session_start(); if (!isset(\['user'])) { header('Location: ../login.php'); exit(); } ?><!DOCTYPE html>
<html lang='en'>
<head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body class='bg-light'>
    <div class='container mt-5'>
        <div class='card p-4 shadow-sm'>
<?php
session_set_cookie_params(0, '/');
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['user_id'])) { header('location:../index.php'); exit; }

include_once("../_inc/dbconn.php");
$host = '127.0.0.1'; $db = 'digital_banking'; $user = 'root'; $pass = ''; $charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$pdo = new PDO($dsn, $user, $pass);
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$userRow = $stmt->fetch();
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Corrected path to your existing CSS file -->
    <link rel="stylesheet" href="../newcss.css"> 
</head>
<body>
    <div class="wrapper">
        <?php include("dashboard_navbar.php"); ?>
        <div class="main-content">
            <h1>Welcome, <?php echo htmlspecialchars($userRow['username']); ?></h1>
            <div class="account-info">
                <p>Status: <?php echo htmlspecialchars($userRow['status']); ?></p>
            </div>
        </div>
    </div>
</body>
</html>

        </div>
    </div>
</body>
</html>


        </div>
    </div>
</body>
</html>
