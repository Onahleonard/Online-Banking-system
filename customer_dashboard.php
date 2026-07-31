<?php
session_start();
require_once "_inc/dbconn.php";

// -----------------------------------------------------------------------------
// Mock transaction data for demo mode
// -----------------------------------------------------------------------------
function initMockLedger(): void
{
    if (!isset($_SESSION["mock_balance"])) {
        // Corporate Checking available balance
        $_SESSION["mock_balance"] = 5450.00;
    }

    if (!isset($_SESSION["savings_balance"])) {
        // Premium Savings balance
        $_SESSION["savings_balance"] = 1200000.00;
    }

    if (!isset($_SESSION["mock_transactions"])) {
        // Seed a realistic demo ledger separated by account: 'savings' and 'checking'
        $_SESSION["mock_transactions"] = [
            // Savings account history (credits)
            ["id" => 100001, "account" => "savings", "recipient" => "Inbound Wire / Structural Engineering Infrastructure Contract", "amount" => 250000.00, "status" => "APPROVED", "date" => "07/12/2025", "narration" => "Phase 1 settlement"],
            ["id" => 100002, "account" => "savings", "recipient" => "Milestone Draw / Logistics Grid Procurement", "amount" => 180000.00, "status" => "APPROVED", "date" => "09/03/2025", "narration" => "Milestone 2"],
            ["id" => 100003, "account" => "savings", "recipient" => "Inbound Wire / Renewable Systems Deployment", "amount" => 320000.00, "status" => "APPROVED", "date" => "12/20/2025", "narration" => "Final tranche"],
            ["id" => 100004, "account" => "savings", "recipient" => "Corporate Settlement / International Commodity Sale", "amount" => 150000.00, "status" => "APPROVED", "date" => "02/14/2026", "narration" => "Settlement"],
            ["id" => 100005, "account" => "savings", "recipient" => "Milestone Draw / Logistics Grid Procurement", "amount" => 30000.00, "status" => "APPROVED", "date" => "05/17/2026", "narration" => "Retention release"],

            // Checking account history (debits)
            ["id" => 200001, "account" => "checking", "recipient" => "Vendor Payment / City Utilities Invoice", "amount" => 420.75, "status" => "APPROVED", "date" => "06/06/2026", "narration" => "Utilities - May"],
            ["id" => 200002, "account" => "checking", "recipient" => "Administrative Clearing Fee / Payroll Batch", "amount" => 1250.00, "status" => "APPROVED", "date" => "06/10/2026", "narration" => "Batch fee"],
            ["id" => 200003, "account" => "checking", "recipient" => "Office Supplies / Regional Ops", "amount" => 89.99, "status" => "APPROVED", "date" => "06/15/2026", "narration" => "Procurement"],
            ["id" => 200004, "account" => "checking", "recipient" => "Vendor Payment / Fleet Services", "amount" => 670.00, "status" => "PENDING", "date" => "06/18/2026", "narration" => "Service invoice"],
        ];
    }
}

initMockLedger();

// Default account status for customer profiles
if (!isset($_SESSION['account_status'])) {
    $_SESSION['account_status'] = 'ACTIVE'; // or 'FROZEN'
}

// -----------------------------------------------------------------------------
// Simple credential store (demo only)
// -----------------------------------------------------------------------------
$users = [
    "user@bank.com"  => ["password" => "UserPass123", "role" => "customer", "label" => "Customer Portal"],
    "admin@bank.com" => ["password" => "AdminPass123", "role" => "admin", "label" => "Administrative Console"],
];

function currentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

function requireRole(string $role): void
{
    $user = currentUser();
    if (!$user || $user['role'] !== $role) {
        header('Location: customer_dashboard.php?view=login');
        exit();
    }
}

function addFlash(string $message): void
{
    $_SESSION['flash_message'] = $message;
}

function consumeFlash(): ?string
{
    if (isset($_SESSION['flash_message'])) {
        $msg = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $msg;
    }
    return null;
}

function getTransactions(): array
{
    global $conn;
    if ($conn) {
        $txs = [];
        
        // If user is admin, return all pending transfers
        if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') {
            $res = mysql_query("SELECT * FROM pending_transfers ORDER BY id DESC");
            while ($res && $row = mysql_fetch_array($res)) {
                $txs[] = [
                    'id' => intval($row['id']),
                    'account' => 'checking',
                    'recipient' => htmlspecialchars($row['reciever_name']) . " (from " . htmlspecialchars($row['sender_name']) . ")",
                    'amount' => floatval($row['amount']),
                    'status' => htmlspecialchars($row['status']),
                    'date' => date('m/d/Y', strtotime($row['date'])),
                    'narration' => htmlspecialchars($row['narration'])
                ];
            }
            return $txs;
        }
        
        // Otherwise return client's transactions
        if (isset($_SESSION['login_id'])) {
            $cust_id = intval($_SESSION['login_id']);
            $res = mysql_query("SELECT * FROM passbook" . $cust_id . " ORDER BY transactionid DESC");
            while ($res && $row = mysql_fetch_array($res)) {
                $txs[] = [
                    'id' => intval($row[0]),
                    'account' => 'checking',
                    'recipient' => ($row[5] > 0) ? htmlspecialchars($row[8]) : "To " . htmlspecialchars($row[8]),
                    'amount' => ($row[5] > 0) ? floatval($row[5]) : floatval($row[6]),
                    'status' => 'APPROVED',
                    'date' => date('m/d/Y', strtotime($row[1])),
                    'narration' => htmlspecialchars($row[8])
                ];
            }
            
            $pres = mysql_query("SELECT * FROM pending_transfers WHERE sender_id='$cust_id' ORDER BY id DESC");
            while ($pres && $row = mysql_fetch_array($pres)) {
                $txs[] = [
                    'id' => intval($row['id']),
                    'account' => 'checking',
                    'recipient' => "To " . htmlspecialchars($row['reciever_name']),
                    'amount' => floatval($row['amount']),
                    'status' => htmlspecialchars($row['status']),
                    'date' => date('m/d/Y', strtotime($row['date'])),
                    'narration' => htmlspecialchars($row['narration'])
                ];
            }
            return $txs;
        }
    }
    return isset($_SESSION['mock_transactions']) ? $_SESSION['mock_transactions'] : [];
}

