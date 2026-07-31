<?php
session_start();
if (isset($_SESSION['customer_login'])) {
    header('location:dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meridian Online Bank - Modern Financial Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #0a2540 0%, #1a365d 100%);
            color: #ffffff;
            padding: 90px 0;
            border-radius: 0 0 24px 24px;
        }
        .portal-card {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            transition: transform 0.2s ease, shadow 0.2s ease;
        }
        .portal-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body class="bg-light">

    <?php include 'header.php'; ?>

    <section class="hero-section text-center">
        <div class="container max-width-1200">
            <h1 class="display-4 fw-bold mb-3">Banking, Simplified & Secured.</h1>
            <p class="lead text-light opacity-75 mb-4 max-w-2xl mx-auto">Access premium banking services, instant fund transfers, and personal account management anytime, anywhere.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="login.php" class="btn btn-primary btn-lg px-4 rounded-pill">Customer Sign In</a>
                <a href="features.php" class="btn btn-outline-light btn-lg px-4 rounded-pill">Explore Features</a>
            </div>
        </div>
    </section>

    <main class="container my-5 max-width-1200">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card portal-card p-4 h-100 bg-white">
                    <div class="mb-3 text-primary">
                        <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Customer Portal</h3>
                    <p class="text-muted small mb-4">Manage accounts, view passbooks, transfer funds, and request debit cards.</p>
                    <a href="login.php" class="btn btn-outline-primary mt-auto rounded-pill">Access Account →</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card portal-card p-4 h-100 bg-white">
                    <div class="mb-3 text-success">
                        <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-3-3.87"></path><path d="M7 23l-4-4 4-4"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Staff Portal</h3>
                    <p class="text-muted small mb-4">Review pending beneficiary approvals, ATM issues, and cheque book requests.</p>
                    <a href="staff_login.php" class="btn btn-outline-success mt-auto rounded-pill">Staff Login →</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card portal-card p-4 h-100 bg-white">
                    <div class="mb-3 text-danger">
                        <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Admin Portal</h3>
                    <p class="text-muted small mb-4">Administrative management of customers, staff, passbook entries, and branch settings.</p>
                    <a href="adminlogin.php" class="btn btn-outline-danger mt-auto rounded-pill">Admin Login →</a>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
