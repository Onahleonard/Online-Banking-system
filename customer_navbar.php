<nav class="navbar navbar-expand-lg bank-navbar sticky-top">
    <div class="container-fluid max-width-1200 px-3">
        <a class="navbar-brand text-white fw-bold d-flex align-items-center gap-2" href="dashboard.php">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/></svg>
            <span>MERIDIAN ONLINE</span>
        </a>
        <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#bankNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="bankNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link nav-dash" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-transfer" href="customer_transfer.php">Transfers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-payee" href="display_beneficiary.php">Beneficiaries</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-stmt" href="customer_account_statement.php">Statements</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-atm" href="customer_issue_atm.php">Cards & Cheques</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-profile" href="customer_personal_details.php">Profile</a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <a href="logout.php" class="btn btn-outline-light btn-sm px-3 rounded-pill">Sign Out</a>
            </div>
        </div>
    </div>
</nav>
