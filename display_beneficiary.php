<?php
session_start();
if (!isset($_SESSION['customer_login']) || !isset($_SESSION['login_id'])) {
    header('location:login.php');
    exit();
}

include '_inc/dbconn.php';

$sender_id = mysql_real_escape_string($_SESSION['login_id']);
$sql = "SELECT * FROM beneficiary1 WHERE sender_id='$sender_id'";
$result = mysql_query($sql) or die(mysql_error());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Added Beneficiaries - Meridian Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light">

    <?php include 'customer_navbar.php'; ?>

    <main class="container my-5" style="max-width: 850px;">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <h1 class="h4 fw-bold text-dark mb-1">Registered Payees & Beneficiaries</h1>
                    <p class="text-muted small mb-0">View or remove payees linked to your account.</p>
                </div>
                <a href="add_beneficiary.php" class="btn btn-primary btn-sm rounded-pill px-3">+ Add New Payee</a>
            </div>

            <form action="delete_beneficiary.php" method="POST">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light small">
                            <tr>
                                <th>Select</th>
                                <th>Payee Name</th>
                                <th>Account No</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && mysql_num_rows($result) > 0): ?>
                                <?php while ($rws = mysql_fetch_array($result)): ?>
                                    <tr>
                                        <td><input type="radio" name="customer_id" value="<?php echo $rws[0]; ?>" required></td>
                                        <td class="fw-semibold"><?php echo htmlspecialchars($rws[4]); ?></td>
                                        <td><?php echo $rws[3]; ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $rws[5] === 'ACTIVE' ? 'success' : 'warning'; ?> fs-6"><?php echo $rws[5]; ?></span>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center text-muted py-4">No registered beneficiaries found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($result && mysql_num_rows($result) > 0): ?>
                    <div class="mt-3 text-end">
                        <button type="submit" name="submit_id" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="return confirm('Remove selected beneficiary?');">Remove Selected Payee</button>
                    </div>
                <?php endif; ?>
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