function setTransactions(array $transactions): void
{
    $_SESSION['mock_transactions'] = $transactions;
}

function createTransaction(string $recipient, float $amount): void
{
    $transactions = getTransactions();
    array_unshift($transactions, [
        'id' => time() + rand(1, 999),
        'recipient' => $recipient,
        'amount' => $amount,
        'status' => 'PENDING',
        'date' => date('m/d/Y'),
    ]);
    setTransactions($transactions);
}

function updateTransactionStatus(int $txId, string $status): void
{
    $transactions = getTransactions();
    foreach ($transactions as &$tx) {
        if ($tx['id'] === $txId && $tx['status'] === 'PENDING') {
            $tx['status'] = $status;
            if ($status === 'APPROVED') {
                $_SESSION['mock_balance'] -= $tx['amount'];
            }
            break;
        }
    }
    setTransactions($transactions);
}

function jsonResponse($payload): void
{
    header('Content-Type: application/json');
    echo json_encode($payload);
    exit();
}

// -----------------------------------------------------------------------------
// Handle form actions & API endpoints
// -----------------------------------------------------------------------------
$view = $_GET['view'] ?? 'landing';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'login') {
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = trim($_POST['password'] ?? '');

        if (isset($users[$email]) && $users[$email]['password'] === $password) {
            $_SESSION['user'] = [
                'email' => $email,
                'role' => $users[$email]['role'],
                'label' => $users[$email]['label'],
            ];
            $redirect = $users[$email]['role'] === 'admin' ? 'admin' : 'dashboard';
            header("Location: customer_dashboard.php?view=$redirect");
            exit();
        }

        $_SESSION['login_error'] = 'Invalid credentials. Use user@bank.com / UserPass123 or admin@bank.com / AdminPass123';
        header('Location: customer_dashboard.php?view=login');
        exit();
    }

    if ($action === 'logout') {
        session_destroy();
        header('Location: index.php');
        exit();
    }

    if ($action === 'transfer') {
        requireRole('customer');
        $amount = floatval($_POST['amount'] ?? 0);
        $recipient = trim(htmlspecialchars($_POST['recipient'] ?? ''));

        if ($amount > 0 && $amount <= $_SESSION['mock_balance'] && $recipient !== '') {
            createTransaction($recipient, $amount);
            addFlash('Transfer queued successfully. Awaiting administrative approval.');
        } else {
            addFlash('Error: Enter a valid recipient and amount not exceeding your available balance.');
        }

        header('Location: customer_dashboard.php?view=dashboard');
        exit();
    }

    if ($action === 'admin_decision') {
        requireRole('admin');
        $txId = intval($_POST['tx_id'] ?? 0);
        $decision = $_POST['decision'] === 'APPROVED' ? 'APPROVED' : 'REJECTED';
        updateTransactionStatus($txId, $decision);
        addFlash('Transaction status updated to ' . $decision . '.');
        header('Location: customer_dashboard.php?view=admin');
        exit();
    }

    if ($action === 'set_account_status') {
        requireRole('admin');
        $newStatus = strtoupper(trim($_POST['status'] ?? 'ACTIVE')) === 'FROZEN' ? 'FROZEN' : 'ACTIVE';
        $_SESSION['account_status'] = $newStatus;
        addFlash('Account status set to ' . $newStatus . '.');
        header('Location: customer_dashboard.php?view=admin');
        exit();
    }

    if ($action === 'admin_inject') {
        requireRole('admin');
        $inj_recipient = trim(htmlspecialchars($_POST['inj_recipient'] ?? ''));
        $inj_date = trim(htmlspecialchars($_POST['inj_date'] ?? date('m/d/Y')));
        $inj_amount = floatval($_POST['inj_amount'] ?? 0);
        if ($inj_recipient !== '' && $inj_amount > 0) {
            $transactions = getTransactions();
            // Push to the end to represent older historic entry
            $transactions[] = [
                'id' => time() - rand(10000, 99999),
                'recipient' => $inj_recipient,
                'amount' => $inj_amount,
                'status' => 'APPROVED',
                'date' => $inj_date,
            ];
            setTransactions($transactions);
            addFlash('Historic ledger item injected.');
        } else {
            addFlash('Injection failed: provide recipient and positive amount.');
        }
        header('Location: customer_dashboard.php?view=admin');
        exit();
    }
}

if (isset($_GET['api']) && $_GET['api'] === 'dashboard') {
    jsonResponse([
        'checking_balance' => number_format($_SESSION['mock_balance'], 2, '.', ''),
        'savings_balance' => number_format($_SESSION['savings_balance'] ?? 0, 2, '.', ''),
        'transactions' => getTransactions(),
    ]);
}

if ($view === 'logout') {
    session_destroy();
    header('Location: index.php');
    exit();
}

function activeViewClass(string $target): string
{
    global $view;
    return $view === $target ? 'bg-blue-700 text-white shadow-lg' : 'bg-slate-50 text-slate-700 hover:bg-slate-100';
}

$currentUser = currentUser();
// Derive a friendly display name from the email if not provided
$displayName = null;
if ($currentUser) {
    if (isset($currentUser['display_name'])) {
        $displayName = $currentUser['display_name'];
    } else {
        $parts = explode('@', $currentUser['email']);
        $displayName = ucfirst($parts[0]);
    }
}

$flashMessage = consumeFlash();
$loginError = $_SESSION['login_error'] ?? null;
if (isset($_SESSION['login_error'])) {
    unset($_SESSION['login_error']);
}

