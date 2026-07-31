<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '_inc/dbconn.php';

if (isset($_SESSION['login_id'])) {
    $date = date('Y-m-d H:i:s');
    $id = mysql_real_escape_string($_SESSION['login_id']);
    mysql_query("UPDATE customer SET lastlogin='$date' WHERE id='$id'");
}

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();
header("location:index.php");
exit();
?>
