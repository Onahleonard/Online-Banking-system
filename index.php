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
    <!-- Google Fonts import for identical typography matching -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Lora:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bank-theme.css">
</head>
<body>

<!-- FDIC & Utility Top Bar -->
<div class="fdic-bar">
    <div class="container fdic-bar-container">
        <div class="fdic-left">
            <!-- FDIC Shield Logo -->
            <svg class="fdic-logo-shield" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            <span class="fdic-text"><strong>FDIC</strong> FDIC-Insured &ndash; Backed by the full faith and credit of the U.S. Government</span>
        </div>
        <div class="fdic-right">
            <div class="utility-nav">
                <a href="#locations" class="dropdown-toggle">
                    <svg class="nav-util-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Locations <span class="caret"></span>
                </a>
                <a href="#careers" class="dropdown-toggle">
                    <svg class="nav-util-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    Careers <span class="caret"></span>
                </a>
                <a href="#contact" class="dropdown-toggle">
                    <svg class="nav-util-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    Contact <span class="caret"></span>
                </a>
                <a href="#security" class="dropdown-toggle">
                    <svg class="nav-util-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Security <span class="caret"></span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Navigation Header -->
<header class="main-header">
    <div class="container header-container">
        <div class="logo">
            <!-- Precise curved brand seal logo matching mockup -->
            <svg class="logo-icon" width="36" height="36" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17 2C8.71573 2 2 8.71573 2 17C2 25.2843 8.71573 32 17 32C25.2843 32 32 25.2843 32 17C32 8.71573 25.2843 2 17 2Z" fill="#B3191F"/>
                <path d="M10 24C12.5 19 15 15.5 24 13C20 16 16.5 19.5 15 24H10Z" fill="white"/>
                <path d="M14 10.5C15.5 12 18.5 14 24 13C21 11.5 18 10 14 10.5Z" fill="white"/>
            </svg>
            <h2>Meridian Trust Bank</h2>
        </div>

        <nav class="main-nav" aria-label="Primary Navigation">
            <div class="nav-item">
                <a href="#personal" class="nav-link">Personal <span class="caret"></span></a>
            </div>
            <div class="nav-item">
                <a href="#business" class="nav-link">Business <span class="caret"></span></a>
            </div>
            <div class="nav-item">
                <a href="#commercial" class="nav-link">Commercial <span class="caret"></span></a>
            </div>
            <div class="nav-item">
                <a href="#wealth" class="nav-link">Wealth <span class="caret"></span></a>
            </div>
            <div class="nav-item">
                <a href="#resources" class="nav-link">Resources <span class="caret"></span></a>
            </div>
            <div class="nav-item">
                <a href="#about" class="nav-link">About <span class="caret"></span></a>
            </div>
        </nav>

        <div class="header-buttons">
            <a href="login.php" class="btn-login-red">LOGIN <span class="caret-white"></span></a>
        </div>
    </div>
</header>

<!-- Hero Section with Overlapping Online Banking Login Card -->
<section class="hero-section">
    <div class="container hero-container">
        <div class="hero-content">
            <h1>Banking<br>That Moves<br><span class="serif-title">Life Forward</span><span class="accent-dot">.</span></h1>
            <p class="hero-subtitle">For your life. For your business. For your community.</p>
            <a href="#services" class="btn-primary-red">EXPLORE OUR SOLUTIONS &rarr;</a>
        </div>

        <!-- Floating Login Form Widget -->
        <div class="login-panel">
            <div class="login-panel-header">
                <div class="lock-icon-container">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>
                <h3>Online Banking Login</h3>
            </div>
            <div class="login-panel-body">
                <form action="login.php" method="POST">
                    <div class="form-group">
                        <select name="login_type" class="form-select" aria-label="Select banking account type">
                            <option value="personal">Personal Banking</option>
                            <option value="business">Business Banking</option>
                            <option value="commercial">Commercial Banking</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-login-submit">LOG IN</button>
                </form>
                <div class="login-panel-footer">
                    <a href="login.php" class="panel-footer-link">Enroll in Digital Banking <span class="ext-arrow">&nearr;</span></a>
                    <a href="#security" class="panel-footer-link">Security Center <span class="ext-arrow">&nearr;</span></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dark Blue Action Quick Links Bar -->
