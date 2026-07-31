<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header('location:adminlogin.php');
    exit();
}

include '_inc/dbconn.php';

$id = isset($_REQUEST['staff_id']) ? mysql_real_escape_string($_REQUEST['staff_id']) : '';

// Handle staff deletion request
if (isset($_REQUEST['submit2_id'])) {
    if (!empty($id)) {
        $sql_delete = "DELETE FROM staff WHERE id='$id'";
        mysql_query($sql_delete) or die(mysql_error());
    }
    header('location:delete_staff.php');
    exit();
}

if (empty($id)) {
    header('location:display_staff.php');
    exit();
}

$sql = "SELECT * FROM staff WHERE id='$id'";
$result = mysql_query($sql) or die(mysql_error());
if (!$result || mysql_num_rows($result) == 0) {
    header('location:display_staff.php');
    exit();
}
$rws = mysql_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff Details - Admin Dashboard</title>
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
                    <h1 class="h4 fw-bold text-dark mb-4 border-bottom pb-2">Edit Staff Member #<?php echo $id; ?></h1>

                    <form action="alter_staff.php" method="POST">
                        <input type="hidden" name="current_id" value="<?php echo $id; ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Staff Name</label>
                                <input type="text" name="edit_name" value="<?php echo htmlspecialchars($rws['name']); ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Gender</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="edit_gender" value="M" <?php if ($rws['gender'] === 'M') echo 'checked'; ?>>
                                        <label class="form-check-label">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="edit_gender" value="F" <?php if ($rws['gender'] === 'F') echo 'checked'; ?>>
                                        <label class="form-check-label">Female</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Date of Birth</label>
                                <input type="date" name="edit_dob" value="<?php echo $rws['dob']; ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Relationship Status</label>
                                <select name="edit_status" class="form-select">
                                    <option value="unmarried" <?php if ($rws['relationship'] === 'unmarried') echo 'selected'; ?>>Unmarried</option>
                                    <option value="married" <?php if ($rws['relationship'] === 'married') echo 'selected'; ?>>Married</option>
                                    <option value="divorced" <?php if ($rws['relationship'] === 'divorced') echo 'selected'; ?>>Divorced</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Department</label>
                                <select name="edit_dept" class="form-select">
                                    <option value="revenue" <?php if ($rws['department'] === 'revenue') echo 'selected'; ?>>Revenue</option>
                                    <option value="developer" <?php if ($rws['department'] === 'developer') echo 'selected'; ?>>Developer</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Date of Joining</label>
                                <input type="date" name="edit_doj" value="<?php echo $rws['doj']; ?>" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Mobile Number</label>
                                <input type="text" name="edit_mobile" value="<?php echo htmlspecialchars($rws['mobile']); ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="edit_email" value="<?php echo htmlspecialchars($rws['email']); ?>" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Residential Address</label>
                                <textarea name="edit_address" class="form-control" rows="2" required><?php echo htmlspecialchars($rws['address']); ?></textarea>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" name="alter_staff" class="btn btn-primary rounded-pill px-4">Update Staff Details</button>
                            </div>
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
