<?php
require_once "db.php";
$query = "SELECT login_id, pwd FROM admin";
$result = $conn->query($query);
while($row = $result->fetch_assoc()) {
    echo "Login ID: " . $row["login_id"] . " | Password: " . $row["pwd"] . "\n";
}
?>
