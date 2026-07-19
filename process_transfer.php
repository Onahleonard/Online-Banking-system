<?php
session_start();
if (!isset($_SESSION["user"])) { exit("Unauthorized"); }

$recipient = $_POST["recipient"];
$amount = $_POST["amount"];

// Placeholder for database logic
// You would add your SQL UPDATE queries here
echo "<h3>Processing...</h3><p>Transfer of $" . htmlspecialchars($amount) . " to " . htmlspecialchars($recipient) . " is being finalized.</p>
      <a href=\"dashboard.php\" class=\"btn btn-primary\">Return to Dashboard</a>";
?>
