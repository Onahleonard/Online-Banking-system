<?php
require_once "db.php";
$query = "SELECT login_id, pwd FROM admin LIMIT 1";
$result = $conn->query($query);
if ($result && $result->num_rows > 0) {
    echo "SUCCESS: Admin table is readable. Found login_id and pwd.";
} else {
    echo "ERROR: Could not read admin table.";
}
?>
