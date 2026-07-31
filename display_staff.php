<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header('location:adminlogin.php');
    exit();
}

include '_inc/dbconn.php';

$sql = "SELECT * FROM staff";
$result = mysql_query($sql) or die(mysql_error());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Directory - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light">

    <?php include 'header.php'; ?>

    <div class="container my-4">
        <div class="row">
            <div class="col-md-3 mb-4">
                <?php include 'admin_navbar.php'; ?>
            </div>
            <div class="col-md-9">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h1 class="h4 fw-bold text-dark mb-3">Staff Member Directory</h1>
                    <p class="text-muted small mb-4">Select a staff member to edit details or update department assignments.</p>

                    <form action="editstaff.php" method="POST">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle small">
                                <thead class="table-light">
                                    <tr>
                                        <th>Select</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Department</th>
                                        <th>DOJ</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result && mysql_num_rows($result) > 0): ?>
                                        <?php while ($rws = mysql_fetch_array($result)): ?>
                                            <tr>
                                                <td><input type="radio" name="staff_id" value="<?php echo $rws['id']; ?>" required></td>
                                                <td><?php echo $rws['id']; ?></td>
                                                <td class="fw-semibold"><?php echo htmlspecialchars($rws['name']); ?></td>
                                                <td><?php echo $rws['gender']; ?></td>
                                                <td><?php echo ucfirst($rws['department']); ?></td>
                                                <td><?php echo $rws['doj']; ?></td>
                                                <td><?php echo htmlspecialchars($rws['mobile']); ?></td>
                                                <td><?php echo htmlspecialchars($rws['email']); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr><td colspan="8" class="text-center text-muted py-3">No staff records found.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <button type="submit" name="submit1_id" class="btn btn-primary rounded-pill px-4">Edit Staff Details</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
