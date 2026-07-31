<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meridian Trust Bank</title>
    <meta name="description" content="Meridian Trust Bank offers secure personal, business, and commercial banking with modern digital tools and trusted customer support.">
    <link rel="stylesheet" href="assets/css/bank-theme.css">
</head>
<body>

<div class="fdic-bar">
    <div class="container">
        <span>FDIC Insured</span>
        <span>Equal Housing Lender</span>
        <span>24/7 Digital Banking</span>
    </div>
</div>

<header class="main-header">
    <div class="container">
        <div class="logo">
            <h2>Meridian Trust Bank</h2>
        </div>

        <nav class="main-nav" aria-label="Primary">
            <a href="#personal">Personal</a>
            <a href="#business">Business</a>
            <a href="#commercial">Commercial</a>
            <a href="#security">Security</a>
            <a href="#contact">Contact</a>
        </nav>

        <div class="header-buttons">
            <a href="login.php" class="btn-login">Sign In</a>
            <a href="#open-account" class="btn-open">Open Account</a>
        </div>
    </div>
</header>

<section class="hero mt-hero">
    <div class="container">
        <div>
            <p class="mb-1" style="text-transform:uppercase; letter-spacing:.18em; font-weight:800; color:rgba(255,255,255,.78);">
                Trusted Banking Since 1987
            </p>
            <h1>Banking Built Around Trust.</h1>
            <p>
                Secure personal, business, and commercial banking designed to help you move life forward with confidence.
            </p>

            <div class="hero-buttons">
                <a href="login.php" class="btn-primary">Online Banking Login</a>
                <a href="#services" class="btn-secondary">Explore Services</a>
            </div>

            <div class="hero-buttons" style="margin-top:14px;">
                <a href="#security" class="btn-secondary">Security Center</a>
                <a href="#contact" class="btn-secondary">Contact Us</a>
            </div>
        </div>

        <div class="hero-panel" id="open-account">
            <div class="panel-head">Secure Online Access</div>
            <div class="panel-body">
                <p>
                    Existing customers can sign in to access checking, savings, transfers, statements, and account security tools.
                </p>

                <div class="quick-actions">
                    <a href="login.php">Customer Login <span>→</span></a>
                    <a href="#personal">Personal Banking <span>→</span></a>
                    <a href="#business">Business Banking <span>→</span></a>
                    <a href="#commercial">Commercial Banking <span>→</span></a>
                </div>

                <p class="mt-3 mb-0" style="font-size:.9rem;">
                    Need help? Contact support for account access assistance.
                </p>
            </div>
        </div>
    </div>
</section>

<section id="services" class="services">
    <div class="container">
        <h2 class="section-title">Our Banking Solutions</h2>
        <p class="section-subtitle">
            Modern banking for individuals, families, entrepreneurs, and growing businesses.
        </p>

        <div class="service-grid">
            <div class="service-card" id="personal">
                <h3>Personal Banking</h3>
                <p>Checking, savings, debit cards, bill pay, and everyday account access.</p>
            </div>

            <div class="service-card" id="business">
                <h3>Business Banking</h3>
                <p>Business checking, cash management, payroll, and merchant services.</p>
            </div>

            <div class="service-card" id="commercial">
                <h3>Commercial Banking</h3>
                <p>Commercial lending, treasury solutions, and enterprise banking support.</p>
            </div>

            <div class="service-card">
                <h3>Mortgage Services</h3>
                <p>Home loans, refinancing options, and property financing solutions.</p>
            </div>

            <div class="service-card">
                <h3>Credit & Debit Cards</h3>
                <p>Card controls, spending alerts, and secure digital card management.</p>
            </div>

            <div class="service-card">
                <h3>Wealth Management</h3>
                <p>Retirement planning, investment guidance, and long-term financial strategy.</p>
            </div>
        </div>
    </div>
</section>

<section class="trust" id="security">
    <div class="container">
        <h2 class="section-title">Why Meridian Trust</h2>
        <p class="section-subtitle">
            Built with the security and reliability expected from a modern bank.
        </p>

        <div class="trust-grid">
            <div>
                <h3>256-bit Encryption</h3>
                <p>Your banking sessions and data are protected with strong encryption.</p>
            </div>
            <div>
                <h3>Fraud Monitoring</h3>
                <p>Advanced monitoring helps protect your account activity around the clock.</p>
            </div>
            <div>
                <h3>Digital Banking</h3>
                <p>Access your accounts, statements, and transfers from any device.</p>
            </div>
            <div>
                <h3>FDIC Insured</h3>
                <p>Eligible deposits are protected by federal deposit insurance.</p>
            </div>
        </div>
    </div>
</section>

<section class="news">
    <div class="container">
        <h2 class="section-title">Latest News & Insights</h2>
        <p class="section-subtitle">
            Stay informed with updates on secure banking, account protection, and financial tools.
        </p>
    </div>
</section>

<section class="products" id="contact">
    <div class="container">
        <div class="service-grid">
            <div class="product-card">
                <h3>Contact Support</h3>
                <p>Need help with login, transfers, or account access? Our support team is here to assist.</p>
            </div>

            <div class="product-card">
                <h3>Locations</h3>
                <p>Find branch and ATM information for in-person banking assistance.</p>
            </div>

            <div class="product-card">
                <h3>Security Center</h3>
                <p>Learn how to protect your account, devices, and online banking credentials.</p>
            </div>
        </div>
    </div>
</section>

<footer class="mt-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <h4>Personal</h4>
                <p>Checking</p>
                <p>Savings</p>
                <p>Cards</p>
                <p>Loans</p>
            </div>

            <div>
                <h4>Business</h4>
                <p>Business Checking</p>
                <p>Payroll</p>
                <p>Merchant Services</p>
                <p>Treasury</p>
            </div>

            <div>
                <h4>Support</h4>
                <p>Contact Us</p>
                <p>Security</p>
                <p>Locations</p>
                <p>FAQs</p>
            </div>

            <div>
                <h4>Legal</h4>
                <p>Privacy Policy</p>
                <p>Terms & Conditions</p>
                <p>Accessibility</p>
                <p>Disclosures</p>
            </div>
        </div>

        <hr>

        <p class="text-center mb-0">
            © <?php echo date('Y'); ?> Meridian Trust Bank. All Rights Reserved.
        </p>
    </div>
</footer>

</body>
</html>