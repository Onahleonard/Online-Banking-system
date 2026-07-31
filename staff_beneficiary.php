<?php
session_start();
if (!isset($_SESSION['staff_login'])) {
    header('location:staff_login.php');
    exit();
}

include '_inc/dbconn.php';

$sql = "SELECT * FROM beneficiary1 WHERE status='PENDING'";
$result = mysql_query($sql) or die(mysql_error());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beneficiary Requests - Staff Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light">

    <?php include 'header.php'; ?>

    <div class="container my-4">
        <div class="row">
            <div class="col-md-3 mb-4">
                <?php include 'staff_navbar.php'; ?>
            </div>
            <div class="col-md-9">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h1 class="h4 fw-bold text-dark mb-3">Pending Beneficiary Requests</h1>
                    <p class="text-muted small mb-4">Review and activate pending customer payees.</p>

                    <form action="staff_approve_beneficiery.php" method="POST">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle small">
                                <thead class="table-light">
                                    <tr>
                                        <th>Select</th>
                                        <th>ID</th>
                                        <th>Sender Name</th>
                                        <th>Sender Account</th>
                                        <th>Receiver Name</th>
                                        <th>Receiver Account</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result && mysql_num_rows($result) > 0): ?>
                                        <?php while ($rws = mysql_fetch_array($result)): ?>
                                            <tr>
                                                <td><input type="radio" name="customer_id" value="<?php echo $rws[0]; ?>" required></td>
                                                <td><?php echo $rws[0]; ?></td>
                                                <td><?php echo htmlspecialchars($rws[2]); ?></td>
                                                <td><?php echo $rws[1]; ?></td>
                                                <td class="fw-semibold"><?php echo htmlspecialchars($rws[4]); ?></td>
                                                <td><?php echo $rws[3]; ?></td>
                                                <td><span class="badge bg-warning text-dark"><?php echo $rws[5]; ?></span></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr><td colspan="7" class="text-center text-muted py-3">No pending beneficiary requests.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($result && mysql_num_rows($result) > 0): ?>
                            <div class="mt-3">
                                <button type="submit" name="submit_id" class="btn btn-primary rounded-pill px-4">APPROVE BENEFICIARY</button>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
