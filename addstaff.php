<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header('location:adminlogin.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff - Admin Dashboard</title>
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
                    <h1 class="h4 fw-bold text-dark mb-4 border-bottom pb-2">Add New Staff Member</h1>

                    <form action="add_staff.php" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Staff Name</label>
                                <input type="text" name="staff_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Gender</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="staff_gender" value="M" checked>
                                        <label class="form-check-label">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="staff_gender" value="F">
                                        <label class="form-check-label">Female</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Date of Birth</label>
                                <input type="date" name="staff_dob" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Relationship Status</label>
                                <select name="staff_status" class="form-select">
                                    <option value="unmarried">Unmarried</option>
                                    <option value="married">Married</option>
                                    <option value="divorced">Divorced</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Department</label>
                                <select name="staff_dept" class="form-select">
                                    <option value="revenue">Revenue</option>
                                    <option value="developer">Developer</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Date of Joining</label>
                                <input type="date" name="staff_doj" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Mobile Number</label>
                                <input type="text" name="staff_mobile" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="staff_email" class="form-control" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="staff_pwd" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Residential Address</label>
                                <textarea name="staff_address" class="form-control" rows="2" required></textarea>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" name="add_staff" class="btn btn-primary rounded-pill px-4">Register Staff Member</button>
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
