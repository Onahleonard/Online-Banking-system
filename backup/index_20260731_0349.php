<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meridian Trust Bank</title>

    <link rel="stylesheet" href="assets/css/bank-theme.css">
</head>

<body>

<header class="mt-header">

    <div class="mt-logo">
        <h2>Meridian Trust Bank</h2>
    </div>

    <nav>
        <a href="#">Personal</a>
        <a href="#">Business</a>
        <a href="#">Corporate</a>
        <a href="#">Security</a>
        <a href="#">Contact</a>

        <a href="customer_dashboard.php?view=login" class="mt-btn-primary">
            Customer Login
        </a>
    </nav>

</header>

<section class="hero">

    <h1>Bank With Confidence.</h1>

    <p>
        Secure personal, business and commercial banking
        designed around you.
    </p>

    <a href="customer_dashboard.php?view=login" class="mt-btn-primary">
        Online Banking Login
    </a>

</section>

<section class="services">

    <div class="service-card">
        <h3>Personal Banking</h3>
        <p>Checking, savings and credit solutions.</p>
    </div>

    <div class="service-card">
        <h3>Business Banking</h3>
        <p>Business accounts and treasury services.</p>
    </div>

    <div class="service-card">
        <h3>Commercial Banking</h3>
        <p>Corporate finance and international payments.</p>
    </div>

</section>

<footer>

    <p>
        © <?php echo date("Y"); ?>
        Meridian Trust Bank.
        All Rights Reserved.
    </p>

</footer>

</body>
</html>