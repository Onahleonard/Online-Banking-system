<?php
require_once "db.php";
$query = "SHOW TABLES";
$result = $conn->query($query);
if ($result) {
    echo "SUCCESS: Connected to database. Tables found: ";
    while($row = $result->fetch_array()) { echo $row[0] . ", "; }
} else {
    echo "ERROR: " . $conn->error;
}
?>