$landingMode = $_GET['type'] ?? 'personal';
if (!in_array($landingMode, ['personal', 'business'], true)) {
    $landingMode = 'personal';
}
?>
<!doctype html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meridian Financial Portal</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
      html:not(#z) {
        --user-color-source: baseline-default;
        --color-ref-primary0: #000000ff;
        --color-ref-primary10: #041e49ff;
        --color-ref-primary20: #062e6fff;
        --color-ref-primary25: #073888ff;
        --color-ref-primary30: #0842a0ff;
        --color-ref-primary40: #0b57d0ff;
        --color-ref-primary50: #1b6ef3ff;
        --color-ref-primary60: #4c8df6ff;
        --color-ref-primary70: #7cacf8ff;
        --color-ref-primary80: #a8c7faff;
        --color-ref-primary90: #d3e3fdff;
        --color-ref-primary95: #ecf3feff;
        --color-ref-primary99: #fafbffff;
        --color-ref-primary100: #ffffffff;
        --color-ref-secondary0: #000000ff;
        --color-ref-secondary10: #001d35ff;
        --color-ref-secondary12: #002238ff;
        --color-ref-secondary15: #002845ff;
        --color-ref-secondary20: #003355ff;
        --color-ref-secondary25: #003f66ff;
        --color-ref-secondary30: #004a77ff;
        --color-ref-secondary35: #005789ff;
        --color-ref-secondary40: #00639bff;
        --color-ref-secondary50: #047db7ff;
        --color-ref-secondary60: #3998d3ff;
        --color-ref-secondary70: #5ab3f0ff;
        --color-ref-secondary80: #7fcfffff;
        --color-ref-secondary90: #c2e7ffff;
        --color-ref-secondary95: #dff3ffff;
        --color-ref-secondary99: #f7fcffff;
        --color-ref-secondary100: #ffffffff;
        --color-ref-tertiary0: #000000ff;
        --color-ref-tertiary10: #072711ff;
        --color-ref-tertiary20: #0a3818ff;
        --color-ref-tertiary30: #0f5223ff;
        --color-ref-tertiary40: #146c2eff;
        --color-ref-tertiary50: #198639ff;
        --color-ref-tertiary60: #1ea446ff;
        --color-ref-tertiary70: #37be5fff;
        --color-ref-tertiary80: #6dd58cff;
        --color-ref-tertiary90: #c4eed0ff;
        --color-ref-tertiary95: #e7f8edff;
        --color-ref-tertiary99: #f2ffeeff;
        --color-ref-tertiary100: #ffffffff;
        --color-ref-error0: #000000ff;
        --color-ref-error10: #410e0bff;
        --color-ref-error20: #601410ff;
        --color-ref-error30: #8c1d18ff;
        --color-ref-error40: #b3261eff;
      }

      :root {
        color-scheme: light;
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background: var(--google-grey-50, #f8f9fa);
        color: var(--color-ref-primary10);
      }

      body {
        margin: 0;
        min-height: 100vh;
        background: var(--google-grey-50, #f8f9fa);
        color: var(--color-ref-primary10);
      }

      a {
        color: var(--google-blue-700, #1969d2);
      }

      a:hover,
      a:focus-visible {
        color: var(--google-blue-900, #174ea6);
      }

      button,
      input,
      textarea,
      select {
        font: inherit;
      }

      .footer {
        background: var(--google-grey-100, #f1f3f4);
        color: var(--color-ref-primary30);
      }

      .page-card {
        background: var(--color-ref-primary99);
        border-color: rgba(13, 71, 161, 0.12);
      }

      .page-card-strong {
        background: var(--color-ref-primary95);
      }

      .btn-primary {
        background: var(--google-blue-600, #1a73e8);
        color: white;
      }

      .btn-primary:hover,
      .btn-primary:focus-visible {
        background: var(--google-blue-700, #1967d2);
      }
    </style>
<link rel="stylesheet" href="assets/css/bank-theme.css?v=<?php echo time(); ?>"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Lora:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet"></head>
<body class="min-h-screen bg-slate-50 text-slate-900 flex flex-col">

    <!-- Modernized corporate header -->
    <header class="mt-portal-header">
        <div class="mt-portal-header-container">
            <div class="mt-logo">
                <svg class="mt-logo-icon" width="28" height="28" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 2C8.71573 2 2 8.71573 2 17C2 25.2843 8.71573 32 17 32C25.2843 32 32 25.2843 32 17C32 8.71573 25.2843 2 17 2Z" fill="#B3191F"/>
                    <path d="M10 24C12.5 19 15 15.5 24 13C20 16 16.5 19.5 15 24H10Z" fill="white"/>
                </svg>
                <h2 style="font-size:1.15rem; color:#ffffff; font-weight:800; letter-spacing:0.04em; text-transform:uppercase; margin:0;">Meridian Trust Bank</h2>
            </div>
            <div class="mt-portal-header-nav">
                <?php if ($currentUser): ?>
                    <span class="text-sm" style="color: #ffffff; font-weight:600; font-size:0.9rem; margin-right:16px;">Hi, <?php echo htmlspecialchars($displayName); ?></span>
                    <form method="POST" action="customer_dashboard.php" class="m-0" style="display:inline;">
                        <input type="hidden" name="action" value="logout" />
                        <button type="submit" class="mt-btn-login-red" style="padding: 0.45rem 1.2rem; font-size:0.8rem;">Logout</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="flex-grow px-4 py-8">
        <?php if ($view === 'landing'): ?>
            <section class="mx-auto max-w-6xl rounded-[2rem] bg-gradient-to-br from-slate-950 via-slate-900 to-slate-800 overflow-hidden shadow-2xl border border-slate-700">
                <div class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr] p-8 lg:p-10">
                    <div class="space-y-6 text-white">
                        <div class="flex items-center gap-3 text-sm uppercase tracking-[0.35em] text-cyan-300 font-semibold">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-cyan-500/20">✓</span>
                            Integrated Banking Experience
                        </div>
                        <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight">A modern financial portal engineered for <?php echo $landingMode === 'business' ? 'enterprises' : 'everyday customers'; ?>.</h1>
                        <p class="max-w-xl text-slate-300 text-sm sm:text-base">Switch instantly between the Personal Banking and Business Solutions experience. See the messaging change, explore the tailored benefits, and enter the secure portal on demand.</p>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="rounded-3xl bg-slate-900/70 p-5 border border-slate-700">
                                <p class="text-xs uppercase tracking-[0.25em] text-cyan-400">Target Audience</p>
                                <p class="mt-3 font-semibold text-lg"><?php echo $landingMode === 'business' ? 'Business leaders, treasurers, and finance teams' : 'Retail users, families, and individuals'; ?></p>
                            </div>
                            <div class="rounded-3xl bg-slate-900/70 p-5 border border-slate-700">
                                <p class="text-xs uppercase tracking-[0.25em] text-cyan-400">Primary Value</p>
                                <p class="mt-3 font-semibold text-lg"><?php echo $landingMode === 'business' ? 'Approval workflows and vendor payment oversight' : 'Fast personal transfers and balance visibility'; ?></p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row items-start sm:items-center">
                            <div class="rounded-full bg-slate-900/80 p-3 border border-slate-700 flex items-center gap-3">
                                <span class="text-xs uppercase tracking-[0.25em] text-slate-400">Mode</span>
                                <button id="landingToggle" class="relative inline-flex h-9 w-20 items-center rounded-full bg-slate-700 p-1 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400" aria-pressed="false">
                                    <span class="sr-only">Switch landing mode</span>
                                    <span class="pointer-events-none absolute inset-y-0 left-1 w-8 rounded-full bg-cyan-500 transition-transform" id="landingToggleSwitch"></span>
                                    <span class="relative z-10 w-10 text-center text-[11px] font-semibold uppercase text-white" id="landingToggleLabel">Personal</span>
                                </button>
                            </div>
                            <a href="customer_dashboard.php?view=login" class="inline-flex items-center justify-center rounded-3xl bg-cyan-500 px-6 py-3 text-sm font-semibold text-slate-950 shadow-xl shadow-cyan-500/30 hover:bg-cyan-400 transition">Enter the Application Portal</a>
                        </div>
                    </div>

                    <div class="rounded-[2rem] bg-slate-900/95 p-8 text-slate-100 border border-slate-700 shadow-xl">
                        <div class="space-y-5">
                            <div class="rounded-3xl border border-slate-700 bg-slate-950/80 p-6">
                                <h2 class="text-xl font-bold text-white">Feature Highlights</h2>
                                <ul class="mt-4 space-y-3 text-sm text-slate-300">
                                    <li class="flex items-start gap-3"><span class="mt-1 h-2.5 w-2.5 rounded-full bg-cyan-400"></span><?php echo $landingMode === 'business' ? 'Enterprise payment approval routing for multi-recipient disbursements.' : 'Instant peer-to-peer transfers and account snapshots in one screen.'; ?></li>
                                    <li class="flex items-start gap-3"><span class="mt-1 h-2.5 w-2.5 rounded-full bg-cyan-400"></span><?php echo $landingMode === 'business' ? 'Pending review dashboards and administrative settlement controls.' : 'Live transaction history with status previews and balance forecasts.'; ?></li>
                                    <li class="flex items-start gap-3"><span class="mt-1 h-2.5 w-2.5 rounded-full bg-cyan-400"></span><?php echo $landingMode === 'business' ? 'Robust routing data validation and settlement workflows.' : 'Secure login screen and role-based access for your finance team.'; ?></li>
                                </ul>
                            </div>

                            <div class="rounded-3xl border border-slate-700 bg-slate-950/90 p-6">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <h3 class="text-sm uppercase tracking-[0.25em] text-cyan-300">Alerts</h3>
                                        <p class="mt-2 text-slate-400 text-sm">Live FX pairs and movement signals.</p>
                                    </div>
                                    <span class="rounded-full bg-cyan-500/10 px-3 py-1 text-xs text-cyan-200">Real-time</span>
                                </div>
                                <div id="alertsTicker" class="mt-4 flex flex-col gap-3 overflow-hidden text-xs sm:flex-row sm:items-center sm:justify-between">
                                    <div class="rounded-2xl bg-slate-900/70 px-4 py-3 text-slate-100 shadow-inner">EUR/USD <span class="font-semibold">1.0821</span> <span class="text-emerald-300">▲0.12%</span></div>
                                    <div class="rounded-2xl bg-slate-900/70 px-4 py-3 text-slate-100 shadow-inner">GBP/USD <span class="font-semibold">1.2635</span> <span class="text-rose-300">▼0.08%</span></div>
                                    <div class="rounded-2xl bg-slate-900/70 px-4 py-3 text-slate-100 shadow-inner">USD/JPY <span class="font-semibold">154.32</span> <span class="text-emerald-300">▲0.05%</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($view === 'login'): ?>
            <div class="mt-login-backdrop">
                <div class="mt-login-card">
                    <a href="index.php" class="mt-login-close">&times;</a>
                    <div class="mt-login-brand">
                        <svg class="mt-logo-icon" width="36" height="36" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 2C8.71573 2 2 8.71573 2 17C2 25.2843 8.71573 32 17 32C25.2843 32 32 25.2843 32 17C32 8.71573 25.2843 2 17 2Z" fill="#B3191F"/>
                            <path d="M10 24C12.5 19 15 15.5 24 13C20 16 16.5 19.5 15 24H10Z" fill="white"/>
                            <path d="M14 10.5C15.5 12 18.5 14 24 13C21 11.5 18 10 14 10.5Z" fill="white"/>
                        </svg>
                        <h2 class="mt-login-bank-title">Meridian Bank<span class="mt-red-dot">.</span></h2>
                    </div>
                    <h3 class="mt-login-card-subtitle">Identity Authentication</h3>
                    <p class="mt-login-card-desc">Protected by end-to-end multi-factor session tokens. Enter your corporate clearance credentials below.</p>
                    <form method="POST" action="customer_dashboard.php" class="mt-login-form">
                        <?php if ($loginError): ?>
                            <div class="mt-login-error-msg"><?php echo htmlspecialchars($loginError); ?></div>
                        <?php endif; ?>
                        <input type="hidden" name="action" value="login" />
                        <div class="mt-form-group">
                            <label class="mt-form-label">User Identifier / Email</label>
                            <input name="email" type="email" required placeholder="name@domain.com" class="mt-form-input" />
                        </div>
                        <div class="mt-form-group">
                            <label class="mt-form-label">Access Passphrase</label>
                            <input name="password" type="password" required placeholder="••••••••" class="mt-form-input" />
                        </div>
                        <button type="submit" class="mt-btn-login-submit-card">Authenticate &amp; Continue</button>
                        <div class="mt-login-form-footer">
                            <span class="mt-passkey-label">Alternative Verification: <a href="#passkey" class="mt-passkey-link">Sign on with Passkey</a></span>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

<?php if ($view === "dashboard"): ?>
        <?php requireRole("customer");?>
        <div class="mt-portal-container">
            <!-- Account Overview Cards -->
            <div class="mt-portal-grid-3">
                <div class="mt-card mt-span-2">
                    <div class="mt-card-header-line">
                        <p class="mt-card-label">Corporate Accounts</p>
                        <h2 class="mt-card-title-main">Account Overview</h2>
                    </div>
                    
                    <div class="mt-balance-grid">
                        <?php $checking_balance = $_SESSION["mock_balance"]; $savings_balance = $_SESSION["savings_balance"]; ?>
                        
                        <!-- Card: Checking -->
                        <div class="mt-balance-card mt-card-accent-gold">
                            <span class="mt-balance-tag">Corporate Checking</span>
                            <h3 class="mt-balance-acc-name">Corporate Checking Account</h3>
                            <div class="mt-balance-row">
                                <span class="mt-balance-amount mt-serif-title" id="currentBalanceChecking" data-original="$<?php echo number_format($checking_balance, 2); ?>">$<?php echo number_format($checking_balance, 2); ?></span>
                                <button type="button" data-target="currentBalanceChecking" class="balance-toggle mt-btn-hide">[Hide]</button>
                            </div>
                            <span class="mt-balance-sub">Available Balance</span>
                        </div>

                        <!-- Card: Savings -->
                        <div class="mt-balance-card">
                            <span class="mt-balance-tag">Premium Savings</span>
                            <h3 class="mt-balance-acc-name">Savings Account</h3>
                            <div class="mt-balance-row">
                                <span class="mt-balance-amount mt-serif-title" id="currentBalanceSavings" data-original="$<?php echo number_format($savings_balance, 2); ?> USD">$<?php echo number_format($savings_balance, 2); ?> USD</span>
                                <button type="button" data-target="currentBalanceSavings" class="balance-toggle mt-btn-hide">[Hide]</button>
                            </div>
                            <span class="mt-balance-sub">Available Balance</span>
                        </div>
                    </div>
                </div>

                <!-- Transfer Funds Panel -->
                <div class="mt-card">
                    <div class="mt-card-header-line">
                        <p class="mt-card-label">Outbound Settlements</p>
                        <h2 class="mt-card-title-main">Transfer Funds</h2>
                    </div>

                    <?php if ($flashMessage): ?>
                        <div class="mt-login-error-msg" style="margin-top:16px; background: rgba(27, 74, 120, 0.08); border-color: rgba(27, 74, 120, 0.18); color: var(--mt-blue);"><?php echo htmlspecialchars($flashMessage); ?></div>
                    <?php endif; ?>

                    <form method="POST" action="customer_dashboard.php" class="mt-transfer-form">
                        <input type="hidden" name="action" value="transfer" />

                        <div class="mt-form-group">
                            <label class="mt-form-label">Beneficiary Account Number</label>
                            <input name="recipient" type="text" required placeholder="e.g. 001234567890" class="mt-form-input" />
                        </div>

                        <div class="mt-form-group">
                            <label class="mt-form-label">Routing Transit Number (RTN) / SWIFT Code</label>
                            <input name="routing" type="text" placeholder="e.g. 021000021 / BARCGB22" class="mt-form-input" />
                        </div>

                        <div class="mt-form-group">
                            <label class="mt-form-label">Transfer Amount (USD)</label>
                            <input name="amount" type="number" step="0.01" min="0.01" required placeholder="0.00" class="mt-form-input" />
                        </div>

                        <div class="mt-form-group">
                            <label class="mt-form-label">Transaction Narration / Reference</label>
                            <input name="narration" type="text" placeholder="e.g. Invoice #12345 - Project Draw" class="mt-form-input" />
                        </div>

                        <?php if (isset($_SESSION["account_status"]) && $_SESSION["account_status"] === "FROZEN"): ?>
                            <div class="mt-login-error-msg">Account is currently FROZEN. Outbound transfers are temporarily restricted.</div>
                        <?php else: ?>
                            <button type="submit" class="mt-btn-login-submit-card">Queue Pending Transfer</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <!-- Transaction Ledger Grid -->
            <div class="mt-card mt-margin-top-30">
                <div class="mt-card-header-line-flex">
                    <div>
                        <p class="mt-card-label">Ledger Statements</p>
                        <h2 class="mt-card-title-main">Account Histories</h2>
                    </div>
                    <span class="mt-status-badge">Auto-update every 10s</span>
                </div>

                <div class="mt-ledger-grid">
                    <!-- Column: Savings -->
                    <div>
                        <h4 class="mt-ledger-column-title">Savings Account History</h4>
                        <div class="mt-ledger-feed" id="savingsFeed">
                            <?php foreach (getTransactions() as $tx): ?>
                                <?php if (($tx["account"] ?? "") === "savings"): ?>
                                <div class="mt-ledger-item">
                                    <div class="mt-ledger-details">
                                        <p class="mt-ledger-recipient"><?php echo htmlspecialchars($tx["recipient"]); ?></p>
                                        <p class="mt-ledger-date"><?php echo htmlspecialchars($tx["date"]); ?></p>
                                        <p class="mt-ledger-narration"><?php echo htmlspecialchars($tx["narration"] ?? ""); ?></p>
                                    </div>
                                    <div class="mt-ledger-action-area">
                                        <p class="mt-ledger-amount mt-serif-title">$<?php echo number_format($tx["amount"], 2); ?></p>
                                        <button data-txid="<?php echo $tx["id"]; ?>" data-recipient="<?php echo htmlspecialchars($tx["recipient"]); ?>" data-amount="2" data-date="<?php echo htmlspecialchars($tx["date"]); ?>" class="download-receipt mt-ledger-link">Download Receipt &rarr;</button>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Column: Checking -->
                    <div>
                        <h4 class="mt-ledger-column-title">Checking Account History</h4>
                        <div class="mt-ledger-feed" id="checkingFeed">
                            <?php foreach (getTransactions() as $tx): ?>
                                <?php if (($tx["account"] ?? "") === "checking"): ?>
                                <div class="mt-ledger-item">
                                    <div class="mt-ledger-details">
                                        <p class="mt-ledger-recipient"><?php echo htmlspecialchars($tx["recipient"]); ?></p>
                                        <p class="mt-ledger-date"><?php echo htmlspecialchars($tx["date"]); ?></p>
                                        <p class="mt-ledger-narration"><?php echo htmlspecialchars($tx["narration"] ?? ""); ?></p>
                                    </div>
                                    <div class="mt-ledger-action-area">
                                        <p class="mt-ledger-amount mt-serif-title">$<?php echo number_format($tx["amount"], 2); ?></p>
                                        <button data-txid="<?php echo $tx["id"]; ?>" data-recipient="<?php echo htmlspecialchars($tx["recipient"]); ?>" data-amount="2" data-date="<?php echo htmlspecialchars($tx["date"]); ?>" class="view-voucher mt-ledger-link">View Voucher &rarr;</button>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

<?php if ($view === 'admin'): ?>
            <?php requireRole('admin'); ?>
            <section class="mx-auto max-w-6xl space-y-6">
                <div class="rounded-[2rem] bg-white p-8 shadow-lg border border-slate-200">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between pb-6 border-b border-slate-200">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-fuchsia-600 font-semibold">Administrative Dashboard</p>
                            <h2 class="mt-3 text-3xl font-bold text-slate-950">Pending transfer settlement</h2>
                        </div>
                        <span class="rounded-full bg-fuchsia-50 px-4 py-2 text-sm text-fuchsia-700">Realtime state refresh</span>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <form method="POST" action="customer_dashboard.php" class="p-4 rounded-lg border bg-white">
                            <input type="hidden" name="action" value="set_account_status" />
                            <p class="text-xs text-slate-500">Account Status</p>
                            <div class="mt-2 flex items-center gap-3">
                                <select name="status" class="rounded-md border px-3 py-2 text-sm">
                                    <option value="ACTIVE" <?php echo ($_SESSION['account_status'] === 'ACTIVE') ? 'selected' : ''; ?>>ACTIVE</option>
                                    <option value="FROZEN" <?php echo ($_SESSION['account_status'] === 'FROZEN') ? 'selected' : ''; ?>>FROZEN</option>
                                </select>
                                <button type="submit" class="btn-primary rounded-md px-3 py-2 text-sm">Set Status</button>
                            </div>
                            <p class="mt-2 text-xs text-slate-500">Current: <strong><?php echo htmlspecialchars($_SESSION['account_status']); ?></strong></p>
                        </form>

                        <form method="POST" action="customer_dashboard.php" class="p-4 rounded-lg border bg-white">
                            <input type="hidden" name="action" value="admin_inject" />
                            <p class="text-xs text-slate-500">Retroactive Ledger Injection</p>
                            <label class="block text-xs mt-2">Recipient</label>
                            <input name="inj_recipient" type="text" class="w-full rounded-md border px-2 py-2 text-sm" required />
                            <label class="block text-xs mt-2">Date (mm/dd/YYYY)</label>
                            <input name="inj_date" type="text" class="w-full rounded-md border px-2 py-2 text-sm" placeholder="mm/dd/YYYY" required />
                            <label class="block text-xs mt-2">Amount (USD)</label>
                            <input name="inj_amount" type="number" step="0.01" class="w-full rounded-md border px-2 py-2 text-sm" required />
                            <div class="mt-3">
                                <button type="submit" class="rounded-md bg-emerald-600 px-3 py-2 text-sm text-white">Inject Historic Item</button>
                            </div>
                        </form>
                    </div>

                    <?php if ($flashMessage): ?>
                        <div class="mt-6 rounded-3xl border border-fuchsia-100 bg-fuchsia-50 p-4 text-sm text-fuchsia-900"><?php echo htmlspecialchars($flashMessage); ?></div>
                    <?php endif; ?>

                    <div class="mt-8 overflow-x-auto">
                        <table class="w-full min-w-[700px] text-left text-sm sm:text-base">
                            <thead class="border-b border-slate-200 text-slate-500 uppercase tracking-[0.18em] text-xs sm:text-sm">
                                <tr>
                                    <th class="pb-4">Reference</th>
                                    <th class="pb-4">Recipient</th>
                                    <th class="pb-4">Amount</th>
                                    <th class="pb-4">Status</th>
                                    <th class="pb-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="adminTableBody" class="divide-y divide-slate-100">
                                <?php foreach (getTransactions() as $tx): ?>
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="py-4 font-mono text-xs text-slate-400">TXN-<?php echo substr((string)$tx['id'], -6); ?></td>
                                        <td class="py-4 font-semibold text-slate-900"><?php echo htmlspecialchars($tx['recipient']); ?></td>
                                        <td class="py-4 font-bold text-slate-900">$<?php echo number_format($tx['amount'], 2); ?></td>
                                        <td class="py-4">
                                            <span class="inline-flex rounded-full px-3 py-1 text-[11px] font-semibold <?php echo $tx['status'] === 'APPROVED' ? 'bg-emerald-100 text-emerald-700' : ($tx['status'] === 'REJECTED' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700'); ?>">
                                                <?php echo htmlspecialchars($tx['status']); ?>
                                            </span>
                                        </td>
                                        <td class="py-4 text-right">
                                            <?php if ($tx['status'] === 'PENDING'): ?>
                                                <form method="POST" action="customer_dashboard.php" class="inline-flex flex-wrap items-center justify-end gap-2">
                                                    <input type="hidden" name="action" value="admin_decision" />
                                                    <input type="hidden" name="tx_id" value="<?php echo $tx['id']; ?>" />
                                                    <button type="submit" name="decision" value="APPROVED" class="rounded-full bg-emerald-600 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-500 transition">Approve</button>
                                                    <button type="submit" name="decision" value="REJECTED" class="rounded-full bg-rose-600 px-4 py-2 text-xs font-semibold text-white hover:bg-rose-500 transition">Reject</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-xs text-slate-500">Reviewed</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <?php include 'footer.php'; ?>

    <!-- Voucher Modal (hidden by default) -->
    <div id="voucherModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-6">
        <div class="bg-white rounded-xl max-w-2xl w-full shadow-xl p-6 print:p-0" id="voucherContent">
            <div class="flex justify-between items-start">
                <h4 class="text-lg font-bold text-slate-900">Settlement Voucher</h4>
                <button id="closeVoucher" class="text-slate-500">Close</button>
            </div>
            <div id="voucherBody" class="mt-4 text-sm text-slate-700">
                <!-- Populated dynamically -->
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button id="printVoucher" class="btn-primary rounded-md px-4 py-2">Print Confirmation</button>
            </div>
        </div>
    </div>

    <script>
        const landingData = {
            personal: {
                title: 'Next-Generation Wealth Hub',
                subtitle: 'Monitor multi-currency liquid asset balances, initiate local instant transfers, and review real-time history ledgers.',
                audience: 'Retail users, families, and individuals',
                value: 'Fast personal transfers and balance visibility',
                features: [
                    'Instant peer-to-peer transfers and account snapshots in one screen.',
                    'Live transaction history with status previews and balance forecasts.',
                    'Secure login screen and role-based access for your finance team.',
                ],
            },
            business: {
                title: 'Institutional Escrow Solutions',
                subtitle: 'Streamline high-volume payroll channels, clear commercial vendor invoicing, and access operational approval administration tools.',
                audience: 'Business leaders, treasurers, and finance teams',
                value: 'Approval workflows and vendor payment oversight',
                features: [
                    'Enterprise payment approval routing for multi-recipient disbursements.',
                    'Pending review dashboards and administrative settlement controls.',
                    'Robust routing data validation and settlement workflows.',
                ],
            },
        };

        const toggleButton = document.getElementById('landingToggle');
        const toggleSwitch = document.getElementById('landingToggleSwitch');
        let currentMode = '<?php echo $landingMode; ?>';

        function applyLandingMode(mode) {
            const modeConfig = landingData[mode];
            if (!modeConfig) return;
            document.querySelector('h1').textContent = `A modern financial portal engineered for ${mode === 'business' ? 'enterprises' : 'everyday customers'}.`;
            document.querySelector('p.text-slate-300').textContent = modeConfig.subtitle;
            const highlightCards = Array.from(document.querySelectorAll('div')).filter(el => el.classList.contains('rounded-3xl') && el.classList.contains('bg-slate-900/70'));
            if (highlightCards.length >= 2) {
                const firstText = highlightCards[0].querySelector('p + p');
                const secondText = highlightCards[1].querySelector('p + p');
                if (firstText) firstText.textContent = modeConfig.audience;
                if (secondText) secondText.textContent = modeConfig.value;
            }
            document.querySelectorAll('.rounded-3xl.border.border-slate-700 ul li').forEach((item, idx) => {
                const span = item.querySelector('span + span');
                if (span) span.textContent = modeConfig.features[idx];
            });
            const isBusiness = mode === 'business';
            toggleSwitch.style.transform = isBusiness ? 'translateX(4.25rem)' : 'translateX(0)';
            toggleButton.setAttribute('aria-pressed', isBusiness);
            currentMode = mode;
        }

        if (toggleButton) {
            toggleButton.addEventListener('click', () => {
                const nextMode = currentMode === 'personal' ? 'business' : 'personal';
                window.location.search = `?view=landing&type=${nextMode}`;
            });
            const label = document.getElementById('landingToggleLabel');
            if (label) {
                label.textContent = currentMode === 'business' ? 'Business' : 'Personal';
            }
            applyLandingMode(currentMode);
        }

        async function refreshDashboard() {
            const response = await fetch('index.php?api=dashboard');
            if (!response.ok) return;
            const data = await response.json();
            const checkingEl = document.getElementById('currentBalanceChecking');
            const savingsEl = document.getElementById('currentBalanceSavings');

            if (checkingEl) {
                checkingEl.textContent = `$${parseFloat(data.checking_balance).toFixed(2)}`;
                checkingEl.setAttribute('data-original', `$${parseFloat(data.checking_balance).toFixed(2)}`);
            }
            if (savingsEl) {
                savingsEl.textContent = `$${parseFloat(data.savings_balance).toFixed(2)} USD`;
                savingsEl.setAttribute('data-original', `$${parseFloat(data.savings_balance).toFixed(2)} USD`);
            }

            const savingsFeed = document.getElementById('savingsFeed');
            const checkingFeed = document.getElementById('checkingFeed');

            if (savingsFeed) {
                const savings = data.transactions.filter(tx => tx.account === 'savings');
                savingsFeed.innerHTML = savings.map(tx => `
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4 grid gap-3 sm:grid-cols-[1fr_auto] items-center">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">${tx.recipient}</p>
                            <p class="mt-1 text-xs text-slate-500">${tx.date}</p>
                            <p class="mt-1 text-xs text-slate-500">${tx.narration || ''}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-slate-900">$${parseFloat(tx.amount).toFixed(2)}</p>
                            <div class="flex flex-col items-end gap-2">
                                <button data-txid="${tx.id}" data-recipient="${encodeURIComponent(tx.recipient)}" data-amount="${parseFloat(tx.amount).toFixed(2)}" data-date="${tx.date}" class="download-receipt text-xs text-slate-500 underline">Download Receipt</button>
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            if (checkingFeed) {
                const checking = data.transactions.filter(tx => tx.account === 'checking');
                checkingFeed.innerHTML = checking.map(tx => `
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4 grid gap-3 sm:grid-cols-[1fr_auto] items-center">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">${tx.recipient}</p>
                            <p class="mt-1 text-xs text-slate-500">${tx.date}</p>
                            <p class="mt-1 text-xs text-slate-500">${tx.narration || ''}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-slate-900">$${parseFloat(tx.amount).toFixed(2)}</p>
                            <div class="flex flex-col items-end gap-2">
                                <button data-txid="${tx.id}" data-recipient="${encodeURIComponent(tx.recipient)}" data-amount="${parseFloat(tx.amount).toFixed(2)}" data-date="${tx.date}" class="view-voucher text-xs text-slate-500 underline">View Voucher</button>
                            </div>
                        </div>
                    </div>
                `).join('');
            }
        }

        async function refreshAdminTable() {
            const response = await fetch('index.php?api=dashboard');
            if (!response.ok) return;
            const data = await response.json();
            const tableBody = document.getElementById('adminTableBody');
            if (!tableBody) return;
            tableBody.innerHTML = data.transactions.map(tx => {
                const statusClass = tx.status === 'APPROVED' ? 'bg-emerald-100 text-emerald-700' : (tx.status === 'REJECTED' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700');
                const actions = tx.status === 'PENDING'
                    ? `<form method="POST" action="customer_dashboard.php" class="inline-flex flex-wrap items-center justify-end gap-2">` +
                      `<input type="hidden" name="action" value="admin_decision" />` +
                      `<input type="hidden" name="tx_id" value="${tx.id}" />` +
                      `<button type="submit" name="decision" value="APPROVED" class="rounded-full bg-emerald-600 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-500 transition">Approve</button>` +
                      `<button type="submit" name="decision" value="REJECTED" class="rounded-full bg-rose-600 px-4 py-2 text-xs font-semibold text-white hover:bg-rose-500 transition">Reject</button>` +
                      `</form>`
                    : '<span class="text-xs text-slate-500">Reviewed</span>';

                return `
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-4 font-mono text-xs text-slate-400">TXN-${String(tx.id).slice(-6)}</td>
                        <td class="py-4 font-semibold text-slate-900">${tx.recipient}</td>
                        <td class="py-4 font-bold text-slate-900">$${parseFloat(tx.amount).toFixed(2)}</td>
                        <td class="py-4"><span class="inline-flex rounded-full px-3 py-1 text-[11px] font-semibold ${statusClass}">${tx.status}</span></td>
                        <td class="py-4 text-right">${actions}</td>
                    </tr>
                `;
            }).join('');
        }

        if (document.getElementById('currentBalanceChecking') || document.getElementById('currentBalanceSavings')) {
            setInterval(refreshDashboard, 10000);
            // initial load
            refreshDashboard();
        }

        if (document.getElementById('adminTableBody')) {
            setInterval(refreshAdminTable, 10000);
            refreshAdminTable();
        }

        // Delegated handler for action buttons (review, view voucher, download receipt)
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.review-btn, .view-voucher, .download-receipt');
            if (!btn) return;

            const txId = btn.getAttribute('data-txid');
            const recipient = decodeURIComponent(btn.getAttribute('data-recipient') || '');
            const amount = btn.getAttribute('data-amount');
            const date = btn.getAttribute('data-date');

            // Download receipt handler
            if (btn.classList.contains('download-receipt')) {
                const content = `Receipt - TXN-${String(txId).slice(-8)}\nDate: ${date}\nBeneficiary: ${recipient}\nAmount: $${parseFloat(amount).toFixed(2)}\nThank you for banking with us.`;
                const blob = new Blob([content], { type: 'text/plain' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `receipt-TXN-${String(txId).slice(-8)}.txt`;
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(url);
                return;
            }

            // View voucher / review document
            const voucherBody = document.getElementById('voucherBody');
            const modal = document.getElementById('voucherModal');
            const settlementHash = 'VCHR-' + btoa(txId + '|' + recipient + '|' + amount).substring(0, 12);
            voucherBody.innerHTML = `
                <p class="text-sm text-slate-700">Reference: <span class="font-mono">TXN-${String(txId).slice(-8)}</span></p>
                <p class="mt-2">Beneficiary: <strong>${recipient}</strong></p>
                <p class="mt-2">Settlement Value: <strong>$${parseFloat(amount).toFixed(2)}</strong></p>
                <p class="mt-2">Processing Date: <strong>${date}</strong></p>
                <p class="mt-2">Routing Confirmation: <strong>${recipient}</strong></p>
                <p class="mt-3 text-xs text-slate-500">Settlement Hash: <span class="font-mono">${settlementHash}</span></p>
            `;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        document.getElementById('closeVoucher')?.addEventListener('click', function () {
            const modal = document.getElementById('voucherModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });

        document.getElementById('printVoucher')?.addEventListener('click', function () {
            window.print();
        });

        // Balance privacy toggle handler
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.balance-toggle');
            if (!btn) return;
            const targetId = btn.getAttribute('data-target');
            const el = document.getElementById(targetId);
            if (!el) return;
            const masked = el.getAttribute('data-masked') === 'true';
            if (masked) {
                el.textContent = el.getAttribute('data-original');
                el.setAttribute('data-masked', 'false');
                btn.textContent = '[Hide]';
            } else {
                el.textContent = '****';
                el.setAttribute('data-masked', 'true');
                btn.textContent = '[Show]';
            }
        });
    </script>
</body>
</html>
