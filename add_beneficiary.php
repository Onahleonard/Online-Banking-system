<?php
session_start();
if (!isset($_SESSION['customer_login'])) {
    header('location:login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Beneficiary - Meridian Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light">

    <?php include 'customer_navbar.php'; ?>

    <main class="container my-5" style="max-width: 600px;">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h1 class="h4 fw-bold text-dark mb-2">Add New Beneficiary</h1>
            <p class="text-muted small mb-4">Register a payee for future fund transfers. Requests require staff approval.</p>

            <form action="add_beneficiary_process.php" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Payee Name</label>
                    <input type="text" name="name" class="form-control" required placeholder="Full Name as per bank account">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Account Number</label>
                    <input type="text" name="account_no" class="form-control" required placeholder="Customer Account ID">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Select Branch</label>
                    <select name="branch_select" class="form-select" required>
                        <option value="KOLKATA">Kolkata</option>
                        <option value="DELHI">Delhi</option>
                        <option value="BANGALORE">Bangalore</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">IFSC Code</label>
                    <input type="text" name="ifsc_code" class="form-control" required placeholder="e.g. K421A">
                </div>

                <button type="submit" name="submitBtn" class="btn btn-primary w-100 py-2 rounded-pill fw-semibold">Submit Beneficiary Request</button>
            </form>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.nav-payee')?.classList.add('active');
    </script>
</body>
</html>