<section class="action-bar">
    <div class="container action-bar-grid">
        <a href="login.php" class="action-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3L21 7L17 11"/><path d="M3 17L7 21L3 25"/><path d="M21 7H9C5.13401 7 2 10.134 2 14v1"/><path d="M3 17H15C18.866 17 22 13.866 22 10V9"/></svg>
            <span>Wire Transfers</span>
        </a>
        <a href="login.php" class="action-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            <span>Order Checks</span>
        </a>
        <a href="#mortgage" class="action-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <span>Manage & Pay Mortgage</span>
        </a>
        <a href="login.php" class="action-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
            <span>Open an Account</span>
        </a>
        <a href="#locations" class="action-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <span>Find a Location</span>
        </a>
    </div>
</section>

<!-- Solutions Designed for You Grid (4 Premium Cards) -->
<section id="services" class="solutions-section">
    <div class="container">
        <h2 class="section-title">Solutions Designed for You</h2>
        <div class="accent-bar"></div>

        <div class="solutions-grid">
            <!-- Card 1: Personal -->
            <div class="solution-card" id="personal">
                <div class="card-icon-wrapper">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2" ry="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                </div>
                <h3>Personal Banking</h3>
                <p>Accounts, loans and tools to help you achieve more.</p>
                <a href="login.php" class="card-link">LEARN MORE &rarr;</a>
            </div>

            <!-- Card 2: Business -->
            <div class="solution-card" id="business">
                <div class="card-icon-wrapper">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                </div>
                <h3>Business Banking</h3>
                <p>Solutions to help your business grow and thrive.</p>
                <a href="login.php" class="card-link">LEARN MORE &rarr;</a>
            </div>

            <!-- Card 3: Commercial -->
            <div class="solution-card" id="commercial">
                <div class="card-icon-wrapper">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="9" y1="3" x2="9" y2="21"/><line x1="15" y1="3" x2="15" y2="21"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/></svg>
                </div>
                <h3>Commercial Banking</h3>
                <p>Strategic banking for complex business needs.</p>
                <a href="login.php" class="card-link">LEARN MORE &rarr;</a>
            </div>

            <!-- Card 4: Wealth Management -->
            <div class="solution-card" id="wealth">
                <div class="card-icon-wrapper">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                </div>
                <h3>Wealth Management</h3>
                <p>Personalized strategies to grow and protect wealth.</p>
                <a href="login.php" class="card-link">LEARN MORE &rarr;</a>
            </div>
        </div>
    </div>
</section>

<!-- Entrepreneurial & Trust Split Section -->
<section class="entrepreneurial-section" id="security">
    <div class="container entrepreneurial-grid">
        <!-- Left: Image/Award/Video CTA -->
        <div class="award-block">
            <div class="award-icon-box">
                <!-- 3D style trophy SVG matching award crystal in mockup -->
                <svg width="110" height="110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                    <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                    <path d="M4 22h16"></path>
                    <path d="M10 14.66V17c0 .55-.45 1-1 1H4v2h16v-2h-5c-.55 0-1-.45-1-1v-2.34"></path>
                    <path d="M12 2a4 4 0 0 0-4 4v8a4 4 0 0 0 8 0V6a4 4 0 0 0-4-4z"></path>
                </svg>
            </div>
            <span class="award-label">AWARD WINNING</span>
            <h2 class="award-title"><span class="serif-title">Entrepreneurial. Like You.</span></h2>
            <p class="award-description">
                Our Telly Award winning video gives you a quick look at how Meridian serves businesses in the Delaware Valley with an ongoing commitment to empowering entrepreneurs.
            </p>
            <a href="#watch" class="btn-watch">WATCH NOW <span class="play-arrow">&blacktriangleright;</span></a>
        </div>

        <!-- Right: Core Value Propositions -->
        <div class="values-block">
            <div class="value-item">
                <div class="value-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                </div>
                <div class="value-text">
                    <h4>Community Focused</h4>
                    <p>Investing in the communities where we live and work.</p>
                </div>
            </div>

            <div class="value-item">
                <div class="value-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div class="value-text">
                    <h4>Local Decision Makers</h4>
                    <p>You'll work with local experts who know your market.</p>
                </div>
            </div>

            <div class="value-item">
                <div class="value-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div class="value-text">
                    <h4>Committed to You</h4>
                    <p>Long-term relationships built on trust, service and results.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Unified Corporate Footer -->
