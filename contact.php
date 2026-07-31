<?php
session_start();
include '_inc/dbconn.php';

$sql = "SELECT * FROM contact_details";
$res = mysql_query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Meridian Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
</head>
<body class="bg-light">

    <?php include 'header.php'; ?>

    <main class="container my-5" style="max-width: 900px;">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h1 class="h3 fw-bold text-dark mb-1 text-center">Contact Support & Branches</h1>
            <p class="text-muted small text-center mb-4">Reach out to our dedicated support teams or visit our branch locations.</p>

            <div class="row g-4">
                <?php if ($res && mysql_num_rows($res) > 0): ?>
                    <?php while ($row = mysql_fetch_array($res)): ?>
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded-4 border h-100">
                                <h3 class="h5 fw-bold text-primary mb-3"><?php echo htmlspecialchars($row['branch_name']); ?></h3>
                                <p class="mb-2 text-muted small"><strong class="text-dark">Address:</strong> <?php echo htmlspecialchars($row['address']); ?></p>
                                <p class="mb-2 text-muted small"><strong class="text-dark">Telephone:</strong> <?php echo htmlspecialchars($row['phone']); ?></p>
                                <p class="mb-0 text-muted small"><strong class="text-dark">Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center text-muted py-4">No branch details currently available.</div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
