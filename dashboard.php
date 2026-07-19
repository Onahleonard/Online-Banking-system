<?php 
session_start();
// This is your admin-controlled status
$is_frozen = true; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .nav-bar { background-color: #0a2540; color: white; padding: 15px; }
        .account-card { background-color: #c8102e; color: white; border-radius: 12px; padding: 20px; height: 160px; }
        .transaction-scroll { max-height: 400px; overflow-y: auto; }
        .transaction-item { background: white; padding: 15px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
    </style>
</head>
<body>
    <div class="nav-bar"><strong>Meridian Bank</strong></div>
    
    <?php if ($is_frozen): ?>
        <div class="alert alert-warning text-center rounded-0 mb-0" role="alert">
            <strong>Account Restricted:</strong> Please contact support to resolve your account status.
        </div>
    <?php endif; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-6">
                <div id="accountCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active account-card">
                            <small>Checking x8829</small>
                            <h2>$5,240.00</h2>
                            <button class="btn btn-light btn-sm mt-2" data-bs-toggle="collapse" data-bs-target="#details1">View Details</button>
                            <div id="details1" class="collapse mt-2 text-white">Routing: 123456789</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="p-3 bg-white border-bottom"><strong>Recent Transactions</strong></div>
                    <div class="transaction-scroll">
                        <div class="transaction-item"><div><strong>ATM Withdrawal</strong><br><small>July 15</small></div><div>-$100.00</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($is_frozen): ?>
        <a href="support.php" class="position-fixed bottom-0 end-0 m-4 btn btn-warning rounded-circle shadow" style="width: 50px; height: 50px;">!</a>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
