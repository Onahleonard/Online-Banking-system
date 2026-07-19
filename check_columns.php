<?php
require_once "db.php";
$query = "DESCRIBE admin";
$result = $conn->query($query);
echo "<pre>";
while($row = $result->fetch_assoc()) {
    print_r($row);
}
echo "</pre>";
?>
