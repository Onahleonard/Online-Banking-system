<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header('location:adminlogin.php');
    exit();
}

include '_inc/dbconn.php';

$msg = '';
if (isset($_POST['save_contact'])) {
    foreach ($_POST['branches'] as $id => $branch_data) {
        $id_escaped = mysql_real_escape_string($id);
        $name = mysql_real_escape_string($branch_data['name']);
        $address = mysql_real_escape_string($branch_data['address']);
        $phone = mysql_real_escape_string($branch_data['phone']);
        $email = mysql_real_escape_string($branch_data['email']);

        mysql_query("UPDATE contact_details SET branch_name='$name', address='$address', phone='$phone', email='$email' WHERE id='$id_escaped'") or die(mysql_error());
    }
    $msg = "Support contact details updated successfully!";
}

$sql = "SELECT * FROM contact_details";
$res = mysql_query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Support Contacts - Admin Dashboard</title>
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
                    <h1 class="h4 fw-bold text-dark mb-4 border-bottom pb-2">Edit Support Contact Details</h1>

                    <?php if (!empty($msg)): ?>
                        <div class="alert alert-success border-0 small mb-4"><?php echo htmlspecialchars($msg); ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <?php if ($res && mysql_num_rows($res) > 0): ?>
                            <?php while ($row = mysql_fetch_array($res)): $id = $row['id']; ?>
                                <div class="p-3 mb-4 bg-light rounded-3 border">
                                    <h5 class="fw-bold text-primary mb-3">Branch ID #<?php echo $id; ?></h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold small">Branch Name</label>
                                            <input type="text" name="branches[<?php echo $id; ?>][name]" value="<?php echo htmlspecialchars($row['branch_name']); ?>" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold small">Telephone / Phone</label>
                                            <input type="text" name="branches[<?php echo $id; ?>][phone]" value="<?php echo htmlspecialchars($row['phone']); ?>" class="form-control" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label fw-semibold small">Email Address</label>
                                            <input type="email" name="branches[<?php echo $id; ?>][email]" value="<?php echo htmlspecialchars($row['email']); ?>" class="form-control" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label fw-semibold small">Branch Address</label>
                                            <textarea name="branches[<?php echo $id; ?>][address]" class="form-control" rows="2" required><?php echo htmlspecialchars($row['address']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-muted small">No contact records found in database.</p>
                        <?php endif; ?>

                        <button type="submit" name="save_contact" class="btn btn-primary rounded-pill px-4">Save All Contact Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
