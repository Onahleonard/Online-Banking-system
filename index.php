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
    <!-- Google Fonts Imports -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Lora:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bank-theme.css?v=<?php echo time(); ?>">
</head>
<body class="mt-landing-body">

<!-- FDIC & Utility Top Bar -->
<div class="mt-fdic-bar">
    <div class="mt-container mt-fdic-bar-container">
        <div class="mt-fdic-left">
            <!-- Official FDIC Shield Icon -->
            <svg class="mt-fdic-logo-shield" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            <span class="mt-fdic-text"><strong>FDIC</strong> FDIC-Insured &ndash; Backed by the full faith and credit of the U.S. Government</span>
        </div>
        <div class="mt-fdic-right">
            <div class="mt-utility-nav">
                <a href="#locations" class="mt-dropdown-toggle">
                    <svg class="mt-nav-util-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Locations <span class="mt-caret"></span>
                </a>
                <a href="#careers" class="mt-dropdown-toggle">
                    <svg class="mt-nav-util-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    Careers <span class="mt-caret"></span>
                </a>
                <a href="#contact" class="mt-dropdown-toggle">
                    <svg class="mt-nav-util-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    Contact <span class="mt-caret"></span>
                </a>
                <a href="#security" class="mt-dropdown-toggle">
                    <svg class="mt-nav-util-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Security <span class="mt-caret"></span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Navigation Header -->
<header class="mt-main-header">
    <div class="mt-container mt-header-container">
        <div class="mt-logo">
            <!-- Brand emblem logo matching mockup -->
            <svg class="mt-logo-icon" width="36" height="36" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17 2C8.71573 2 2 8.71573 2 17C2 25.2843 8.71573 32 17 32C25.2843 32 32 25.2843 32 17C32 8.71573 25.2843 2 17 2Z" fill="#B3191F"/>
                <path d="M10 24C12.5 19 15 15.5 24 13C20 16 16.5 19.5 15 24H10Z" fill="white"/>
                <path d="M14 10.5C15.5 12 18.5 14 24 13C21 11.5 18 10 14 10.5Z" fill="white"/>
            </svg>
            <h2>Meridian Trust Bank</h2>
        </div>

        <nav class="mt-main-nav" aria-label="Primary Navigation">
            <div class="mt-nav-item">
                <a href="#personal" class="mt-nav-link">Personal <span class="mt-caret"></span></a>
            </div>
            <div class="mt-nav-item">
                <a href="#business" class="mt-nav-link">Business <span class="mt-caret"></span></a>
            </div>
            <div class="mt-nav-item">
                <a href="#commercial" class="mt-nav-link">Commercial <span class="mt-caret"></span></a>
            </div>
            <div class="mt-nav-item">
                <a href="#wealth" class="mt-nav-link">Wealth <span class="mt-caret"></span></a>
            </div>
            <div class="mt-nav-item">
                <a href="#resources" class="mt-nav-link">Resources <span class="mt-caret"></span></a>
            </div>
            <div class="mt-nav-item">
                <a href="#about" class="mt-nav-link">About <span class="mt-caret"></span></a>
            </div>
        </nav>

        <div class="mt-header-buttons">
            <a href="login.php" class="mt-btn-login-red">LOGIN <span class="mt-caret-white"></span></a>
        </div>
    </div>
</header>

<!-- Hero Section with Online Banking Login Panel Overlay -->
<section class="mt-hero-section">
    <div class="mt-container mt-hero-container">
        <div class="mt-hero-content">
            <h1>Banking<br>That Moves<br><span class="mt-serif-title">Life Forward</span><span class="mt-accent-dot">.</span></h1>
            <p class="mt-hero-subtitle">For your life. For your business. For your community.</p>
            <a href="#services" class="mt-btn-primary-red">EXPLORE OUR SOLUTIONS &rarr;</a>
        </div>

        <div class="mt-login-panel">
            <div class="mt-login-panel-header">
                <div class="mt-lock-icon-container">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>
                <h3>Online Banking Login</h3>
            </div>
            <div class="mt-login-panel-body">
                <form action="login.php" method="POST">
                    <div class="mt-form-group">
                        <select name="login_type" class="mt-form-select" aria-label="Select banking account type">
                            <option value="personal">Personal Banking</option>
                            <option value="business">Business Banking</option>
                            <option value="commercial">Commercial Banking</option>
                        </select>
                    </div>
                    <button type="submit" class="mt-btn-login-submit">LOG IN</button>
                </form>
                <div class="mt-login-panel-footer">
                    <a href="login.php" class="mt-panel-footer-link">Enroll in Digital Banking <span class="mt-ext-arrow">&nearr;</span></a>
                    <a href="#security" class="mt-panel-footer-link">Security Center <span class="mt-ext-arrow">&nearr;</span></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Actions Action Bar (Dark Blue) -->
