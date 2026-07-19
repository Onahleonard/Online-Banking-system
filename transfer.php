<?php session_start(); if (!isset($_SESSION["user"])) { header("Location: login.php"); exit(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background-color: #f4f6f9; }</style>
</head>
<body class="p-4">
    <div class="container" style="max-width: 400px;">
        <div class="card p-4 shadow-sm">
            <h4 class="mb-4">Make a Transfer</h4>
            <form action="process_transfer.php" method="POST">
                <div class="mb-3">
                    <label>Recipient Account</label>
                    <input type="text" name="recipient" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Amount ($)</label>
                    <input type="number" name="amount" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-danger w-100">Confirm Transfer</button>
            </form>
            <a href="dashboard.php" class="btn btn-link w-100 mt-2">Cancel</a>
        </div>
    </div>
</body>
</html>