<footer class="mt-footer">
    <div class="container footer-container">
        <div class="footer-grid">
            <!-- Branding Panel -->
            <div class="footer-brand">
                <div class="footer-logo">
                    <svg class="logo-icon" width="28" height="28" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 2C8.71573 2 2 8.71573 2 17C2 25.2843 8.71573 32 17 32C25.2843 32 32 25.2843 32 17C32 8.71573 25.2843 2 17 2Z" fill="#B3191F"/>
                        <path d="M10 24C12.5 19 15 15.5 24 13C20 16 16.5 19.5 15 24H10Z" fill="white"/>
                    </svg>
                    <h4>Meridian Trust Bank</h4>
                </div>
                <p class="footer-disclaimer">
                    FDIC-Insured &ndash; Backed by the full faith and credit of the U.S. Government
                </p>
                
                <div class="badge-row">
                    <div class="member-fdic-badge">Member <span class="bold-fdic">FDIC</span></div>
                    <div class="lender-badge">
                        <svg class="house-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        <span>EQUAL HOUSING LENDER</span>
                    </div>
                </div>

                <!-- Footer Social Rows -->
                <div class="social-row">
                    <a href="#facebook" aria-label="Facebook"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a>
                    <a href="#linkedin" aria-label="LinkedIn"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg></a>
                    <a href="#twitter" aria-label="Twitter"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg></a>
                    <a href="#instagram" aria-label="Instagram"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
                </div>
            </div>

            <!-- Links Column 1 -->
            <div class="footer-links-col">
                <h4>PERSONAL</h4>
                <ul>
                    <li><a href="#checking">Checking</a></li>
                    <li><a href="#savings">Savings</a></li>
                    <li><a href="#cds">Certificates of Deposit</a></li>
                    <li><a href="#loans">Consumer Loans</a></li>
                    <li><a href="#mortgages">Home Mortgages</a></li>
                    <li><a href="#private">Private Banking</a></li>
                    <li><a href="#wealth">Wealth</a></li>
                    <li><a href="login.php" class="bold-link">Enroll in Digital Banking <span class="ext-arrow">&nearr;</span></a></li>
                </ul>
            </div>

            <!-- Links Column 2 -->
            <div class="footer-links-col">
                <h4>BUSINESS</h4>
                <ul>
                    <li><a href="#business-banking">Business Banking</a></li>
                    <li><a href="#business-loans">Business Loans</a></li>
                    <li><a href="#sba">SBA Loans</a></li>
                    <li><a href="#commercial-real">Commercial Real</a></li>
                    <li><a href="#estate-lending">Estate Lending</a></li>
                    <li><a href="#cash-management">Cash Management</a></li>
                    <li><a href="#equipment-finance" class="bold-link">Meridian Equipment Finance <span class="ext-arrow">&nearr;</span></a></li>
                    <li><a href="#title-insurance" class="bold-link">Title Insurance <span class="ext-arrow">&nearr;</span></a></li>
                </ul>
            </div>

            <!-- Links Column 3 -->
            <div class="footer-links-col">
                <h4>RESOURCES</h4>
                <ul>
                    <li><a href="#locations">Locations</a></li>
                    <li><a href="login.php">Wire Transfers</a></li>
                    <li><a href="login.php">Order Checks</a></li>
                    <li><a href="#mortgage">Manage and Pay Mortgage</a></li>
                    <li><a href="#faqs">FAQs</a></li>
                    <li><a href="#resource-center">Resource Center</a></li>
                    <li><a href="#security">Security & Privacy</a></li>
                </ul>
            </div>

            <!-- Links Column 4 (Contact) -->
            <div class="footer-links-col">
                <h4>CONTACT</h4>
                <div class="contact-details">
                    <div class="contact-item">
                        <svg class="contact-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <a href="tel:8663279199">866.327.9199</a>
                    </div>
                    <div class="contact-item">
                        <svg class="contact-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <a href="mailto:info@meridiantrust.bank">info@meridiantrust.bank</a>
                    </div>
                    <div class="contact-item">
                        <svg class="contact-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <address>
                            <strong>Headquarters</strong><br>
                            8505 Painter Avenue<br>
                            Wharton, NJ 07885
                        </address>
                    </div>
                </div>
            </div>
        </div>

        <!-- Center capsule brand logo link -->
        <div class="footer-center-domain">
            <span class="domain-text">meridiantrust.bank</span>
        </div>

        <hr class="footer-divider">

        <div class="footer-bottom">
            <p class="copyright">
                &copy; <?php echo date('Y'); ?> Meridian Trust Bank. All rights reserved.
            </p>
            <p class="legal-notice">
                <strong>NOTICE:</strong> External links are provided for your convenience. Meridian Trust Bank does not endorse nor guarantee these links, nor the privacy or security policies of 3rd party web sites.
            </p>
        </div>
    </div>
</footer>

</body>
</html>