<section class="mt-action-bar">
    <div class="mt-container mt-action-bar-grid">
        <a href="login.php" class="mt-action-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3L21 7L17 11"/><path d="M3 17L7 21L3 25"/><path d="M21 7H9C5.13401 7 2 10.134 2 14v1"/><path d="M3 17H15C18.866 17 22 13.866 22 10V9"/></svg>
            <span>Wire Transfers</span>
        </a>
        <a href="login.php" class="mt-action-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            <span>Order Checks</span>
        </a>
        <a href="#mortgage" class="mt-action-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <span>Manage & Pay Mortgage</span>
        </a>
        <a href="login.php" class="mt-action-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
            <span>Open an Account</span>
        </a>
        <a href="#locations" class="mt-action-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <span>Find a Location</span>
        </a>
    </div>
</section>

<!-- Solutions Designed for You Grid (4 Premium Cards) -->
<section id="services" class="mt-solutions-section">
    <div class="mt-container">
        <h2 class="mt-section-title">Solutions Designed for You</h2>
        <div class="mt-accent-bar"></div>

        <div class="mt-solutions-grid">
            <!-- Card 1: Personal -->
            <div class="mt-solution-card" id="personal">
                <div class="mt-card-icon-wrapper">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2" ry="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                </div>
                <h3>Personal Banking</h3>
                <p>Accounts, loans and tools to help you achieve more.</p>
                <a href="login.php" class="mt-card-link">LEARN MORE &rarr;</a>
            </div>

            <!-- Card 2: Business -->
            <div class="mt-solution-card" id="business">
                <div class="mt-card-icon-wrapper">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                </div>
                <h3>Business Banking</h3>
                <p>Solutions to help your business grow and thrive.</p>
                <a href="login.php" class="mt-card-link">LEARN MORE &rarr;</a>
            </div>

            <!-- Card 3: Commercial -->
            <div class="mt-solution-card" id="commercial">
                <div class="mt-card-icon-wrapper">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="9" y1="3" x2="9" y2="21"/><line x1="15" y1="3" x2="15" y2="21"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/></svg>
                </div>
                <h3>Commercial Banking</h3>
                <p>Strategic banking for complex business needs.</p>
                <a href="login.php" class="mt-card-link">LEARN MORE &rarr;</a>
            </div>

            <!-- Card 4: Wealth Management -->
            <div class="mt-solution-card" id="wealth">
                <div class="mt-card-icon-wrapper">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                </div>
                <h3>Wealth Management</h3>
                <p>Personalized strategies to grow and protect wealth.</p>
                <a href="login.php" class="mt-card-link">LEARN MORE &rarr;</a>
            </div>
        </div>
    </div>
</section>

<!-- Entrepreneurial & Trust Split Section -->
<section class="mt-entrepreneurial-section" id="security">
    <div class="mt-container mt-entrepreneurial-grid">
        <!-- Left: Crystal Award Silhouette Graphic (Rendered dynamically) -->
        <div class="mt-award-block">
            <div class="mt-award-icon-box">
                <!-- Precision Faceted Glass Award Trophy SVG -->
                <svg width="120" height="240" viewBox="0 0 100 200" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="crystalGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#ffffff" stop-opacity="0.9"/>
                            <stop offset="30%" stop-color="#e2e8f0" stop-opacity="0.6"/>
                            <stop offset="70%" stop-color="#cbd5e1" stop-opacity="0.4"/>
                            <stop offset="100%" stop-color="#94a3b8" stop-opacity="0.8"/>
                        </linearGradient>
                    </defs>
                    <!-- Base Base -->
                    <polygon points="15,180 85,180 90,195 10,195" fill="#1e293b"/>
                    <polygon points="20,165 80,165 83,180 17,180" fill="#334155"/>
                    <!-- Crystal Body -->
                    <polygon points="50,15 80,110 65,165 35,165 20,110" fill="url(#crystalGrad)" stroke="#64748b" stroke-width="1.5"/>
                    <!-- Facet cut lines representing high quality trophy details -->
                    <line x1="50" y1="15" x2="50" y2="165" stroke="#ffffff" stroke-width="1.5" stroke-opacity="0.9"/>
                    <line x1="50" y1="15" x2="35" y2="165" stroke="#94a3b8" stroke-width="1" stroke-opacity="0.5"/>
                    <line x1="50" y1="15" x2="65" y2="165" stroke="#94a3b8" stroke-width="1" stroke-opacity="0.5"/>
                    <polygon points="50,15 38,70 50,120" fill="#ffffff" fill-opacity="0.25"/>
                    <polygon points="50,15 62,70 50,120" fill="#64748b" fill-opacity="0.1"/>
                    <polygon points="35,165 50,120 20,110" fill="#cbd5e1" fill-opacity="0.3"/>
                    <polygon points="65,165 50,120 80,110" fill="#475569" fill-opacity="0.15"/>
                </svg>
            </div>
            <span class="mt-award-label">AWARD WINNING</span>
            <h2 class="mt-award-title"><span class="mt-serif-title">Entrepreneurial. Like You.</span></h2>
            <p class="mt-award-description">
                Our Telly Award winning video gives you a quick look at how Meridian serves businesses in the Delaware Valley with an ongoing commitment to empowering entrepreneurs.
            </p>
            <a href="#watch" class="mt-btn-watch">WATCH NOW <span class="mt-play-arrow">&blacktriangleright;</span></a>
        </div>

        <!-- Right: Core Value Propositions -->
        <div class="mt-values-block">
            <div class="mt-value-item">
                <div class="mt-value-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                </div>
                <div class="mt-value-text">
                    <h4>Community Focused</h4>
                    <p>Investing in the communities where we live and work.</p>
                </div>
            </div>

            <div class="mt-value-item">
                <div class="mt-value-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div class="mt-value-text">
                    <h4>Local Decision Makers</h4>
                    <p>You'll work with local experts who know your market.</p>
                </div>
            </div>

            <div class="mt-value-item">
                <div class="mt-value-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div class="mt-value-text">
                    <h4>Committed to You</h4>
                    <p>Long-term relationships built on trust, service and results.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Unified Corporate Footer -->
<footer class="mt-footer">
    <div class="mt-container mt-footer-container">
        <div class="mt-footer-grid">
            <!-- Branding Panel -->
            <div class="mt-footer-brand">
                <div class="mt-footer-logo">
                    <svg class="mt-logo-icon" width="28" height="28" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 2C8.71573 2 2 8.71573 2 17C2 25.2843 8.71573 32 17 32C25.2843 32 32 25.2843 32 17C32 8.71573 25.2843 2 17 2Z" fill="#B3191F"/>
                        <path d="M10 24C12.5 19 15 15.5 24 13C20 16 16.5 19.5 15 24H10Z" fill="white"/>
                    </svg>
                    <h4>Meridian Trust Bank</h4>
                </div>
                <p class="mt-footer-disclaimer">
                    FDIC-Insured &ndash; Backed by the full faith and credit of the U.S. Government
                </p>
                
                <div class="mt-badge-row">
                    <div class="mt-member-fdic-badge">Member <span class="mt-bold-fdic">FDIC</span></div>
                    <div class="mt-lender-badge">
                        <svg class="mt-house-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        <span>EQUAL HOUSING LENDER</span>
                    </div>
                </div>

                <!-- Footer Social Rows -->
                <div class="mt-social-row">
                    <a href="#facebook" aria-label="Facebook"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a>
                    <a href="#linkedin" aria-label="LinkedIn"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg></a>
                    <a href="#twitter" aria-label="Twitter"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg></a>
                    <a href="#instagram" aria-label="Instagram"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
                </div>
            </div>

            <!-- Links Column 1 -->
            <div class="mt-footer-links-col">
                <h4>PERSONAL</h4>
                <ul>
                    <li><a href="#checking">Checking</a></li>
                    <li><a href="#savings">Savings</a></li>
                    <li><a href="#cds">Certificates of Deposit</a></li>
                    <li><a href="#loans">Consumer Loans</a></li>
                    <li><a href="#mortgages">Home Mortgages</a></li>
                    <li><a href="#private">Private Banking</a></li>
                    <li><a href="#wealth">Wealth</a></li>
                    <li><a href="login.php" class="mt-bold-link">Enroll in Digital Banking <span class="mt-ext-arrow">&nearr;</span></a></li>
                </ul>
            </div>

            <!-- Links Column 2 -->
            <div class="mt-footer-links-col">
                <h4>BUSINESS</h4>
                <ul>
                    <li><a href="#business-banking">Business Banking</a></li>
                    <li><a href="#business-loans">Business Loans</a></li>
                    <li><a href="#sba">SBA Loans</a></li>
                    <li><a href="#commercial-real">Commercial Real</a></li>
                    <li><a href="#estate-lending">Estate Lending</a></li>
                    <li><a href="#cash-management">Cash Management</a></li>
                    <li><a href="#equipment-finance" class="mt-bold-link">Meridian Equipment Finance <span class="mt-ext-arrow">&nearr;</span></a></li>
                    <li><a href="#title-insurance" class="mt-bold-link">Title Insurance <span class="mt-ext-arrow">&nearr;</span></a></li>
                </ul>
            </div>

            <!-- Links Column 3 -->
            <div class="mt-footer-links-col">
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
            <div class="mt-footer-links-col">
                <h4>CONTACT</h4>
                <div class="mt-contact-details">
                    <div class="mt-contact-item">
                        <svg class="mt-contact-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <a href="tel:8663279199">866.327.9199</a>
                    </div>
                    <div class="mt-contact-item">
                        <svg class="mt-contact-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <a href="mailto:info@meridiantrust.bank">info@meridiantrust.bank</a>
                    </div>
                    <div class="mt-contact-item">
                        <svg class="mt-contact-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
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
        <div class="mt-footer-center-domain">
            <span class="mt-domain-text">meridiantrust.bank</span>
        </div>

        <hr class="mt-footer-divider">

        <div class="mt-footer-bottom">
            <p class="mt-copyright">
                &copy; <?php echo date('Y'); ?> Meridian Trust Bank. All rights reserved.
            </p>
            <p class="mt-legal-notice">
                <strong>NOTICE:</strong> External links are provided for your convenience. Meridian Trust Bank does not endorse nor guarantee these links, nor the privacy or security policies of 3rd party web sites.
            </p>
        </div>
    </div>
</footer>

</body>
</html>